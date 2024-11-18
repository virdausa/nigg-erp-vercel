@extends('layouts.app')

@section('title', 'Supplier List')

@section('content')
<h1>Supplier List</h1>
<a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Add New Supplier</a>
<table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Location</th>
            <th>Contact Info</th>
            <th>Status</th>
            <th>Note</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->id }}</td>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->location }}</td>
            <td>{{ $supplier->contact_info }}</td>
            <td>{{ $supplier->status }}</td>
            <td>{{ $supplier->notes }}</td>
            <td>
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
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
