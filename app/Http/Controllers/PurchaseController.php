<?php

namespace App\Http\Controllers;

use App\Models\Purchase; // Ensure you import the Purchase model
use App\Models\Product;
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
		$products = Product::all();
		return view('purchases.create', compact('products'));
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
		$products = Product::all(); // All products available to select

		return view('purchases.edit', compact('purchase', 'products'));
	}


	public function update(Request $request, $id)
	{
		$request->validate([
			'supplier_name' => 'required',
			'purchase_date' => 'required|date',
			'total_amount' => 'required|numeric',
		]);

		$purchase = Purchase::findOrFail($id);
		$purchase->update($request->only('supplier_name', 'purchase_date', 'total_amount'));

		// Sync the products with quantities
		$productsData = [];
		foreach ($request->products as $productData) {
			$productsData[$productData['product_id']] = ['quantity' => $productData['quantity']];
		}
		$purchase->products()->sync($productsData);

		return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
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
