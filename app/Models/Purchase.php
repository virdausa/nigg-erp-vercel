<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'supplier_name',
        'purchase_date',
        'total_amount',
    ];
	
	public function products()
	{
		return $this->belongsToMany(Product::class, 'purchase_product')
					->withPivot('quantity')
					->withTimestamps();
	}
}
