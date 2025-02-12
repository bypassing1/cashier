<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <title>Cashier App</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]">
    <script src="{{asset('js/product-selection.js')}}"></script>
    <script src="{{asset('js/filter-search.js')}}"></script>
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 relative">
            <div class="absolute inset-0 bg-grid-white bg-[size:50px_50px]"></div>
            <div class="absolute inset-0 bg-dots-darker flex items-center justify-center text-white/[0.03]font-bold">
            </div>
            <div class="relative z-10 h-full overflow-auto">
                @yield('content')
            </div>
        </div>
        @include('partials.sidebar')
    </div>
</body>

</html>