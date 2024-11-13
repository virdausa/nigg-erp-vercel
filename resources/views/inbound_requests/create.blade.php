@extends('layouts.app')

@section('content')
    <h2>Create Inbound Request</h2>

    <form action="{{ route('inbound_requests.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="purchase_order_id">Purchase Order</label>
            <input type="text" class="form-control" name="purchase_order_id" value="{{ $purchase->id }}" readonly>
        </div>

        <div class="form-group">
            <label for="warehouse_id">Select Warehouse</label>
            <select name="warehouse_id" class="form-control" required>
                <option value="{{ $purchase->warehouse_id }}" selected>{{ $purchase->warehouse->name }}</option>
            </select>
        </div>

        <h3>Received Quantities</h3>
        @foreach($purchase->products as $product)
            <div class="form-group">
                <label for="received_quantities[{{ $product->id }}]">{{ $product->name }}</label>
                <input type="number" name="received_quantities[{{ $product->id }}]" class="form-control" min="0" placeholder="Enter quantity received">
            </div>
        @endforeach

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control" placeholder="Optional notes"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Inbound Request</button>
        <a href="{{ route('inbound_requests.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
