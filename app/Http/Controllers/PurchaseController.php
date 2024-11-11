<?php

namespace App\Http\Controllers;

use App\Models\Purchase; // Ensure you import the Purchase model
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // Method to show all purchases
    public function index()
    {
        $purchases = Purchase::all(); // Retrieve all purchase records
        return view('purchases.index', compact('purchases')); // Pass data to the view
    }

    // You can add other methods here for creating, updating, deleting purchases as needed
	// Show form to create a new purchase
    public function create()
	{
	    $warehouses = Warehouse::all();
		$products = Product::all();
		return view('purchases.create', compact('products', 'warehouses'));
	}

    // Store the new purchase
    public function store(Request $request)
	{
		$request->validate([
			'supplier_name' => 'required',
			'purchase_date' => 'required|date',
			'total_amount' => 'required|numeric',
		]);

		$purchase = Purchase::create($request->only('supplier_name', 'purchase_date', 'total_amount'));

		// Attach products to the purchase
		foreach ($request->products as $productData) {
			$purchase->products()->attach($productData['product_id'], ['quantity' => $productData['quantity']]);
		}

		return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
	}

	
	// Show form to edit a specific purchase
	public function edit($id)
	{
		$purchase = Purchase::with('products')->findOrFail($id);
		$warehouses = Warehouse::all();
		$products = Product::all(); // Fetch all available products

		return view('purchases.edit', compact('purchase', 'warehouses', 'products'));
	}


	public function update(Request $request, $id)
	{	
		$request->validate([
			'supplier_name' => 'required',
			'purchase_date' => 'required|date',
			'total_amount' => 'required|numeric',
			'warehouse_id' => 'required|exists:warehouses,id',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.quantity' => 'required|numeric|min:1',
		]);

		$purchase = Purchase::findOrFail($id);
		$purchase->update([
			'supplier_name' => $request->supplier_name,
			'purchase_date' => $request->purchase_date,
			'total_amount' => $request->total_amount,
			'warehouse_id' => $request->warehouse_id,
		]);

		// Sync products and quantities
		$products = $request->input('products', []);
		$productQuantities = [];

		foreach ($products as $product) {
			// Check if product_id and quantity are present
			if (isset($product['product_id'], $product['quantity'])) {
				$productQuantities[$product['product_id']] = ['quantity' => $product['quantity']];
			}
		}

		// Sync products with their quantities
		$purchase->products()->sync($productQuantities);

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
	
	
	public function transferToWarehouse($purchaseId)
	{
		$purchase = Purchase::find($purchaseId);
		$warehouse = Warehouse::find($purchase->warehouse_id); // Get the assigned warehouse

		if ($warehouse && $purchase) {
			// Transfer logic (moving quantities to the warehouse)
			foreach ($purchase->products as $product) {
				$warehouse->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
			
				// Log the transfer in inventory history
				InventoryHistory::create([
					'product_id' => $product->id,
					'warehouse_id' => $warehouse->id,
					'quantity' => $product->pivot->quantity,
					'transaction_type' => 'Purchase',
					'notes' => 'Transferred from purchase order ' . $purchase->id,
				]);
			}

			// Mark purchase as transferred
			$purchase->is_transferred = true;
			$purchase->save();

			return redirect()->route('purchases.index')->with('success', 'Products transferred to warehouse successfully.');
		} else {
			return redirect()->route('purchases.index')->with('error', 'Warehouse not assigned or Purchase not found.');
		}
	}


	
	public function storeTransfer(Request $request, $id)
	{
		$request->validate([
			'warehouse_id' => 'required|exists:warehouses,id',
			'products' => 'required|array',
			'products.*' => 'required|integer|min:0',
		]);

		$purchase = Purchase::findOrFail($id);
		$warehouseId = $request->warehouse_id;

		foreach ($request->products as $productId => $quantity) {
			if ($quantity > 0) {
				$purchaseProduct = $purchase->products()->find($productId);
				if ($purchaseProduct && $purchaseProduct->pivot->quantity >= $quantity) {
					// Reduce quantity from purchase
					$purchaseProduct->pivot->quantity -= $quantity;
					$purchaseProduct->pivot->save();

					// Add quantity to warehouse inventory
					$productInWarehouse = $purchaseProduct->warehouses()->where('warehouse_id', $warehouseId)->first();
					if ($productInWarehouse) {
						// Update quantity if product already exists in the warehouse
						$productInWarehouse->pivot->quantity += $quantity;
						$productInWarehouse->pivot->save();
					} else {
						// Create new entry if product doesn't exist in the warehouse
						$purchaseProduct->warehouses()->attach($warehouseId, ['quantity' => $quantity]);
					}
				}
			}
		}

		return redirect()->route('inventory.index')->with('success', 'Products transferred to warehouse successfully.');
	}


}
