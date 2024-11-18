{{-- resources/views/suppliers/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create New Supplier')

@section('content')
<h1>Create New Supplier</h1>
<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Supplier Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" name="location" class="form-control">
    </div>
    <div class="form-group">
        <label for="contact_info">Contact Info</label>
        <input type="text" name="contact_info" class="form-control">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>
    <div class="form-group">
        <label for="notes">Note</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Create Supplier</button>
</form>
@endsection