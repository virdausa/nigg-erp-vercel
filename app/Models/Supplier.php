<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'contact_info',
        'status',
        'notes',
    ];

    /**
     * Get the products associated with the supplier through purchases.
     * This defines a many-to-many relationship with the Product model.
     *
     * The pivot table 'purchase_product' includes additional fields:
     * - quantity: the number of products purchased.
     * - buying_price: the price at which the product was bought.
     * - total_cost: the total cost for the quantity purchased.
     *
     * Timestamps are included for the pivot table entries.
     */
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'purchase_product')
    //         ->withPivot('quantity', 'buying_price', 'total_cost')
    //         ->withTimestamps();
    // }

    /**
     * Get the purchases associated with the supplier.
     *
     * This defines a one-to-many relationship with the Purchase model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
