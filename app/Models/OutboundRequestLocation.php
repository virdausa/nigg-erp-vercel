<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutboundRequestLocation extends Model
{
	protected $fillable = [
		'outbound_request_id',
		'location_id',
		'product_id',
		'room',
		'rack',
		'quantity',
	];

	public function outboundRequest()
	{
		return $this->belongsTo(OutboundRequest::class);
	}
}
