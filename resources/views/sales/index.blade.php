@extends('layouts.app')

@section('content')
    <h1>Sales Orders</h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Add New Sale</a>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Customer</th>
                <th>Sale Date</th>
                <th>Warehouse</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->customer_name }}</td>
                    <td>{{ $sale->sale_date }}</td>
                    <td>{{ $sale->warehouse->name }}</td>
                    <td>${{ $sale->total_amount }}</td>
                    <td>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
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
