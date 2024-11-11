@extends('layouts.app')

@section('content')
    <h1>Inventory Dashboard</h1>

    @foreach($warehouses as $warehouse)
        <h2>{{ $warehouse->name }} ({{ $warehouse->location }})</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warehouse->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No products in inventory.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach
@endsection
