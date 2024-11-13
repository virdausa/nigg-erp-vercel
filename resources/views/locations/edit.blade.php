@extends('layouts.app')

@section('content')
    <h1>Edit Location</h1>

    <form action="{{ route('locations.update', $location->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="warehouse_id">Warehouse</label>
            <select name="warehouse_id" class="form-control" required>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ $location->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>
		<!-- Room Selection and Input -->
		<div class="form-group">
			<label for="room">Room</label>
			<select name="existing_room" class="form-control" id="existing-room-select">
				<option value="">-- Select Existing Room --</option>
				@foreach ($warehouse->locations->unique('room') as $location)
					<option value="{{ $location->room }}">
						{{ $location->room }}
					</option>
				@endforeach
			</select>

			<label for="new_room" class="mt-2">Or enter a new room</label>
			<input type="text" name="new_room" id="new-room-input" class="form-control" placeholder="Enter new room name">
		</div>
        <div class="form-group">
            <label for="rack">Rack</label>
            <input type="text" name="rack" class="form-control" value="{{ $location->rack }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Location</button>
    </form>

    <a href="{{ route('locations.index') }}" class="btn btn-secondary mt-3">Back to Location List</a>
	
		<script>
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
