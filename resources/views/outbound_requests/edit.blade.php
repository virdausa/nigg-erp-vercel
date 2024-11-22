@extends('layouts.app')

@section('content')
    <h1>Edit Outbound Request</h1>

    <form action="{{ route('outbound_requests.update', $outboundRequest->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Warehouse Selection -->
		<div class="form-group">
			<label for="warehouse_id">Warehouse</label>
			<select name="warehouse_id" id="warehouse_id" class="form-control {{ $outboundRequest->status != 'Requested' ? 'readonly-select' : '' }}" {{ $outboundRequest->status != 'Requested' ? 'readonly' : '' }}>
				@foreach($warehouses as $warehouse)
				<option value="{{ $warehouse->id }}" {{ $outboundRequest->warehouse_id == $warehouse->id ? 'selected' : '' }}>
					{{ $warehouse->name }}
				</option>
				@endforeach
			</select>
		</div>

        <h3>Requested Products</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Requested Quantity</th>
                    <th>Stock in Warehouse</th>
					<th>Locations (Room, Rack, Quantity)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outboundRequest->requested_quantities as $productId => $quantity)
                    <tr>
                        <td>{{ $outboundRequest->sales->products->find($productId)->name }}</td>
                        <td>{{ $quantity }}</td>
                        <td id="stock-in-warehouse-{{ $productId }}">
                            {{ \App\Models\Inventory::where('warehouse_id', $outboundRequest->warehouse_id)
													->where('product_id', $productId)
													->sum('quantity') }}
                        </td>
						<td>
                            <table class="table table-bordered">
								<thead>
									<tr>
										<th>Room & Rack</th>
										<th>Quantity</th>
                                        @if ($outboundRequest->status == 'Packing & Shipping')
    										<th>Action</th>
                                        @endif
									</tr>
								</thead>
								<tbody id="locations-{{ $productId }}">
									@if (count($outboundRequestLocations) > 0)
                                        @foreach ($outboundRequestLocations[$productId] as $key => $location)
                                            <tr>
                                                <td>
                                                    <select name="locations[{{ $location->product_id }}][{{ $key }}][location_id]" class="form-control {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly-select' : '' }}" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }} required>
                                                        @foreach ($availableLocations[$location->product_id] as $availableLocation)
                                                            <option value="{{ $availableLocation->id }}"
                                                                    {{ $availableLocation->id == $location->location_id ? 'selected' : '' }}>
                                                                Room: {{ $availableLocation->room }}, Rack: {{ $availableLocation->rack }} (Available: {{ $availableLocation->quantity }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="locations[{{ $location->product_id }}][{{ $key }}][quantity]" value="{{ $location->quantity }}" class="form-control" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }} required>
                                                </td>
                                                @if ($outboundRequest->status == 'Packing & Shipping')
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-location">Remove</button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
									@else
										<tr>
											<td colspan="3">No locations available</td>
										</tr>
									@endif
								</tbody>
							</table>
                            @if ($outboundRequest->status == 'Packing & Shipping')
							    <button type="button" class="btn btn-secondary add-location" data-product-id="{{ $productId }}">Add Location</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <input type="hidden" id="deleted_locations" name="deleted_locations" value="">
            
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control" placeholder="Optional notes">{{ $outboundRequest->notes }}</textarea>
        </div>

			<h3>Expedition Details</h3>
			<div class="form-group">
				<label for="expedition_id">Expedition</label>
				<select name="expedition_id" class="form-control {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly-select' : '' }}" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }}>
					@foreach($expeditions as $expedition)
						<option value="{{ $expedition->id }}" {{ $outboundRequest->expedition_id == $expedition->id ? 'selected' : '' }}>
							{{ $expedition->name }}
						</option>
					@endforeach
				</select>
			</div>
            <div class="form-group">
                <label for="tracking_number">Tracking Number</label>
                <input type="text" name="tracking_number" class="form-control" value="{{ $outboundRequest->tracking_number }}" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }}>
            </div>
            <div class="form-group">
                <label for="real_volume">Real Volume (m³)</label>
                <input type="number" step="0.01" name="real_volume" class="form-control" value="{{ $outboundRequest->real_volume }}" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }}>
            </div>
            <div class="form-group">
                <label for="real_weight">Real Weight (kg)</label>
                <input type="number" step="0.01" name="real_weight" class="form-control" value="{{ $outboundRequest->real_weight }}" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }}>
            </div>
			<div class="form-group">
                <label for="packing_fee">Packing Fee</label>
                <input type="number" step="0.01" name="packing_fee" class="form-control" value="{{ $outboundRequest->packing_fee }}" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }}>
            </div>
            <div class="form-group">
                <label for="real_shipping_fee">Real Shipping Fee</label>
                <input type="number" step="0.01" name="real_shipping_fee" class="form-control" value="{{ $outboundRequest->real_shipping_fee }}" {{ $outboundRequest->status != 'Packing & Shipping' ? 'readonly' : '' }}>
            </div>

		<!-- Status Display -->
		<h3>Status Display</h3>
        <div class="form-group">
            <label for="status">Sales Status</label>
            <input type="text" class="form-control" value="{{ $outboundRequest->sales->status }}" readonly>
        </div>
		<div class="form-group">
            <label for="status_outbound">Outbound Status</label>
            <input type="text" class="form-control" value="{{ $outboundRequest->status }}" readonly>
        </div>

        <!-- Action Buttons -->
        <h3>Actions</h3>
        @switch($outboundRequest->status)
            @case('Requested')
                <a href="{{ route('outbound_requests.checkStock', $outboundRequest->id) }}" class="btn btn-primary">Verify Stock & Approve</a>
                <button name="submit" type="submit" class="btn btn-danger" value="Reject Request">Reject Request</button>
                @break

            @case('Pending Confirmation')
                @break

            @case('Packing & Shipping')
                <button name='submit' type="submit" class="btn btn-warning" value="Mark as Shipped">Mark as Shipped</button>
                @break

            @case('In Transit')
                @break

            @case('Customer Complaint')
                <button name='submit' type="submit" class="btn btn-warning" value="Resolve Quantity Problem">Resolve Quantity Problem</button>
                @break

            @case('Ready to Complete')
                <a href="{{ route('outbound_requests.complete', $outboundRequest->id) }}" class="btn btn-primary">Complete Request</a>
                @break
        @endswitch

        <br><br>
        <button type="submit" class="btn btn-primary">Update Outbound Request</button>
        <a href="{{ route('outbound_requests.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
	
	<script>
        // Dynamically update stock in warehouse based on selected warehouse
        document.getElementById('warehouse_id').addEventListener('change', function () {
            const warehouseId = this.value;

            @foreach ($outboundRequest->requested_quantities as $productId => $quantity)
                fetch(`{{ route('inventory.index') }}/getProductStock/warehouses/${warehouseId}/products/{{ $productId }}/stock`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById(`stock-in-warehouse-{{ $productId }}`).innerText = data.stock || '0';
                    });
            @endforeach
        });
    </script>
	
	<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-location').forEach((button) => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                const tbody = document.getElementById(`locations-${productId}`);
                const rowCount = tbody.querySelectorAll('tr').length;

                // Add a new row
                const newRow = `
                    <tr>
                        <td>
                            <select name="locations[${productId}][${rowCount}][location_id]" class="form-control location-select">
                                <option value="" selected>Select a location</option>
                                @foreach ($availableLocations[$productId] as $location)
                                    <option value="{{ $location->id }}">
                                        Room: {{ $location->room }}, Rack: {{ $location->rack }} (Available: {{ $location->quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="locations[${productId}][${rowCount}][quantity]" class="form-control" value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-location">Remove</button>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', newRow);

                // Reattach remove event listeners
                attachRemoveListeners();
            });
        });

        // Attach event listeners for all remove-location buttons
        function attachRemoveListeners() {
            document.querySelectorAll('.remove-location').forEach((removeButton) => {
                removeButton.addEventListener('click', function () {
                    const row = this.closest('tr');
                    const locationId = row.querySelector('select[name*="[location_id]"]').value;
                    if (locationId) {
                        const deletedLocationsInput = document.getElementById('deleted_locations');
                        deletedLocationsInput.value += `${locationId},`;
                    }
                    row.remove();
                });
            });
        }

        // Initial attachment of remove listeners
        attachRemoveListeners();
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
