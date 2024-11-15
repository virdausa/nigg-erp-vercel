@extends('layouts.app')

@section('content')
    <h2>Inbound Requests</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Purchase Order</th>
                <th>Warehouse</th>
                <th>Status</th>
                <th>Requested Quantities</th>
                <th>Verified By</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inboundRequests as $request)
                <tr>
                    <td>{{ $request->purchase->id }}</td>
                    <td>{{ $request->warehouse->name }}</td>
                    <td>{{ $request->status }}</td>
                    <td>
                        @foreach($request->received_quantities as $productId => $qty)
                            {{ $productId }}: {{ $request->requested_quantities[$productId] }} / {{ $qty }}<br>
                        @endforeach
                    </td>
                    <td>{{ optional($request->verifier)->name }}</td>
                    <td>{{ $request->notes }}</td>
					<td>
						<a href="{{ route('inbound_requests.show', $request->id) }}" class="btn btn-info">Show</a>
						@if ($request->status !== 'Completed')
							<a href="{{ route('inbound_requests.edit', $request->id) }}" class="btn btn-primary">Update</a>
						@endif
					</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
