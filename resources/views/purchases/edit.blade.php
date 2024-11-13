@extends('layouts.app')

@section('title', 'Edit Purchase')

@section('content')
    <h1>Edit Purchase</h1>

    <!-- Main Purchase Update Form -->
    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" value="{{ $purchase->supplier_name }}" required>
        </div>
        <div class="form-group">
            <label for="purchase_date">Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" value="{{ $purchase->purchase_date }}" required>
        </div>
		<div class="form-group">
			<label for="warehouse_id">Select Warehouse</label>
			<select name="warehouse_id" id="warehouse_id" class="form-control">
				@foreach($warehouses as $warehouse)
					<option value="{{ $warehouse->id }}" {{ $purchase->warehouse_id == $warehouse->id ? 'selected' : '' }}>
						{{ $warehouse->name }}
					</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="notes">Notes</label>
			<textarea name="notes" class="form-control">{{ $purchase->notes }}</textarea>
		</div>
	
        <h3>Products</h3>
        <div id="product-selection">
            @foreach ($purchase->products as $index => $product)
                <div class="form-group">
                    <label for="product_id">Select Product</label>
                    <select name="products[{{ $index }}][product_id]" class="form-control" required>
                        @foreach ($products as $availableProduct)
                            <option value="{{ $availableProduct->id }}" {{ $availableProduct->id == $product->id ? 'selected' : '' }}>
                                {{ $availableProduct->name }} - ${{ $availableProduct->price }}
                            </option>
                        @endforeach
                    </select>
                    <label for="quantity">Quantity</label>
                    <input type="number" name="products[{{ $index }}][quantity]" class="form-control" min="1" value="{{ $product->pivot->quantity }}" required>
                
					<!-- New Buying Price Field with existing value -->
					<label for="buying_price">Buying Price</label>
					<input type="number" step="0.01" name="products[{{ $index }}][buying_price]" class="form-control" value="{{ $product->pivot->buying_price }}" required>
				</div>
            @endforeach
        </div>
        <button type="button" id="add-product" class="btn btn-secondary">Add Another Product</button>
        <button type="submit" class="btn btn-primary">Update Purchase</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- Separate Status Update Form -->
    <form action="{{ route('purchases.updateStatus', $purchase->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <div class="form-group">
            <label for="status">Purchase Status</label>
            <select name="status" class="form-control">
                <option value="Planned" {{ $purchase->status == 'Planned' ? 'selected' : '' }}>Planned</option>
                <option value="In Transit" {{ $purchase->status == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                <option value="Received - Pending Verification" {{ $purchase->status == 'Received - Pending Verification' ? 'selected' : '' }}>Received - Pending Verification</option>
                <option value="Quantity Discrepancy" {{ $purchase->status == 'Quantity Discrepancy' ? 'selected' : '' }}>Quantity Discrepancy</option>
                <option value="Completed" {{ $purchase->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>

    <script>
        let productIndex = {{ $purchase->products->count() }};
        document.getElementById('add-product').addEventListener('click', function () {
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
                
                <!-- Buying Price Field for dynamically added products -->
                <label for="buying_price">Buying Price</label>
                <input type="number" step="0.01" name="products[${productIndex}][buying_price]" class="form-control" required>
            `;
            productSelection.appendChild(newProductDiv);
            productIndex++;
        });
    </script>
@endsection
