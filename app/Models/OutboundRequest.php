<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutboundRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order_id',
        'warehouse_id',
        'requested_quantities',
        'status',
        'verified_by',
        'notes',
    ];

    protected $casts = [
        'requested_quantities' => 'array',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(Sale::class, 'sales_order_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
