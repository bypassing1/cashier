<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.tailwindcss.com"></script>
    
        <title>Cashier App</title>
    
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
<body class="bg-gray-900 text-white min-h-screen bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]">

    <!-- Navbar -->
    <nav class="bg-gray-800 shadow-md backdrop-blur-md bg-opacity-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-cyan-400 text-2xl font-bold">Supermarket Together</h1>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-cyan-400 px-3 py-2 rounded-md text-sm font-medium">User Acount</a>
                    <a href="#" class="text-gray-300 hover:text-cyan-400 px-3 py-2 rounded-md text-sm font-medium">Edit Produk</a>
                    <a href="#" class="text-gray-300 hover:text-cyan-400 px-3 py-2 rounded-md text-sm font-medium">History Transaction</a>
                </div>
                <a href="/cashier" class="flex items-center hover:text-cyan-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h11L17 13M7 13h10m-6 6a1 1 0 11-2 0 1 1 0 012 0zm6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                </a>

                
            </div>
        </div>
    </nav>

    <div class="flex flex-col min-h-screen">
        <main class="flex-grow">
            @yield('content')
        </main>
    </div>
    @stack('scripts')

    
</body>
</html>