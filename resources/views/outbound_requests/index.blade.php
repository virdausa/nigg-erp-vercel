@extends('layouts.app')

@section('content')
    <h1>Outbound Requests</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Sales Order</th>
                <th>Warehouse</th>
                <th>Status</th>
                <th>Requested Quantities</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($outboundRequests as $request)
                <tr>
                    <td>{{ $request->sales->id }}</td>
                    <td>{{ $request->warehouse->name }}</td>
                    <td>{{ $request->status }}</td>
                    <td>
                        @foreach ($request->received_quantities as $productId => $quantity)
                            {{ $request->sales->products->find($productId)->name }}: {{ $request->requested_quantities[$productId] }} / {{ $quantity }}<br>
                        @endforeach
                    </td>
                    <td>{{ $request->notes }}</td>
                    <td>
						<a href="{{ route('outbound_requests.show', $request->id) }}" class="btn btn-info">Show</a>
						@if ($request->status != 'Ready to Complete' && $request->status != 'Completed')
							<a href="{{ route('outbound_requests.edit', $request->id) }}" class="btn btn-primary">Update</a>
						@endif
					</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
