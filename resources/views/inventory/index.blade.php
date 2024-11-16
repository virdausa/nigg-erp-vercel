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

	<h2>Stock Overview</h2>
	<table class="table table-bordered">
		<thead class="thead-dark">
			<tr>
				<th>Product</th>
				<th>Available Stock</th>
				<th>Incoming Stock</th>
				<th>Outgoing Stock</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($stockDetails['availableStock'] as $productId => $available)
				<tr>
					<td>{{ $inventories->firstWhere('product_id', $productId)->product->name ?? 'Unknown Product' }}</td>
					<td>{{ $available }}</td>
					<td>{{ $stockDetails['incomingStock'][$productId] ?? 0 }}</td>
					<td>{{ $stockDetails['outgoingStock'][$productId] ?? 0 }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
    <!-- Inventory Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Warehouse</th>
                <th>Product</th>
                <th>Room</th>
                <th>Rack</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->warehouse->name }}</td>
                    <td>{{ $inventory->product->name }}</td>
                    <td>{{ $inventory->location->room ?? 'N/A' }}</td>
                    <td>{{ $inventory->location->rack ?? 'N/A' }}</td>
                    <td>{{ $inventory->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
