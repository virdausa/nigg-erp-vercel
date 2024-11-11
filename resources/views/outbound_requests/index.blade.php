@extends('layouts.app')

@section('content')
    <h1>Outbound Requests</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Sales Order</th>
                <th>Warehouse</th>
                <th>Requested Quantities</th>
                <th>Status</th>
                <th>Verified By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($outboundRequests as $request)
                <tr>
                    <td>{{ $request->salesOrder->id }}</td>
                    <td>{{ $request->warehouse->name }}</td>
                    <td>
                        @foreach ($request->requested_quantities as $productId => $quantity)
                            {{ $request->warehouse->products->find($productId)->name }}: {{ $quantity }}<br>
                        @endforeach
                    </td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->verifier ? $request->verifier->name : 'N/A' }}</td>
                    <td>
                        @if($request->status == 'Pending')
                            <form action="{{ route('outbound-requests.approve', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        @endif
                        @if($request->status == 'Approved')
                            <form action="{{ route('outbound-requests.execute', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">Ship</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
