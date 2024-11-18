@extends('layouts.app')

@section('content')
    <h1>Edit Outbound Request</h1>

    <form action="{{ route('outbound_requests.update', $outboundRequest->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Warehouse and Requested Products -->
        <div class="form-group">
            <label for="warehouse_id">Warehouse</label>
            <input type="text" class="form-control" value="{{ $outboundRequest->warehouse->name }}" disabled>
        </div>
		
		<div class="form-group">
            <label for="status">Outbound Status</label>
            <input type="text" class="form-control" name="status" value="{{ $outboundRequest->status }}" readonly>
        </div>

        <h3>Requested Products</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Requested Quantity</th>
					<th>Stock in Warehouse</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outboundRequest->requested_quantities as $productId => $quantity)
                    <tr>
                        <td>{{ $outboundRequest->sales->products->find($productId)->name }}</td>
                        <td>{{ $quantity }}</td>
						<td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

		<div class="form-group">
            <label for="admin_notes">Sales Notes</label>
            <textarea name="admin_notes" class="form-control">{{ $outboundRequest->sales->admin_notes }}</textarea>
        </div>
	
		<div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control" placeholder="Optional notes">{{ $outboundRequest->notes }}</textarea>
        </div>

        <!-- Action Buttons -->
        <h3>Actions</h3>
        @if ($outboundRequest->status == 'Requested')
            <a href="{{ route('outbound_requests.checkStock', $outboundRequest->id) }}" class="btn btn-primary">
                Verify Stock & Approve
            </a>
            <a href="{{ route('outbound_requests.reject', $outboundRequest->id) }}" class="btn btn-danger">
                Reject Request
            </a>
        @endif
        @if ($outboundRequest->status == 'Packing & Shipping')
            <button type="submit" class="btn btn-success">Mark as Shipped</button>
        @endif

		<br><br>
		<button type="submit" class="btn btn-primary">Update Outbound Request</button>
        <a href="{{ route('outbound_requests.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
@endsection
