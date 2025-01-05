<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;  // Pastikan Role diimport

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

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class);  // Menghubungkan dengan Role
    }

    // Mengakses permissions yang terkait dengan role
    public function permissions()
    {
        return $this->role->permissions;  // Mengakses permissions yang dimiliki oleh role
    }

    // Menambahkan metode untuk memeriksa permission langsung dari role
    public function can($permission)
    {
        return $this->permissions()->contains('name', $permission);  // Memeriksa apakah role memiliki permission
    }
}
