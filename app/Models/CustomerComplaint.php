<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerComplaint extends Model
{
    protected $fillable = [
        'sales_order_id',
        'description',
        'status',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(Sale::class, 'sales_order_id');
    }

    public function details()
    {
        return $this->hasMany(ComplaintDetail::class, 'customer_complaint_id');
    }
}

