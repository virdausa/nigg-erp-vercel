<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_employee'; // Custom primary key

    protected $fillable = [
        'user_id',
        'reg_date',
        'out_date',
        'status',
        'role_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'reg_date' => 'date',
        'out_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class);
    }
}

