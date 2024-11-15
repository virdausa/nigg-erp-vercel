@extends('layouts.app')

@section('title', 'Edit Purchase')

@section('content')
    <h1>Edit Purchase</h1>

    <!-- Main Purchase Update Form -->
    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Supplier Name -->
        <div class="form-group">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" value="{{ $purchase->supplier_name }}" required
                   {{ $purchase->status != 'Planned' ? 'readonly' : '' }}>
        </div>

        <!-- Purchase Date -->
        <div class="form-group">
            <label for="purchase_date">Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" value="{{ $purchase->purchase_date }}" required
                   {{ $purchase->status != 'Planned' ? 'readonly' : '' }}>
        </div>

        <!-- Warehouse Selection -->
        <div class="form-group">
            <label for="warehouse_id">Select Warehouse</label>
            <select name="warehouse_id" id="warehouse_id" class="form-control {{ $purchase->status != 'Planned' ? 'readonly-select' : '' }}" {{ $purchase->status != 'Planned' ? 'readonly' : '' }}>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ $purchase->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Status Display -->
        <div class="form-group">
            <label for="status">Purchase Status</label>
            <input type="text" class="form-control" name="status" value="{{ $purchase->status }}" readonly>
        </div>

        <!-- Shipped Date, Expedition, and Tracking No (Editable only if Planned) -->
        <div class="form-group">
            <label for="shipped_date">Shipped Date</label>
            <input type="date" name="shipped_date" class="form-control" value="{{ $purchase->shipped_date }}"
                   {{ $purchase->status == 'Planned' ? '' : 'readonly' }}>
        </div>

        <div class="form-group">
            <label for="expedition">Expedition</label>
            <input type="text" name="expedition" class="form-control" value="{{ $purchase->expedition }}"
                   {{ $purchase->status == 'Planned' ? '' : 'readonly' }}>
        </div>

        <div class="form-group">
            <label for="tracking_no">Tracking Number</label>
            <input type="text" name="tracking_no" class="form-control" value="{{ $purchase->tracking_no }}"
                   {{ $purchase->status == 'Planned' ? '' : 'readonly' }}>
        </div>

        <!-- Notes -->
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control" {{ $purchase->status == 'Completed' ? 'readonly' : '' }}>
                {{ $purchase->notes }}
            </textarea>
        </div>

        <!-- Product Selection -->
        <h3>Products</h3>
        <div id="product-selection">
            @foreach ($purchase->products as $index => $product)
                <div class="form-group">
                    <label for="product_id">Select Product</label>
                    <select name="products[{{ $index }}][product_id]" class="form-control {{ $purchase->status != 'Planned' ? 'readonly-select' : '' }}" required
                            {{ $purchase->status != 'Planned' ? 'readonly' : '' }}>
                        @foreach ($products as $availableProduct)
                            <option value="{{ $availableProduct->id }}" {{ $availableProduct->id == $product->id ? 'selected' : '' }}>
                                {{ $availableProduct->name }} - ${{ $availableProduct->price }}
                            </option>
                        @endforeach
                    </select>

                    <label for="quantity">Quantity</label>
                    <input type="number" name="products[{{ $index }}][quantity]" class="form-control" min="1"
                           value="{{ $product->pivot->quantity }}" required {{ $purchase->status != 'Planned' ? 'readonly' : '' }}>

                    <!-- Buying Price Field -->
                    <label for="buying_price">Buying Price</label>
                    <input type="number" step="0.01" name="products[{{ $index }}][buying_price]" class="form-control"
                           value="{{ $product->pivot->buying_price }}" required {{ $purchase->status != 'Planned' ? 'readonly' : '' }}>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-product" class="btn btn-secondary" {{ $purchase->status != 'Planned' ? 'disabled' : '' }}>Add Another Product</button>
        <button type="submit" class="btn btn-primary">Update Purchase</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- Add Product Script -->
    <script>
        let productIndex = {{ $purchase->products->count() }};
        document.getElementById('add-product').addEventListener('click', function () {
            if ("{{ $purchase->status }}" !== "Planned") return;

            const productSelection = document.getElementById('product-selection');
            const newProductDiv = document.createElement('div');
            newProductDiv.classList.add('form-group');
            newProductDiv.innerHTML = `
                <label for="product_id">Select Product</label>
                <select name="products[${productIndex}][product_id]" class="form-control" required>
                    @foreach ($products as $availableProduct)
                        <option value="{{ $availableProduct->id }}">{{ $availableProduct->name }} - ${{ $availableProduct->price }}</option>
                    @endforeach
                </select>
                <label for="quantity">Quantity</label>
                <input type="number" name="products[${productIndex}][quantity]" class="form-control" min="1" required>
                
                <!-- Buying Price Field -->
                <label for="buying_price">Buying Price</label>
                <input type="number" step="0.01" name="products[${productIndex}][buying_price]" class="form-control" required>
            `;
            productSelection.appendChild(newProductDiv);
            productIndex++;
        });
    </script>
	
	<script>
		// JavaScript to prevent selection changes on readonly-select elements
		document.querySelectorAll('.readonly-select').forEach(function(select) {
			select.addEventListener('mousedown', function(event) {
				event.preventDefault();
			});
			select.addEventListener('click', function(event) {
				event.preventDefault();
			});
			select.addEventListener('change', function(event) {
				event.preventDefault();
			});
		});
	</script>
@endsection
