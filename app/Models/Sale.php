<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'sale_date', 'total_amount', 'warehouse_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sales_products')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
