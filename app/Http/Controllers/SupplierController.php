<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $supplier = new Supplier();
        $supplier->fill($request->all());
        $supplier->save();

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->fill($request->all());
        $supplier->save();

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully');
    }
}