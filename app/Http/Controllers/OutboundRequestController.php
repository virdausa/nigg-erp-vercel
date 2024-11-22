<?php

namespace App\Http\Controllers;

use App\Models\OutboundRequest;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Expedition;
use App\Models\Location;
use App\Models\OutboundRequestLocation;
use Illuminate\Http\Request;

class OutboundRequestController extends Controller
{
    public function index()
    {
        $outboundRequests = OutboundRequest::with('sales', 'warehouse', 'verifier')
											->orderBy('created_at', 'desc')
											->get();
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
		$warehouses = Warehouse::all();
	
		$availableLocations = [];
		$outboundRequestLocations = [];
		foreach ($outboundRequest->requested_quantities as $productId => $quantity) {
			$availableLocations[$productId] = Location::join('inventory', 'locations.id', '=', 'inventory.location_id')
				->where('inventory.warehouse_id', $outboundRequest->warehouse_id)
				->where('inventory.product_id', $productId)
				->select('locations.id', 'locations.room', 'locations.rack', 'inventory.quantity')
				->get();
			
			$outboundRequestLocations[$productId] = OutboundRequestLocation::where('outbound_request_id', $id)
				->where('product_id', $productId)
				->get();
		}
		
		//dd($outboundRequestLocations);

		return view('outbound_requests.edit', compact('outboundRequest', 'expeditions', 'availableLocations', 'warehouses', 'outboundRequestLocations'));
	}

	public function update(Request $request, $id)
	{
		$outboundRequest = OutboundRequest::findOrFail($id);
		
		//dd($request);
		
		$validated = $request->validate([
			'packing_fee' => 'nullable|numeric|min:0',
			'expedition_id' => 'required|exists:expeditions,id',
			'tracking_number' => 'nullable|string',
			'real_volume' => 'nullable|numeric',
			'real_weight' => 'nullable|numeric',
			'real_shipping_fee' => 'nullable|numeric|min:0',
			'notes' => 'nullable|string',
			'locations' => 'array', // Validate locations as an array
			'locations.*.*.location_id' => 'nullable|exists:locations,id',
			'locations.*.*.quantity' => 'nullable|integer|min:1',
			'deleted_locations' => 'nullable|string',
		]);

		$outboundRequest->update($validated);

		// Handle deleted locations
		if (!empty($request->input('deleted_locations'))) {
			$deletedLocationIds = explode(',', rtrim($request->input('deleted_locations'), ','));
			OutboundRequestLocation::where('outbound_request_id', $id)
				->whereIn('location_id', $deletedLocationIds)
				->delete();
		}
	
		// Save or update locations
		if (isset($validated['locations'])) {
			foreach ($validated['locations'] as $productId => $locations) {
				$totalQuantity = 0;
				foreach ($locations as $locationData) {
					if (isset($locationData['location_id']) && !empty($locationData['location_id'])) {
						$qty_in_location = Inventory::where('warehouse_id', $outboundRequest->warehouse_id)
							->where('product_id', $productId)
							->where('location_id', $locationData['location_id'])
							->sum('quantity');

						// validate if qty in location is more than requested qty
						if ($qty_in_location < $locationData['quantity']) {
							return back()->withErrors(['error' => 'Quantity in location is less than requested quantity for product ID ' . $productId]);
						}

						$totalQuantity += $locationData['quantity'];

						$outboundRequestLocation = OutboundRequestLocation::updateOrCreate(
							[
								'outbound_request_id' => $outboundRequest->id,
								'product_id' => $productId,
								'location_id' => $locationData['location_id'],
							],
							[
								'quantity' => $locationData['quantity'],
							]
						);
					}
				}

				// validate if total quantity is more than requested qty
				if ($totalQuantity < $outboundRequest->requested_quantities[$productId]) {
					return back()->withErrors(['error' => 'Total quantity is less than requested quantity for product ID ' . $productId]);
				}	
			}
		}

		if (($request['submit'])) {
			$submit = $request['submit'];
	
			switch ($submit) {
				case 'Reject Request':
					$this->rejectRequest($outboundRequest);
					break;
				case 'Mark as Shipped':
					// Validate required data for shipping to change status to In Transit
					$this->updateStatus($outboundRequest, 'In Transit');
					break;
				default:
					;
			}
		}
	
		return redirect()->route('outbound_requests.index')
			->with('success', 'Outbound Request updated successfully!');
	}

	public function rejectRequest(OutboundRequest $outboundRequest)
	{
		$sales = $outboundRequest->sales;
		
		// go back status
		$sales->admin_notes .= $outboundRequest->notes;
		$sales->status = 'Planned';
		$sales->save();
		
		// destroy outbound
		$outboundRequest->delete();
		
		return redirect()->route('inventory.index')
						 ->with('success', 'Outbound Request has been rejected & deleted successfully.');
	}

	
	public function updateStatus(OutboundRequest $outboundRequest, $status)
    {
        switch ($status) {
            case 'In Transit':
                // Validate required data for transition
                $validated = request()->validate([
                    'tracking_number' => 'required|string',
                    'real_shipping_fee' => 'required|numeric|min:0',
                ]);

                $outboundRequest->update(array_merge($validated, ['status' => $status]));
				$this->updateSalesStatus($outboundRequest->sales_order_id);

                return redirect()->route('outbound_requests.edit', $outboundRequest->id)
                                 ->with('success', 'Status updated to In Transit.');
            case 'Customer Complaint':
                $outboundRequest->update(['status' => $status]);
                return redirect()->route('outbound_requests.edit', $outboundRequest->id)
                                 ->with('success', 'Status updated to Customer Complaint.');
            case 'Ready to Complete':
                // Log inventory adjustments
                foreach ($outboundRequest->requested_quantities as $productId => $quantity) {
                    Inventory::where('warehouse_id', $outboundRequest->warehouse_id)
                             ->where('product_id', $productId)
                             ->decrement('quantity', $quantity);

                    InventoryHistory::create([
                        'product_id' => $productId,
                        'warehouse_id' => $outboundRequest->warehouse_id,
                        'quantity' => -$quantity,
                        'transaction_type' => 'Outbound',
                        'notes' => "Outbound Request ID: {$outboundRequest->id}",
                    ]);
                }

                $outboundRequest->update(['status' => $status]);

                return redirect()->route('outbound_requests.edit', $outboundRequest->id)
                                 ->with('success', 'Status updated to Ready to Complete.');
            case 'Completed':
                $outboundRequest->update(['status' => $status]);
                return redirect()->route('outbound_requests.index')
                                 ->with('success', 'Outbound Request marked as Completed.');
            default:
                return redirect()->back()->with('error', 'Invalid status transition.');
        }

        return redirect()->back()->with('error', 'Invalid status transition.');
    }

	
	
	public function checkStockAvailability(OutboundRequest $outboundRequest)
	{
		$warehouse = $outboundRequest->warehouse;
		$requestedQuantities = collect($outboundRequest->requested_quantities);

		foreach ($requestedQuantities as $productId => $quantity) {
			$availableStock = Inventory::where('warehouse_id', $warehouse->id)
										->where('product_id', $productId)
										->sum('quantity');

			if ($quantity > $availableStock) {
				return redirect()->back()->withErrors([
					'error' => "Insufficient stock for product ID: $productId in warehouse {$warehouse->name}."
				]);
			}
		}

		// If stock is sufficient, proceed to the next status
		$outboundRequest->update(['status' => 'Pending Confirmation']);
		return redirect()->route('outbound_requests.edit', $outboundRequest->id)
						 ->with('success', 'Stock verified and status updated to Pending Confirmation.');
	}



	// Helper function to update sales status based on outbound requests
	private function updateSalesStatus($salesId)
	{
		$sales = Sale::with('outboundRequests')->findOrFail($salesId);
		$outboundRequests = $sales->outboundRequests;

		if ($outboundRequests->every(fn($or) => $or->status === 'Completed')) {
			// All outbound requests are completed
			$sales->status = 'Completed';
		} elseif ($outboundRequests->contains('status', 'Customer Complaint')) {
			// If any request has a customer complaint
			$sales->status = 'Customer Complaint';
		} elseif ($outboundRequests->contains('status', 'In Transit') && $outboundRequests->contains('status', 'Completed')) {
			// There’s at least one completed request, but some are still in transit
			$sales->status = 'Customer Complaint';
		} elseif ($outboundRequests->every(fn($or) => $or->status === 'Ready to Complete')) {
			// All outbound requests are ready to complete
			$sales->status = 'Ready to Complete';
		} else {
			// Default to "Planned" if none of the above conditions are met
			$sales->status = 'In Transit';
		}

		$sales->save();
	}
}
