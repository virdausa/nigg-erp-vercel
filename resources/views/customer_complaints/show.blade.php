@extends('layouts.app')

@section('content')
<h2>Resolve Complaint #{{ $customerComplaint->id }}</h2>

<h4>Sales Order: #{{ $customerComplaint->salesOrder->id }}</h4>

<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customerComplaint->details as $detail)
        <tr>
            <td>{{ $detail->product->name }}</td>
            <td>{{ $detail->type }}</td>
            <td>{{ $detail->quantity }}</td>
            <td>{{ $detail->description }}</td>
            <td>
                <form action="{{ route('customer_complaints.resolve', $customerComplaint->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="details[{{ $detail->id }}][id]" value="{{ $detail->id }}">
                    <select name="details[{{ $detail->id }}][action]" class="form-control" required>
                        <option value="Resolve">Resolve</option>
                        <option value="Resend">Resend</option>
                        <option value="Return">Return</option>
                    </select>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
