<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	// Allow mass assignment for these fields
	protected $fillable = [
		'name',
		'sku',
		'weight',
		'price',
		'notes'
	];

	public function purchases()
	{
		return $this->belongsToMany(Purchase::class, 'purchase_product')
			->withPivot('quantity', 'buying_price', 'total_cost')
			->withTimestamps();
	}


	public function warehouses()
	{
		return $this->belongsToMany(Warehouse::class, 'inventory')
			->withPivot('quantity')
			->withTimestamps();
	}

	public function salesProducts()
	{
		return $this->hasMany(SalesProduct::class);
	}

	public function sales()
	{
		return $this->belongsToMany(Sale::class, 'sales_products')
			->withPivot('quantity', 'price', 'note')
			->withTimestamps();
	}
}
