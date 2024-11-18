<?php

namespace App\Http\Controllers;

use App\Models\OutboundRequest;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Sale;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;

class OutboundRequestController extends Controller
{
    public function index()
    {
        $outboundRequests = OutboundRequest::with('sales', 'warehouse', 'verifier')->get();
        return view('outbound_requests.index', compact('outboundRequests'));
    }

    public function create()
    {
        // Fetch products and warehouses for the form dropdown
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('outbound_requests.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
			'sales_order_id' => 'required|exists:sales,id',
			'warehouse_id' => 'required|exists:warehouses,id',
			'requested_quantities' => 'required|array',
			'requested_quantities.*' => 'required|integer|min:1',
			'notes' => 'nullable|string',
		]);

        OutboundRequest::create([
			'sales_order_id' => $validated['sales_order_id'],
			'warehouse_id' => $validated['warehouse_id'],
			'requested_quantities' => $validated['requested_quantities'],
			'received_quantities' => [],
			'status' => 'Requested',
			'notes' => $validated['notes'] ?? null,
		]);

        return redirect()->route('outbound_requests.index')->with('success', 'Outbound request created.');
    }

	public function edit($id)
	{
		$outboundRequest = OutboundRequest::with('sales', 'warehouse')->findOrFail($id);
		$expeditions = Expedition::all(); // Fetch expeditions
		return view('outboundRequests.edit', compact('outboundRequest', 'expeditions'));
	}

	public function update(Request $request, $id)
	{
		$validated = $request->validate([
			'expedition_id' => 'required|exists:expeditions,id',
			'real_shipping_fee' => 'required|numeric|min:0',
			'tracking_number' => 'nullable|string',
			'real_volume' => 'nullable|numeric',
			'real_weight' => 'nullable|numeric',
		]);

		$outboundRequest = OutboundRequest::findOrFail($id);
		$outboundRequest->update($validated);

		return redirect()->route('outboundRequests.index')->with('success', 'Outbound Request updated successfully!');
	}

    public function approve($id)
    {
        $outboundRequest = OutboundRequest::findOrFail($id);
        $outboundRequest->update([
            'status' => 'Approved',
            'verified_by' => auth()->user()->id,
        ]);

        return redirect()->route('outbound-requests.index')->with('success', 'Outbound request approved.');
    }

    public function execute($id)
    {
        $outboundRequest = OutboundRequest::findOrFail($id);

        foreach ($outboundRequest->requested_quantities as $productId => $quantity) {
            // Deduct stock from the warehouse
            $outboundRequest->warehouse->products()->updateExistingPivot(
                $productId,
                ['quantity' => \DB::raw("quantity - $quantity")]
            );

            // Log in inventory history
            InventoryHistory::create([
                'product_id' => $productId,
                'warehouse_id' => $outboundRequest->warehouse_id,
                'quantity' => -$quantity,
                'transaction_type' => 'Outbound',
                'notes' => 'Shipped for sales order #' . $outboundRequest->sales_order_id,
            ]);
        }

        $outboundRequest->update(['status' => 'Shipped']);

        return redirect()->route('outbound-requests.index')->with('success', 'Outbound request executed and products shipped.');
    }
}
