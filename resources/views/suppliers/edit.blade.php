@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<h1>Edit Supplier</h1>
<form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Supplier Name</label>
        <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
    </div>
    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" name="location" class="form-control" value="{{ $supplier->location }}">
    </div>
    <div class="form-group">
        <label for="contact_info">Contact Info</label>
        <input type="text" name="contact_info" class="form-control" value="{{ $supplier->contact_info }}">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control">
            <option value="Active" {{ $supplier->status == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $supplier->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="form-group">
        <label for="notes">Note</label>
        <textarea name="notes" class="form-control" rows="3">{{ $supplier->notes }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Supplier</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection