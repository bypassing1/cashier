<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]">

    <div class="bg-gray-800 backdrop-blur-md bg-opacity-50 rounded-lg p-6 w-full max-w-md shadow-lg">
        <h2 class="text-2xl font-semibold text-cyan-300 mb-4 text-center">Daftar</h2>

        <!-- Display Errors -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 mb-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Username Field -->
            <div>
                <label class="block text-gray-300 mb-1">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    value="{{ old('username') }}" 
                    required
                    class="w-full bg-gray-800 text-cyan-300 border border-cyan-500 rounded-md px-3 py-2 outline-none focus:ring-2 focus:ring-cyan-400 transition duration-300"
                    placeholder="Username"
                >
            </div>

            <!-- Email Field -->
            <div>
                <label class="block text-gray-300 mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    class="w-full bg-gray-800 text-cyan-300 border border-cyan-500 rounded-md px-3 py-2 outline-none focus:ring-2 focus:ring-cyan-400 transition duration-300"
                    placeholder="email@example.com"
                >
            </div>

            <!-- Password Field -->
            <div>
                <label class="block text-gray-300 mb-1">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full bg-gray-800 text-cyan-300 border border-cyan-500 rounded-md px-3 py-2 outline-none focus:ring-2 focus:ring-cyan-400 transition duration-300"
                    placeholder="********"
                >
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label class="block text-gray-300 mb-1">Konfirmasi Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required
                    class="w-full bg-gray-800 text-cyan-300 border border-cyan-500 rounded-md px-3 py-2 outline-none focus:ring-2 focus:ring-cyan-400 transition duration-300"
                    placeholder="********"
                >
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-cyan-500 hover:bg-cyan-600 py-2 px-4 rounded transition duration-300"
            >
                Daftar
            </button>
        </form>

    </div>

</body>
</html>
