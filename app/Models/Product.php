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
        'price',
    ];
	
    public function purchases()
	{
		return $this->belongsToMany(Purchase::class, 'purchase_product')
					->withPivot('quantity')
					->withTimestamps();
	}
}
