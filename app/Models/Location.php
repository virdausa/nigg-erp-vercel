<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'warehouse_id', 
        'room', 
        'rack'
    ];
	
	public function warehouse()
	{
		return $this->belongsTo(Warehouse::class);
	}

}
