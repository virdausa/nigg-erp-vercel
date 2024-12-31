<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'weight' => 'required|numeric|min:0',
                'status' => 'required|in:Active,Inactive',
                'notes' => 'nullable|string',
            ]);

            // Create the product
            $product = Product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
                'weight' => $request->weight,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'inputs' => $request->all(),
            ]);

            // Re-throw the exception for the default Laravel error handling
            throw $e;
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected error occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('products.index')->with('error', 'An unexpected error occurred.');
        }
    }

    public function show($id)
    {
        $product = Product::with('purchases')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'weight' => 'required:numeric|min:0',
                'status' => 'required|in:Active,Inactive',
                'notes' => 'nullable|string',
            ]);

            // Update the product
            $product->update($request->all());

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'inputs' => $request->all(),
            ]);

            // Re-throw the exception for the default Laravel error handling
            throw $e;
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected error occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('products.index')->with('error', 'An unexpected error occurred.');
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
