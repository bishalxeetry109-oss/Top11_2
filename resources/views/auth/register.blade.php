<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Top11 Fantasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">🏆 Top11</h1>
            <p class="text-gray-400">Create your account</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-400 text-sm mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                Create Account
            </button>
        </form>

        <p class="text-center text-gray-400 mt-6">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Sign In</a>
        </p>
    </div>
</body>
</html>
