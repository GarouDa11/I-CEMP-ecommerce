@extends('layouts.app')

@section('title', 'Login - I-CEMP')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative">
    <!-- Background Image with Opacity -->
    <div class="absolute inset-0 z-0">
        <img 
            src="{{ asset('images/iium-campus.jpg') }}" 
            alt="IIUM Campus" 
            class="w-full h-full object-cover opacity-100"
        >
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/40 to-purple-600/40"></div>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative z-10">
        <!-- Logo Section with IIUM Logo -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-center">
            <!-- IIUM Logo -->
            <div class="w-full mb-4 bg-white rounded-lg p-4">
                <img 
                    src="{{ asset('images/iium-logo2.png') }}" 
                    alt="IIUM Logo" 
                    class="w-full h-auto object-contain"
                >
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">I-CEMP</h1>
            <p class="text-blue-100">Campus E-Commerce Platform</p>
        </div>

        <!-- Login Form -->
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Student Login</h2>
            
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Logout Message -->
            @if (session('status'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif
            
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                
                <!-- Student ID Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="student_id">
                        Student ID / Matric ID
                    </label>
                    <input 
                        type="text" 
                        id="student_id" 
                        name="student_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('student_id') border-red-500 @enderror"
                        placeholder="Enter your matric ID (e.g., 2212345)"
                        value="{{ old('student_id') }}"
                        required
                        autofocus
                    >
                    @error('student_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('password') border-red-500 @enderror"
                            placeholder="Enter your password"
                            required
                        >
                        <button 
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition">
                        Forgot password?
                    </a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transform hover:scale-105 transition duration-200 flex items-center justify-center"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    LOGIN
                </button>
            </form>

            <!-- Committee Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm mb-2">Are you a club committee?</p>
                <a 
                    href="{{ route('committee.login') }}" 
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center transition"
                >
                    Login as Committee
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Demo Credentials Info -->
            <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="text-xs text-gray-600 font-semibold mb-2">
                    <i class="fas fa-info-circle mr-1"></i> Demo Credentials:
                </p>
                <div class="text-xs text-gray-600 space-y-1">
                    <p><strong>Matric ID:</strong> 2212345</p>
                    <p><strong>Password:</strong> password123</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection