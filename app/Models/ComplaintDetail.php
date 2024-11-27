<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintDetail extends Model
{
    protected $fillable = [
        'customer_complaint_id',
        'product_id',
        'type',
        'quantity',
        'description',
    ];

    public function complaint()
    {
        return $this->belongsTo(CustomerComplaint::class, 'customer_complaint_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

