@extends('layouts.app')

@section('content')
    <h1>Create Outbound Request</h1>
    <form action="{{ route('outbound-requests.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="sales_order_id">Sales Order ID</label>
            <input type="text" name="sales_order_id" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="warehouse_id">Warehouse</label>
            <select name="warehouse_id" class="form-control">
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>
        <div id="product-section">
            <h3>Requested Products</h3>
            <div class="form-group">
                <label for="product_id">Product</label>
                <select name="requested_quantities[0][product_id]" class="form-control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <label for="quantity">Quantity</label>
                <input type="number" name="requested_quantities[0][quantity]" class="form-control" min="1" required>
            </div>
        </div>
        <button type="button" id="add-product" class="btn btn-secondary">Add Another Product</button>
        <button type="submit" class="btn btn-primary">Create Outbound Request</button>
    </form>

    <script>
        let productIndex = 1;
        document.getElementById('add-product').addEventListener('click', function () {
            const productSection = document.getElementById('product-section');
            const newProductDiv = document.createElement('div');
            newProductDiv.classList.add('form-group');
            newProductDiv.innerHTML = `
                <label for="product_id">Product</label>
                <select name="requested_quantities[${productIndex}][product_id]" class="form-control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <label for="quantity">Quantity</label>
                <input type="number" name="requested_quantities[${productIndex}][quantity]" class="form-control" min="1" required>
            `;
            productSection.appendChild(newProductDiv);
            productIndex++;
        });
    </script>
@endsection
