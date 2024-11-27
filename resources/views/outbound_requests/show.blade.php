@extends('layouts.app')

@section('content')
    <h1>Outbound Request Details</h1>

    <!-- Basic Details -->
    <p><strong>Sales Order:</strong> {{ $outboundRequest->sales->id }}</p>
    <p><strong>Warehouse:</strong> {{ optional($outboundRequest->warehouse)->name }}</p>
    <p><strong>Status:</strong> 
        <span class="badge badge-{{ $outboundRequest->status == 'Ready to Complete' ? 'success' : 'secondary' }}">
            {{ $outboundRequest->status }}
        </span>
    </p>

    <!-- Requested Quantities -->
    <h3>Requested Quantities</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Requested Quantity</th>
                <th>Received Quantity</th>
                <th>Room</th>
                <th>Rack</th>
                <th>Location Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($outboundRequest->requested_quantities as $productId => $quantity)
                @if (isset($outboundRequestLocations[$productId]))
                    @foreach ($outboundRequestLocations[$productId] as $key => $location)
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ count($outboundRequestLocations[$productId]) }}">
                                    {{ optional($outboundRequest->sales->products->firstWhere('id', $productId))->name }}
                                </td>
                                <td rowspan="{{ count($outboundRequestLocations[$productId]) }}">
                                    {{ $quantity }}
                                </td>
                                <td rowspan="{{ count($outboundRequestLocations[$productId]) }}">
                                    {{ $outboundRequest->received_quantities[$productId] ?? 0 }}
                                </td>
                            @endif
                            <td>{{ $location->room }}</td>
                            <td>{{ $location->rack }}</td>
                            <td>{{ $location->quantity }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ optional($outboundRequest->sales->products->firstWhere('id', $productId))->name }}</td>
                        <td>{{ $quantity }}</td>
                        <td colspan="3">No locations found for this product.</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Expedition Details -->
    <h3>Expedition Details</h3>
    <p><strong>Expedition:</strong> {{ optional($outboundRequest->expedition)->name }}</p>
    <p><strong>Tracking Number:</strong> {{ $outboundRequest->tracking_number }}</p>
    <p><strong>Real Volume:</strong> {{ $outboundRequest->real_volume }} m³</p>
    <p><strong>Real Weight:</strong> {{ $outboundRequest->real_weight }} kg</p>
    <p><strong>Real Shipping Fee:</strong> {{ $outboundRequest->real_shipping_fee }}</p>

    <!-- Notes -->
    <h3>Notes</h3>
    <p>{{ $outboundRequest->notes }}</p>

    <!-- Actions -->
    @if ($outboundRequest->status == 'Ready to Complete')    
        <a href="{{ route('outbound_requests.complete', $outboundRequest->id) }}" 
           class="btn btn-primary" 
           onclick="return confirm('Are you sure you want to complete this request?')">
            Complete Request
        </a>
    @endif

    <br><br>
    <a href="{{ route('outbound_requests.index') }}" class="btn btn-secondary">Back to Outbound Requests</a>
    <a href="{{ route('outbound_requests.edit', $outboundRequest->id) }}" class="btn btn-primary">Edit Outbound Request</a>
@endsection
