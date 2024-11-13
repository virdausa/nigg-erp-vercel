@extends('layouts.app')

@section('content')
    <h1>Inbound Request Details</h1>

    <p><strong>Warehouse:</strong> {{ $inboundRequest->warehouse->name }}</p>
    <p><strong>Status:</strong> {{ $inboundRequest->status }}</p>

    <h3>Products</h3>
    <ul>
        @foreach ($inboundRequest->purchase->products as $product)
            <li>
                <strong>{{ $product->name }}</strong><br>
                Requested Quantity: {{ $inboundRequest->requested_quantities[$product->id] ?? 0 }}<br>
                Received Quantity: {{ $inboundRequest->received_quantities[$product->id] ?? 0 }}
            </li>
        @endforeach
    </ul>

    @if ($inboundRequest->status !== 'Completed')
        <a href="{{ route('inbound_requests.complete', $inboundRequest->id) }}" class="btn btn-primary">Complete Inbound Request</a>
    @else
        <p>This inbound request is completed and cannot be modified.</p>
    @endif

    <a href="{{ route('inbound_requests.index') }}" class="btn btn-secondary">Back to Inbound Requests</a>
@endsection
