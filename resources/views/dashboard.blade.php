@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    <p>Welcome to your business management app. Use the links below to navigate to different sections:</p>

    <div class="list-group">
        <a href="{{ route('purchases.index') }}" class="list-group-item list-group-item-action">Manage Purchases</a>
        <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">Manage Products</a>
    </div>
@endsection
