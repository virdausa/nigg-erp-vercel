<?php
namespace App\Http\Controllers;
// use App\Http\Controllers\Permission;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class RoleController extends Controller
{
    // Menampilkan halaman daftar role
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    // Menampilkan form untuk membuat role baru
    public function create()
    {
        $permissions = Permission::all(); // Mengambil semua permissions
        return view('roles.create', compact('permissions'));
    }

    // Menyimpan role baru ke database

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array|exists:permissions,id', // Validate permission IDs
        ]);

        $role = Role::create(['name' => $request->name]);

        // Convert permission IDs to names before syncing
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }
    public function edit(Role $role)
{
    // Ambil semua permissions
    $permissions = Permission::all();

    // Kelompokkan permissions berdasarkan kata kedua
    $groupedPermissions = $permissions->groupBy(function ($permission) {
        $parts = explode(' ', $permission->name); // Pisahkan nama permission berdasarkan spasi
        return $parts[1] ?? 'others'; // Ambil kata kedua sebagai key, default 'others' jika tidak ada kata kedua
    });

    return view('roles.edit', compact('role', 'groupedPermissions'));
}

    // Mengupdate role dan permissions
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array|exists:permissions,id', // Validate permission IDs
        ]);

        $role->update(['name' => $request->name]);

        // Convert permission IDs to names before syncing
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    // Menghapus role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}