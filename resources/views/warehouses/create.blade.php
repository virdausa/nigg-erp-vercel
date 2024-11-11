@extends('layouts.app')

@section('title', 'Create New Warehouse')

@section('content')
    <h1>Create New Warehouse</h1>
    <form action="{{ route('warehouses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Warehouse Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location">
        </div>
        <button type="submit" class="btn btn-primary">Save Warehouse</button>
    </form>
@endsection
