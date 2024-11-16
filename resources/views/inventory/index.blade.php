@extends('layouts.app')

@section('content')
    <h1>Inventory</h1>
    <a href="{{ route('inventory.adjustForm') }}" class="btn btn-primary mb-3">Adjust Inventory</a>
    <a href="{{ route('inventory.history') }}" class="btn btn-secondary mb-3">Inventory History</a>

    <!-- Filters -->
    <form method="GET" action="{{ route('inventory.index') }}">
        <input class="form-control mb-3" type="text" name="search" placeholder="Search by product or warehouse" value="{{ request()->query('search') }}">
        <button type="submit" class="btn btn-primary mb-3">Search</button>
    </form>

    <!-- Overall Stock -->
    <h2>Stock Overview</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Available Stock</th>
                <th>Incoming Stock</th>
                <th>Outgoing Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->product->name }}</td>
                    <td>{{ $inventory->quantity }}</td>
                    <td>0</td> <!-- Replace with logic for incoming -->
                    <td>0</td> <!-- Replace with logic for outgoing -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Stock by Location -->
    <h2>Stock by Location</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Warehouse</th>
                <th>Product</th>
                <th>Room</th>
                <th>Rack</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventoryByLocations as $locationStock)
                <tr>
                    <td>{{ $locationStock->warehouse->name }}</td>
                    <td>{{ $locationStock->product->name }}</td>
                    <td>{{ $locationStock->location->room ?? 'N/A' }}</td>
                    <td>{{ $locationStock->location->rack ?? 'N/A' }}</td>
                    <td>{{ $locationStock->total_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
