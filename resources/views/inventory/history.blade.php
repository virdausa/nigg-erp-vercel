@extends('layouts.app')

@section('title', 'Inventory History')

@section('content')
    <h1>Inventory History</h1>
	
    <a href="{{ route('inventory.index') }}" class="btn btn-secondary mb-3">Back to Inventory</a>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Warehouse</th>
                <th>Quantity</th>
                <th>Transaction Type</th>
                <th>Room</th>
                <th>Rack</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $entry)
                <tr>
                    <td>{{ $entry->created_at }}</td>
                    <td>{{ $entry->product->name }}</td>
                    <td>{{ $entry->warehouse->name }}</td>
                    <td>{{ $entry->quantity }}</td>
                    <td>{{ $entry->transaction_type }}</td>
                    <td>{{ $entry->location->room ?? 'N/A' }}</td>
                    <td>{{ $entry->location->rack ?? 'N/A' }}</td>
                    <td>{{ $entry->notes ?? 'No notes' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
