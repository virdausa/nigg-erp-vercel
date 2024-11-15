@extends('layouts.app')

@section('content')
    <h1>Complete Inbound Request</h1>

    <form action="{{ route('inbound_requests.storeCompletion', $inboundRequest->id) }}" method="POST">
        @csrf
        @foreach ($inboundRequest->purchase->products as $product)
            @if(isset($inboundRequest->requested_quantities[$product->id]) && $inboundRequest->requested_quantities[$product->id] > 0)
                <h4>{{ $product->name }}</h4>
                
                <p>Requested Quantity: {{ $inboundRequest->requested_quantities[$product->id] }}</p>
                <p>Received Quantity: {{ $inboundRequest->received_quantities[$product->id] ?? 0 }}</p>

                <!-- Room Selection -->
                <div>
                    <label>Room</label>
                    <select name="locations[{{ $product->id }}][room]" class="form-control room-select" required>
                        <option value="">-- Select Existing Room --</option>
                        @foreach ($inboundRequest->warehouse->locations->unique('room') as $location)
                            <option value="{{ $location->room }}">{{ $location->room }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Rack Selection -->
                <div>
                    <label>Rack</label>
                    <select name="locations[{{ $product->id }}][rack]" class="form-control rack-select" required>
                        <option value="">-- Select Existing Rack --</option>
                        @foreach ($inboundRequest->warehouse->locations as $location)
                            <option data-room="{{ $location->room }}" value="{{ $location->rack }}">{{ $location->rack }}</option>
                        @endforeach
                    </select>
                </div>
                <hr>
            @endif
        @endforeach

        <button type="submit" class="btn btn-primary">Complete Inbound Request</button>
        <a href="{{ route('inbound_requests.show', $inboundRequest->id) }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- JavaScript for Dynamic Rack Filtering -->
    <script>
        document.querySelectorAll('.room-select').forEach(roomSelect => {
            roomSelect.addEventListener('change', function() {
                const selectedRoom = this.value;
                const rackSelect = this.closest('div').nextElementSibling.querySelector('.rack-select');

                Array.from(rackSelect.options).forEach(option => {
                    option.style.display = option.dataset.room === selectedRoom ? 'block' : 'none';
                });

                rackSelect.selectedIndex = 0;
            });
        });
    </script>
@endsection
