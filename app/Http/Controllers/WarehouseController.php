<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
	{
		$warehouses = Warehouse::all();
		return view('warehouses.index', compact('warehouses'));
	}

	public function create()
	{
		return view('warehouses.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'location' => 'nullable|string|max:255',
		]);

		Warehouse::create($request->all());

		return redirect()->route('warehouses.index')->with('success', 'Warehouse created successfully.');
	}

	public function edit(Warehouse $warehouse)
	{
		return view('warehouses.edit', compact('warehouse'));
	}

	public function update(Request $request, Warehouse $warehouse)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'location' => 'nullable|string|max:255',
		]);

		$warehouse->update($request->all());

		return redirect()->route('warehouses.index')->with('success', 'Warehouse updated successfully.');
	}

	public function destroy(Warehouse $warehouse)
	{
		$warehouse->delete();

		return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted successfully.');
	}

}
