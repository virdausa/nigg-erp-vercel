@extends('layouts.app')

@section('content')
    <h1>Edit Outbound Request</h1>

    <form action="{{ route('outbound_requests.update', $outboundRequest->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h3>Products</h3>
        @foreach ($outboundRequest->sales->products as $product)
            <div class="form-group">
                <label>{{ $product->name }}</label>
                <input type="number" name="received_quantities[{{ $product->id }}]" class="form-control" 
                       placeholder="Quantity to Ship" value="{{ old('received_quantities.' . $product->id) }}">
            </div>
        @endforeach

        <h3>Shipping Details</h3>
        <div class="form-group">
            <label for="packing_fee">Packing Fee</label>
            <input type="number" name="packing_fee" class="form-control" value="{{ $outboundRequest->packing_fee }}">
        </div>
        <div class="form-group">
            <label for="shipping_fee">Shipping Fee</label>
            <input type="number" name="shipping_fee" class="form-control" value="{{ $outboundRequest->shipping_fee }}">
        </div>
        <div class="form-group">
            <label for="real_volume">Real Volume</label>
            <input type="number" name="real_volume" class="form-control" value="{{ $outboundRequest->real_volume }}">
        </div>
        <div class="form-group">
            <label for="real_weight">Real Weight</label>
            <input type="number" name="real_weight" class="form-control" value="{{ $outboundRequest->real_weight }}">
        </div>
        <div class="form-group">
            <label for="tracking_number">Tracking Number</label>
            <input type="text" name="tracking_number" class="form-control" value="{{ $outboundRequest->tracking_number }}">
        </div>

        <h3>Status</h3>
        <div class="form-group">
            <select name="status" class="form-control">
                <option value="Pending Confirmation" {{ $outboundRequest->status == 'Pending Confirmation' ? 'selected' : '' }}>Pending Confirmation</option>
                <option value="Packing & Shipping" {{ $outboundRequest->status == 'Packing & Shipping' ? 'selected' : '' }}>Packing & Shipping</option>
                <option value="In Transit" {{ $outboundRequest->status == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                <option value="Completed" {{ $outboundRequest->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Request</button>
    </form>
@endsection
