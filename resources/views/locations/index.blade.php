@extends('layouts.app')

@section('content')
    <h1>Manage Locations</h1>
    <a href="{{ route('locations.create') }}" class="btn btn-primary">Add New Location</a>
    <hr>

    @foreach($warehouses as $warehouse)
        <h3>{{ $warehouse->name }}</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Rack</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouse->locations as $location)
                    <tr>
                        <td>{{ $location->room }}</td>
                        <td>{{ $location->rack }}</td>
                        <td>
                            <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
