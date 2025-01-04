<?php

namespace App\Http\Controllers;

use App\Models\Purchase; // Ensure you import the Purchase model
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\InventoryHistory;
use App\Models\InboundRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
	// Method to show all purchases
	public function index()
	{
		//$purchases = Purchase::all(); // Retrieve all purchase records
		$purchases = Purchase::with('inboundRequests')->orderBy('id', 'desc')->get();
		return view('purchases.index', compact('purchases')); // Pass data to the view
	}

	// You can add other methods here for creating, updating, deleting purchases as needed
	// Show form to create a new purchase
	public function create()
	{
		$suppliers = Supplier::all();
		$warehouses = Warehouse::all();
		$products = Product::all();
		return view('purchases.create', compact('products', 'warehouses', 'suppliers'));
	}


	// Store the new purchase
	public function store(Request $request)
	{
		// dd($request->all());
		$request->validate([
			'supplier_id' => 'required|exists:suppliers,id',
			'purchase_date' => 'required|date',
			'warehouse_id' => 'required|exists:warehouses,id',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.quantity' => 'required|numeric|min:1',
			'products.*.buying_price' => 'required|numeric|min:0',
		]);

		$totalAmount = 0;
		foreach ($request->products as $productData) {
			$totalAmount += $productData['quantity'] * $productData['buying_price'];
		}

		$purchase = Purchase::create([
			'supplier_id' => $request->supplier_id,
			'purchase_date' => $request->purchase_date,
			'warehouse_id' => $request->warehouse_id,
			'total_amount' => $totalAmount,
			'status' => 'Planned',
		]);

		foreach ($request->products as $productData) {
			$purchase->products()->attach($productData['product_id'], [
				'quantity' => $productData['quantity'],
				'buying_price' => $productData['buying_price'],
				'total_cost' => $productData['quantity'] * $productData['buying_price']
			]);
		}

		return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
	}


	public function show($id)
	{
		$purchase = Purchase::with(['products', 'warehouse', 'inboundRequests'])->findOrFail($id);
		return view('purchases.show', compact('purchase'));
	}


	// Show form to edit a specific purchase
	public function edit($id)
	{
		$suppliers = Supplier::all();
		$purchase = Purchase::with('products')->findOrFail($id);
		$warehouses = Warehouse::all();
		$products = Product::all(); // Fetch all available products

		return view('purchases.edit', compact('purchase', 'warehouses', 'products', 'suppliers'));
	}


	public function update(Request $request, $id)
	{
		$request->validate([
			'supplier_id' => 'required',
			'purchase_date' => 'required|date',
			'warehouse_id' => 'required|exists:warehouses,id',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.quantity' => 'required|numeric|min:1',
			'products.*.buying_price' => 'required|numeric|min:0',
			'shipped_date' => 'nullable|date', // new field for shipped date
			'expedition' => 'nullable|string', // new field for expedition
			'tracking_no' => 'nullable|string', // new field for tracking number
		]);

		$purchase = Purchase::findOrFail($id);
		$purchase->update([
			'supplier_id' => $request->supplier_id,
			'purchase_date' => $request->purchase_date,
			'warehouse_id' => $request->warehouse_id,
			'notes' => $request->notes,
			'shipped_date' => $request->shipped_date,
			'expedition' => $request->expedition,
			'tracking_no' => $request->tracking_no,
		]);

		// Automatically set status to "In Transit" if shipment details are filled
		if ($purchase->status == 'Planned' && $request->shipped_date && $request->expedition && $request->tracking_no) {
			$purchase->status = 'In Transit';
			$purchase->save();

			// Create an inbound request when moving to "In Transit"
			$requestedQuantities = [];
			foreach ($purchase->products as $product) {
				$requestedQuantities[$product->id] = $product->pivot->quantity;
			}

			InboundRequest::create([
				'purchase_order_id' => $purchase->id,
				'warehouse_id' => $purchase->warehouse_id,
				'requested_quantities' => $requestedQuantities,
				'received_quantities' => [],
				'status' => 'In Transit',
				'notes' => 'Inbound request created upon status change to In Transit',
			]);
		}

		$totalAmount = 0;

		$productQuantities = [];
		foreach ($request->products as $product) {
			$quantity = $product['quantity'];
			$buyingPrice = $product['buying_price'];
			$totalCost = $quantity * $buyingPrice;

			$productQuantities[$product['product_id']] = [
				'quantity' => $quantity,
				'buying_price' => $buyingPrice,
				'total_cost' => $totalCost,
			];

			$totalAmount += $totalCost;
		}

		// Sync products with updated pivot data
		$purchase->products()->sync($productQuantities);

		// Update total amount
		$purchase->total_amount = $totalAmount;
		$purchase->save();

		return redirect()->route('purchases.index')
			->with('success', 'Purchase updated successfully.');
	}



	// Delete a specific purchase
	public function destroy($id)
	{
		$purchase = Purchase::findOrFail($id);
		$purchase->delete();

		return redirect()->route('purchases.index')
			->with('success', 'Purchase deleted successfully.');
	}
}
