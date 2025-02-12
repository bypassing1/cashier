<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]">

    <div class="bg-gray-800 backdrop-blur-md bg-opacity-50 rounded-lg p-6 w-full max-w-md shadow-lg">
        <h2 class="text-2xl font-semibold text-cyan-300 mb-4 text-center">Login</h2>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 rounded-md mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

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

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-cyan-500 hover:bg-cyan-600 py-2 px-4 rounded transition duration-300 cursor-pointer"
            >
                Masuk
            </button>
        </form>

        <!-- Footer -->
        <p class="mt-4 text-gray-400 text-center text-sm">
            Belum punya akun? 
            <a href="/register" class="text-cyan-300 hover:underline">Daftar di sini</a>
        </p>
    </div>

</body>
</html>