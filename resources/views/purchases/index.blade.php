@extends('layouts.app')

@section('title', 'All Purchases')

@section('content')
    <h1>All Purchases</h1>
	<a href="{{ route('purchases.create') }}" class="btn btn-primary mb-3">Add New Purchase</a>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Supplier Name</th>
                <th>Purchase Date</th>
                <th>Total Amount</th>
				<th>Product List</th>
				<th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
				<tr>
					<td>{{ $purchase->id }}</td>
					<td>{{ $purchase->supplier_name }}</td>
					<td>{{ $purchase->purchase_date }}</td>
					<td>{{ $purchase->total_amount }}</td>
					<td>
						@foreach ($purchase->products as $product)
							{{ $product->name }} (x{{ $product->pivot->quantity }}) <br>
						@endforeach
					</td>
					<td>
						<a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning">Edit</a>
						<form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" style="display:inline;">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
						</form>
					</td>
				</tr>
			@endforeach
        </tbody>
    </table>
@endsection