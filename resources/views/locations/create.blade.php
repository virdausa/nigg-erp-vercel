@extends('layouts.app')

@section('content')
    <h1>Add New Location</h1>

    <form action="{{ route('locations.store') }}" method="POST">
        @csrf
        <div class="form-group">
			<label for="warehouse_id">Warehouse</label>
			<select id="warehouse-select" name="warehouse_id" class="form-control" required>
				<option value="">-- Select Warehouse --</option>
				@foreach($warehouses as $warehouse)
					<option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="room">Room</label>
			<select name="existing_room" id="existing-room-select" class="form-control">
				<option value="">-- Select Existing Room --</option>
				@foreach($warehouses as $warehouse)
					@foreach($warehouse->locations->unique('room') as $location)
						<option value="{{ $location->room }}" data-warehouse="{{ $warehouse->id }}">
							{{ $location->room }}
						</option>
					@endforeach
				@endforeach
			</select>

			<label for="new_room" class="mt-2">Or enter a new room</label>
			<input type="text" name="new_room" id="new-room-input" class="form-control" placeholder="Enter new room name">
		</div>

        <div class="form-group">
            <label for="rack">Rack</label>
            <input type="text" name="rack" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Location</button>
    </form>

    <a href="{{ route('locations.index') }}" class="btn btn-secondary mt-3">Back to Location List</a>
	
	<script>
		document.getElementById('warehouse-select').addEventListener('change', function() {
			const selectedWarehouse = this.value;
			const roomSelect = document.getElementById('existing-room-select');

			Array.from(roomSelect.options).forEach(option => {
				if (option.dataset.warehouse === selectedWarehouse || option.value === "") {
					option.style.display = 'block';
				} else {
					option.style.display = 'none';
				}
			});

			// Reset room selection if it doesn’t match the selected warehouse
			roomSelect.selectedIndex = 0;
		});

		document.getElementById('existing-room-select').addEventListener('change', function() {
			if (this.value) {
				document.getElementById('new-room-input').value = '';
			}
		});

		document.getElementById('new-room-input').addEventListener('input', function() {
			if (this.value) {
				document.getElementById('existing-room-select').value = '';
			}
		});
	</script>

@endsection
