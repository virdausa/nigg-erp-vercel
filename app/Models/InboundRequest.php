<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboundRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'warehouse_id',
		'requested_quantities',
        'received_quantities',
        'status',
        'verified_by',
        'notes',
    ];

    protected $casts = [
		'received_quantities' => 'array',
		'requested_quantities' => 'array', // Add this line
	];


    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_order_id');
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
