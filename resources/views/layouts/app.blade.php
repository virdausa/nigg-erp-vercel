<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('purchases.index') }}">Purchases</a>
                <a class="nav-link" href="{{ route('products.index') }}">Products</a>
            </div>
        </nav>

        @yield('content')
    </div>
</body>
</html>

