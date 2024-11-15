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
			<label for="arrival_date">Arrival Date</label>
			<input type="date" class="form-control" name="arrival_date" 
				   value="{{ $inboundRequest->arrival_date ? $inboundRequest->arrival_date : '' }}"
				   {{ $inboundRequest->status == 'In Transit' ? '' : 'disabled' }}>
		</div>

        <div class="form-group">
            <label for="status">Inbound Request Status</label>
			<input type="text" class="form-control" name="status" value="{{ $inboundRequest->status }}" readonly>
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
						<input type="number" name="received_quantities[{{ $product->id }}]" class="form-control" min="0" value="{{ $inboundRequest->received_quantities[$product->id] ?? 0 }}" {{ $inboundRequest->status == 'Received - Pending Verification' ? '' : 'readonly' }}>
					</div>
				</div>
			@endif
		@endforeach

		<!-- New Check Quantities Button -->
		@if($inboundRequest->status == 'Received - Pending Verification')
			<button type="submit" class="btn btn-warning" name="action" value="check_quantities">Check Quantities</button>
		@endif

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
