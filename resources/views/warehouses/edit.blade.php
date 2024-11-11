@extends('layouts.app')

@section('title', 'Edit Warehouse')

@section('content')
    <h1>Edit Warehouse</h1>
    <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- This is required to specify an update request -->

        <div class="form-group">
            <label for="name">Warehouse Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $warehouse->name }}" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $warehouse->location }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Warehouse</button>
    </form>
@endsection
