@extends('layouts.app')

@section('title', 'Adjust Inventory')

@section('content')
    <h1>Adjust Inventory</h1>

    <form action="{{ route('inventory.adjust') }}" method="POST">
        @csrf

        <div class="form-group">
			<label for="warehouse_id">Select Warehouse</label>
			<select name="warehouse_id" id="warehouse_id" class="form-control" required>
				<option value="">-- Select Warehouse --</option>
				@foreach($warehouses as $warehouse)
					<option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
				@endforeach
			</select>
		</div>
		
        <div class="form-group">
            <label for="product_id">Select Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="transaction_type">Transaction Type</label>
            <select name="transaction_type" class="form-control" required>
                <option value="Addition">Addition</option>
                <option value="Reduction">Reduction</option>
            </select>
        </div>

        <!-- Room Selection -->
        <div class="form-group">
			<label for="room">Room</label>
			<select name="room" id="room" class="form-control" required>
				<option value="">-- Select Room --</option>
				<!-- Options will be populated dynamically -->
			</select>
		</div>

		<div class="form-group">
			<label for="rack">Rack</label>
			<select name="rack" id="rack" class="form-control" required>
				<option value="">-- Select Rack --</option>
				<!-- Options will be populated dynamically -->
			</select>
		</div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control" placeholder="Optional notes"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Adjust Inventory</button>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- JavaScript for Dynamic Rack Filtering based on Room Selection -->
	<script>
		document.getElementById('warehouse_id').addEventListener('change', function() {
			const warehouseId = this.value;
			const roomSelect = document.getElementById('room');
			const rackSelect = document.getElementById('rack');

			roomSelect.innerHTML = '<option value="">-- Select Room --</option>';
			rackSelect.innerHTML = '<option value="">-- Select Rack --</option>';

			if (warehouseId) {
				fetch(`{{ route('inventory.index') }}/get-locations/${warehouseId}`)
					.then(response => response.json())
					.then(locations => {
						// Get unique rooms by filtering out duplicates
						const uniqueRooms = [...new Set(locations.map(location => location.room))];
						
						// Clear the room select options
						roomSelect.innerHTML = '<option value="">-- Select Room --</option>';

						// Populate the room dropdown with unique rooms
						uniqueRooms.forEach(room => {
							const option = document.createElement('option');
							option.value = room;
							option.textContent = room;
							roomSelect.appendChild(option);
						});
					});

			}
		});

		document.getElementById('room').addEventListener('change', function() {
			const selectedRoom = this.value;
			const rackSelect = document.getElementById('rack');
			rackSelect.innerHTML = '<option value="">-- Select Rack --</option>';

			const warehouseId = document.getElementById('warehouse_id').value;
			if (warehouseId && selectedRoom) {
				fetch(`{{ route('inventory.index') }}/get-locations/${warehouseId}`)
					.then(response => response.json())
					.then(locations => {
						locations
							.filter(location => location.room === selectedRoom)
							.forEach(location => {
								const option = document.createElement('option');
								option.value = location.rack;
								option.textContent = location.rack;
								rackSelect.appendChild(option);
							});
					});
			}
		});
	</script>

@endsection
