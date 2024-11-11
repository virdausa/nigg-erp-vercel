<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
	{
		$warehouses = Warehouse::with(['products' => function($query) {
			$query->select('products.id', 'products.name', 'product_warehouse.quantity');
		}])->get();

		return view('inventory.index', compact('warehouses'));
	}

	public function history()
	{
		$history = InventoryHistory::with('product', 'warehouse')->orderBy('created_at', 'desc')->get();
		return view('inventory.history', compact('history'));
	}

}
