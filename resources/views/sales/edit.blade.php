@extends('layouts.app')

@section('content')
    <h1>Edit Sales Order</h1>

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" value="{{ $sale->customer_name }}" required>
        </div>
        
        <div class="form-group">
            <label for="sale_date">Sale Date</label>
            <input type="date" name="sale_date" class="form-control" value="{{ $sale->sale_date }}" required>
        </div>
        
        <div class="form-group">
            <label for="warehouse_id">Select Warehouse</label>
            <select name="warehouse_id" class="form-control" required>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ $sale->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3>Products</h3>
        <div id="product-section">
            @foreach ($sale->products as $index => $product)
                <div class="form-group">
                    <label for="products[{{ $index }}][product_id]">Product</label>
                    <select name="products[{{ $index }}][product_id]" class="form-control" required>
                        @foreach ($products as $availableProduct)
                            <option value="{{ $availableProduct->id }}" {{ $product->id == $availableProduct->id ? 'selected' : '' }}>
                                {{ $availableProduct->name }} - ${{ $availableProduct->price }}
                            </option>
                        @endforeach
                    </select>
                    <label for="products[{{ $index }}][quantity]">Quantity</label>
                    <input type="number" name="products[{{ $index }}][quantity]" class="form-control" value="{{ $product->pivot->quantity }}" required>
                    <label for="products[{{ $index }}][price]">Price</label>
                    <input type="number" step="0.01" name="products[{{ $index }}][price]" class="form-control" value="{{ $product->pivot->price }}" required>
                </div>
            @endforeach
        </div>

		<button type="button" id="add-product" class="btn btn-secondary">Add Another Product</button>
        <button type="submit" class="btn btn-primary">Update Sale</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
	
	<script>
    let productIndex = 1;
    document.getElementById('add-product').addEventListener('click', function () {
        const productSection = document.getElementById('product-section');
        const newProduct = `
            <div class="form-group">
                <label for="products[${productIndex}][product_id]">Product</label>
                <select name="products[${productIndex}][product_id]" class="form-control" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                    @endforeach
                </select>
                <label for="products[${productIndex}][quantity]">Quantity</label>
                <input type="number" name="products[${productIndex}][quantity]" class="form-control" required>
                <label for="products[${productIndex}][price]">Price</label>
                <input type="number" name="products[${productIndex}][price]" class="form-control" required>
            </div>
        `;
        productSection.insertAdjacentHTML('beforeend', newProduct);
        productIndex++;
    });
</script>
@endsection
