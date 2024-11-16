@extends('layouts.app')

@section('title', 'Warehouse List')

@section('content')
    <h1>Warehouse List</h1>
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary mb-3">Add New Warehouse</a>
	<a href="{{ route('locations.index') }}" class="btn btn-secondary mb-3">Manage Location</a>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($warehouses as $warehouse)
                <tr>
                    <td>{{ $warehouse->id }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->location }}</td>
                    <td>
                        <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
