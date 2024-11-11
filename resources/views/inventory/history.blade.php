@extends('layouts.app')

@section('content')
    <h2>Inventory History</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Warehouse</th>
                <th>Quantity</th>
                <th>Transaction Type</th>
                <th>Date</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $record)
                <tr>
                    <td>{{ $record->product->name }}</td>
                    <td>{{ $record->warehouse->name }}</td>
                    <td>{{ $record->quantity }}</td>
                    <td>{{ $record->transaction_type }}</td>
                    <td>{{ $record->created_at }}</td>
                    <td>{{ $record->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
