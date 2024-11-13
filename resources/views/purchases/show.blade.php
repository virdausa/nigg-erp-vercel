@extends('layouts.app')

@section('title', 'Purchase Details')

@section('content')
    <h1>Purchase Details</h1>

    <div class="mb-3">
        <label><strong>Supplier Name:</strong></label>
        <span>{{ $purchase->supplier_name }}</span>
    </div>

    <div class="mb-3">
        <label><strong>Purchase Date:</strong></label>
        <span>{{ $purchase->purchase_date }}</span>
    </div>

    <div class="mb-3">
        <label><strong>Warehouse:</strong></label>
        <span>{{ $purchase->warehouse->name ?? 'N/A' }}</span>
    </div>

    <div class="mb-3">
        <label><strong>Total Amount:</strong></label>
        <span>${{ number_format($purchase->total_amount, 2) }}</span>
    </div>

    <div class="mb-3">
        <label><strong>Status:</strong></label>
        <span class="badge badge-info">{{ $purchase->status }}</span>
    </div>

    <h3>Products</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Buying Price</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>${{ number_format($product->pivot->buying_price, 2) }}</td>
                    <td>${{ number_format($product->pivot->total_cost, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mb-3">
        <label><strong>Notes:</strong></label>
        <p>{{ $purchase->notes ?? 'No additional notes' }}</p>
    </div>

	<h3>Inbound Request Status</h3>

	@if ($purchase->inboundRequests && $purchase->inboundRequests->isNotEmpty())
		@foreach ($purchase->inboundRequests as $inboundRequest)
			<div class="mb-3">
				<p><strong>Status:</strong> <span class="badge badge-info">{{ $inboundRequest->status }}</span></p>
				<p><strong>Requested Quantities:</strong></p>
				<ul>
					@foreach ($inboundRequest->requested_quantities as $productId => $quantity)
						<li>{{ $purchase->products->firstWhere('id', $productId)->name }}: {{ $quantity }}</li>
					@endforeach
				</ul>
				<p><strong>Received Quantities:</strong></p>
				<ul>
					@foreach ($inboundRequest->received_quantities as $productId => $quantity)
						<li>{{ $purchase->products->firstWhere('id', $productId)->name }}: {{ $quantity }}</li>
					@endforeach
				</ul>
				<p><strong>Notes:</strong> {{ $inboundRequest->notes }}</p>

				{{-- Buttons for handling quantity discrepancy --}}
				@if ($inboundRequest->status == 'Quantity Discrepancy')
					<h4>Handle Quantity Discrepancy</h4>
					<form action="{{ route('inbound_requests.handleDiscrepancyAction', $inboundRequest->id) }}" method="POST">
						@csrf
						<button name="action" value="accept_partial" class="btn btn-primary">Accept Partial Shipment</button>
						<button name="action" value="request_additional" class="btn btn-warning">Request Additional Shipment</button>
						<button name="action" value="record_excess" class="btn btn-success">Record Excess as Extra Stock</button>
					</form>
				@endif
			</div>
		@endforeach
	@else
		<p>No Inbound Request</p>
	@endif



    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Back to Purchases</a>
@endsection
