@extends('layouts.app')

@section('content')
    <h2>Update Inbound Request</h2>

    <form action="{{ route('inbound_requests.update', $inboundRequest->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="purchase_order_id">Purchase Order</label>
            <input type="text" class="form-control" name="purchase_order_id" value="{{ $inboundRequest->purchase->id }}" readonly>
        </div>

        <div class="form-group">
            <label for="warehouse_id">Warehouse</label>
            <input type="text" class="form-control" name="warehouse_id" value="{{ $inboundRequest->warehouse->name }}" readonly>
        </div>

        <div class="form-group">
            <label for="status">Inbound Request Status</label>
            <select name="status" class="form-control" required>
                <option value="In Transit" {{ $inboundRequest->status == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                <option value="Received - Pending Verification" {{ $inboundRequest->status == 'Received - Pending Verification' ? 'selected' : '' }}>Received - Pending Verification</option>
                <option value="Quantity Discrepancy" {{ $inboundRequest->status == 'Quantity Discrepancy' ? 'selected' : '' }}>Quantity Discrepancy</option>
                <option value="Completed" {{ $inboundRequest->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <h3>Products</h3>
		@foreach($inboundRequest->purchase->products as $product)
			@if(isset($inboundRequest->requested_quantities[$product->id]) && $inboundRequest->requested_quantities[$product->id] > 0)
				<div class="form-group">
					<label>{{ $product->name }}</label>
					
					<!-- Display Requested Quantity -->
					<div>
						<label>Requested Quantity</label>
						<input type="number" class="form-control" value="{{ $inboundRequest->requested_quantities[$product->id] }}" readonly>
					</div>
					
					<!-- Editable Received Quantity -->
					<div>
						<label>Received Quantity</label>
						<input type="number" name="received_quantities[{{ $product->id }}]" class="form-control" min="0" value="{{ $inboundRequest->received_quantities[$product->id] ?? 0 }}">
					</div>
				</div>
			@endif
		@endforeach


        <div class="form-group">
            <label for="verified_by">Verified By</label>
            <select name="verified_by" class="form-control">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $inboundRequest->verified_by == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control" placeholder="Optional notes">{{ $inboundRequest->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Inbound Request</button>
        <a href="{{ route('inbound_requests.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
