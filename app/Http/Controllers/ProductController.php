<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Show form to create a new product
    public function create()
    {
        return view('products.create');
    }

    // Store the new product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            
            'price' => 'required|numeric|min:0',
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
	
	public function edit(Product $product)
	{
		return view('products.edit', compact('product'));
	}

	public function update(Request $request, Product $product)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'price' => 'required|numeric|min:0',
		]);

		$product->update($request->all());

		return redirect()->route('products.index')->with('success', 'Product updated successfully.');
	}

	public function destroy(Product $product)
	{
		$product->delete();

		return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
	}

}
