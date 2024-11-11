<?php

namespace App\Http\Controllers;

use App\Models\InboundRequest;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;

class InboundRequestController extends Controller
{
    public function index()
    {
        $inboundRequests = InboundRequest::with('purchaseOrder', 'warehouse', 'verifier')->get();
        return view('inbound_requests.index', compact('inboundRequests'));
    }

    public function create()
    {
        // Fetch products and warehouses for the form dropdown
        $products = Product::all();
        $warehouses = Warehouse::all();
        $purchases = Purchase::all();
        return view('inbound_requests.create', compact('products', 'warehouses', 'purchases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchases,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'received_quantities' => 'required|array',
            'received_quantities.*' => 'integer|min:1',
        ]);

        InboundRequest::create([
            'purchase_order_id' => $request->purchase_order_id,
            'warehouse_id' => $request->warehouse_id,
            'received_quantities' => $request->received_quantities,
            'status' => 'Pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('inbound-requests.index')->with('success', 'Inbound request created.');
    }

    public function approve($id)
    {
        $inboundRequest = InboundRequest::findOrFail($id);
        $inboundRequest->update([
            'status' => 'Approved',
            'verified_by' => auth()->user()->id,
        ]);

        return redirect()->route('inbound-requests.index')->with('success', 'Inbound request approved.');
    }

    public function receive($id)
    {
        $inboundRequest = InboundRequest::findOrFail($id);

        foreach ($inboundRequest->received_quantities as $productId => $quantity) {
            // Add stock to the warehouse
            $inboundRequest->warehouse->products()->updateExistingPivot(
                $productId,
                ['quantity' => \DB::raw("quantity + $quantity")]
            );

            // Log in inventory history
            InventoryHistory::create([
                'product_id' => $productId,
                'warehouse_id' => $inboundRequest->warehouse_id,
                'quantity' => $quantity,
                'transaction_type' => 'Inbound',
                'notes' => 'Received from purchase order #' . $inboundRequest->purchase_order_id,
            ]);
        }

        $inboundRequest->update(['status' => 'Received']);

        return redirect()->route('inbound-requests.index')->with('success', 'Inbound request processed and products received.');
    }
}
