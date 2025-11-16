<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hyperscale</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-black text-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md" x-data="{ showPassword: false }">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block mb-6">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mx-auto">
                    <i class="fas fa-triangle text-black text-lg"></i>
                </div>
            </a>
            <h1 class="text-2xl font-bold mb-2">Welcome back</h1>
            <p class="text-gray-400 text-sm">Sign in to your Hyperscale account</p>
        </div>

        <!-- Login Form -->
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-8">
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                    <div class="flex-1">
                        @foreach($errors->all() as $error)
                        <p class="text-sm text-red-400">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                    <p class="text-sm text-green-400">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-500 text-sm"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full pl-10 pr-4 py-2.5 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-600 text-white text-sm placeholder-gray-500 transition-colors"
                            placeholder="you@example.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 text-sm"></i>
                        </div>
                        <input 
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password" 
                            required
                            class="w-full pl-10 pr-12 py-2.5 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-600 text-white text-sm placeholder-gray-500 transition-colors"
                            placeholder="Enter your password">
                        <button 
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300 transition-colors">
                            <i class="fas text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember"
                            class="w-4 h-4 bg-black border border-gray-800 rounded focus:ring-0 focus:ring-offset-0 text-white">
                        <span class="ml-2 text-sm text-gray-400">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full py-2.5 bg-white text-black rounded-lg font-medium text-sm hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-black">
                    Sign in
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-800"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-gray-900 text-gray-500">Or continue with</span>
                </div>
            </div>

            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('socialite.redirect', 'github') }}" 
                   class="flex items-center justify-center gap-2 px-4 py-2.5 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors">
                    <i class="fab fa-github text-lg"></i>
                    <span class="text-sm font-medium">GitHub</span>
                </a>
                <a href="{{ route('socialite.redirect', 'google') }}" 
                   class="flex items-center justify-center gap-2 px-4 py-2.5 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors">
                    <i class="fab fa-google text-lg"></i>
                    <span class="text-sm font-medium">Google</span>
                </a>
            </div>
        </div>

        <!-- Sign Up Link -->
        <p class="text-center text-sm text-gray-400 mt-6">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-white hover:underline font-medium">
                Sign up
            </a>
        </p>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors">
                <i class="fas fa-arrow-left text-xs"></i>
                Back to home
            </a>
        </div>
    </div>
</body>
</html>
