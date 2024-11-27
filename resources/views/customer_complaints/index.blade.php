@extends('layouts.app')

@section('content')
<h2>Customer Complaints</h2>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sales Order</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($complaints as $complaint)
        <tr>
            <td>{{ $complaint->id }}</td>
            <td>{{ $complaint->salesOrder->id }}</td>
            <td>{{ $complaint->status }}</td>
            <td>
                <a href="{{ route('customer_complaints.show', $complaint->id) }}" class="btn btn-info">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
