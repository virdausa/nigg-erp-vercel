<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
	{
		$sales = Sale::with('warehouse')->orderBy('sale_date', 'desc')->get();
		return view('sales.index', compact('sales'));
	}

	
	public function create()
	{
		$products = Product::all();
		$warehouses = Warehouse::all();
		return view('sales.create', compact('products', 'warehouses'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'customer_name' => 'required|string|max:255',
			'sale_date' => 'required|date',
			'warehouse_id' => 'required|exists:warehouses,id',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.quantity' => 'required|integer|min:1',
			'products.*.price' => 'required|numeric|min:0',
		]);

		// Create sale
		$sale = Sale::create([
			'customer_name' => $request->customer_name,
			'sale_date' => $request->sale_date,
			'total_amount' => 0,
			'warehouse_id' => $request->warehouse_id,
		]);

		$totalAmount = 0;
		foreach ($request->products as $product) {
			$totalAmount += $product['quantity'] * $product['price'];
			$sale->products()->attach($product['product_id'], [
				'quantity' => $product['quantity'],
				'price' => $product['price']
			]);
		}

		// Update total amount
		$sale->update(['total_amount' => $totalAmount]);

		return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
	}


	public function edit($id)
	{
		$sale = Sale::with('products')->findOrFail($id);
		$products = Product::all();
		$warehouses = Warehouse::all();
		return view('sales.edit', compact('sale', 'products', 'warehouses'));
	}


	public function update(Request $request, $id)
	{
		$request->validate([
			'customer_name' => 'required|string|max:255',
			'sale_date' => 'required|date',
			'warehouse_id' => 'required|exists:warehouses,id',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.quantity' => 'required|integer|min:1',
			'products.*.price' => 'required|numeric|min:0',
		]);

		$sale = Sale::findOrFail($id);
		$sale->update([
			'customer_name' => $request->customer_name,
			'sale_date' => $request->sale_date,
			'warehouse_id' => $request->warehouse_id,
		]);

		// Sync products with updated quantities and prices
		$productData = [];
		foreach ($request->products as $product) {
			$productData[$product['product_id']] = [
				'quantity' => $product['quantity'],
				'price' => $product['price'],
			];
		}
		$sale->products()->sync($productData);

		// Update total amount
		$totalAmount = $sale->products->sum(function ($product) {
			return $product->pivot->quantity * $product->pivot->price;
		});
		$sale->update(['total_amount' => $totalAmount]);

		return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
	}
	
	public function destroy($id)
	{
		$sale = Sale::findOrFail($id);
		$sale->delete();

		return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
	}


}
