<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
        <!-- <script src="sweetalert2.min.js"></script>
        <link rel="stylesheet" href="sweetalert2.min.css"> -->
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900">
    
        @include('layouts.sidebar')
        <!-- @include('components.alert') -->


            <!-- Page Content -->
   
            <main class="p-4 sm:ml-64">
                {{ $slot }}
            </main>
            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@stack('script')
@if (session('success'))
    <script>
        Swal.fire({
            title: "Success",
            text: "{{ session('success') }}",
            icon: "success",
            timer: 3000,
            customClass: {
                popup: 'bg-white p-6 rounded-lg shadow-xl dark:bg-gray-900 dark:border dark:border-sky-500',   // Customize the popup box
                title: 'text-xl font-semibold text-green-600',
                header: 'text-sm text-gray-700 dark:text-white',
                content: 'text-sm text-gray-700 dark:text-white',
                confirmButton: 'bg-emerald-900 text-white font-bold py-2 px-4 rounded-md hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-300' // Customize the button
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: "Error",
            text: "{{ session('error') }}",
            icon: "error",
            timer: 3000,
            customClass: {
                popup: 'bg-white p-6 rounded-lg shadow-xl dark:bg-gray-900 dark:border dark:border-sky-500',   // Customize the popup box
                title: 'text-xl font-semibold text-green-600',
                header: 'text-sm text-gray-700 dark:text-white',
                content: 'text-sm text-gray-700 dark:text-white',
                confirmButton: 'bg-red-900 text-white font-bold py-2 px-4 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-300' // Customize the button
            }
        });
    </script>
@endif
    </body>
</html>