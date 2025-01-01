<x-app-layout>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
				<div class="p-6 text-gray-900 dark:text-white">
					<h3 class="text-lg font-bold dark:text-white">Add Purchase</h3>
					<p class="text-sm dark:text-gray-200 mb-6">Create, edit, and manage your product listings.</p>
					<span
						class="mb-4 inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
						<span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
						Select the supplier first
					</span>
					<div
						class="p-2 border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-600 mb-4">

						<form action="{{ route('purchases.store') }}" method="POST">
							@csrf
							<div class="mb-4">
								<x-input-label for="supplier_id">Supplier</x-input-label>
								<select name="supplier_id" id="supplier_id"
									class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white"
									required>
									@foreach($suppliers as $supplier)
										<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-4">
								<x-input-label for="purchase_date">Purchase Date</x-input-label>
								<x-date-input type="date" name="purchase_date" class="w-full" required></x-date-input>
							</div>
							<div class="mb-4">
								<x-input-label for="warehouse_id">Select Warehouse</x-input-label>
								<select name="warehouse_id" id="warehouse_id"
									class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white">
									@foreach($warehouses as $warehouse)
										<option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
									@endforeach
								</select>
							</div>
					</div>

					<div id="product-selection" class="grid grid-cols-1 sm:grid-cols-2 gap-6">

						<div
							class=" mb-4 mr-4 p-2 border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-600">
							<div class="flex inline justify-between space items-center">
								<h3 class="text-md font-bold">Products 1</h3>
								<button type="button"
									class="ml-3 bg-red-500 text-sm text-white px-4 py-1 rounded-md hover:bg-red-700 remove-product">
									Remove
								</button>
							</div>
							<div class="mb-3 mt-1 flex-grow border-t border-gray-500 dark:border-gray-700"></div>
							<div>
								<div class="mb-4" id="product1">
									<x-input-label for="product_id">Select Product</x-input-label>

									<select name="products[0][product_id]"
										class="mb-4 w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white">
										@foreach ($products as $product)
											<option value="{{ $product->id }}">{{ $product->name }} -
												Rp{{ $product->price }}
											</option>
										@endforeach
									</select>
									<x-input-label for="quantity">Quantity</x-input-label>
									<x-text-input type="number" name="products[0][quantity]"
										class="mb-4 w-full form-control" min="1" required
										placeholder="Kuantitas (jumlah barang)"></x-text-input>

									<x-input-label for="buying_price">Buying Price</x-input-label>
									<x-text-input type="number" step="0.01" name="products[0][buying_price]"
										class=" w-full form-control" required
										placeholder="Masukkan harga beli"></x-text-input>

								</div>
							</div>

						</div>
					</div>
					<x-button type="button" id="add-product" class="mr-3">Add Another Product</x-button>

					<x-primary-button>Save Purchase</x-primary-button>
					<a href="{{ route('purchases.index') }}"
						class="border rounded border-gray-400 dark:border-gray-700 p-2 ml-3 text-sm hover:underline text-gray 700 dark:text-gray-400">Cancel</a>
					</form>

					<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Reference to the product selection container
        const productSelection = document.getElementById('product-selection');
        let productIndex = 1;

        // Add product functionality
        document.getElementById('add-product').addEventListener('click', function () {
            const newProductDiv = document.createElement('div');
            newProductDiv.classList.add('product-item', 'mb-4', 'mr-4', 'p-2', 'border', 'border-gray-200', 'rounded-lg', 'shadow-md', 'dark:bg-gray-800', 'dark:border-gray-600');
            newProductDiv.innerHTML = `
                <div class="flex inline justify-between space items-center">
                    <h3 class="text-md font-bold">Product ${productIndex + 1}</h3>
                    <button type="button" class="ml-3 bg-red-500 text-sm text-white px-4 py-1 rounded-md hover:bg-red-700 remove-product">
                        Remove
                    </button>
                </div>
                <div class="mb-3 mt-1 flex-grow border-t border-gray-500 dark:border-gray-700"></div>
                <div>
                    <x-input-label for="product_id">Select Product</x-input-label>
                    <select name="products[${productIndex}][product_id]" class="mb-4 w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - Rp{{ $product->price }}</option>
                        @endforeach
                    </select>
                    <x-input-label for="quantity">Quantity</x-input-label>
                    <x-text-input type="number" name="products[${productIndex}][quantity]" class="mb-4 w-full form-control" min="1" required placeholder="Quantity"></x-text-input>
                    <x-input-label for="buying_price">Buying Price</x-input-label>
                    <x-text-input type="number" step="0.01" name="products[${productIndex}][buying_price]" class="w-full form-control" required placeholder="Buying Price"></x-text-input>
                </div>
            `;
            productSelection.appendChild(newProductDiv);
            productIndex++;
        });

        // Remove product functionality using event delegation
        productSelection.addEventListener('click', function (event) {
            if (event.target && event.target.classList.contains('remove-product')) {
                const productDiv = event.target.closest('.product-item');
                productDiv.remove(); // Remove the product div
            }
        });
    });
</script>

				</div>
			</div>
		</div>
	</div>
</x-app-layout>