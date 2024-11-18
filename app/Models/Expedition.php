<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_info',
    ];

    public function outboundRequests()
    {
        return $this->hasMany(OutboundRequest::class);
    }
}
