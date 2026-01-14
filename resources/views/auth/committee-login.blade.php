@extends('layouts.app')

@section('title', 'Committee Login - I-CEMP')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative">
    <!-- Background Image with Opacity -->
    <div class="absolute inset-0 z-0">
        <img 
            src="{{ asset('images/iium-campus.jpg') }}" 
            alt="IIUM Campus" 
            class="w-full h-full object-cover opacity-100"
        >
        <div class="absolute inset-0 bg-gradient-to-br from-amber-600/40 to-orange-600/40"></div>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative z-10">
        <!-- Header with IIUM Logo -->
        <div class="bg-gradient-to-r from-amber-600 via-amber-500 to-orange-500 p-8 text-center">
            <!-- IIUM Logo -->
            <div class="w-full mb-4 bg-white rounded-lg p-4">
                <img 
                    src="{{ asset('images/iium-logo2.png') }}" 
                    alt="IIUM Logo" 
                    class="w-full h-auto object-contain"
                >
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Committee Portal</h1>
            <p class="text-amber-50">Club Management Access</p>
        </div>

        <!-- Login Form -->
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Committee Login</h2>
            
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

            <form action="{{ route('committee.login.submit') }}" method="POST">
                @csrf
                
                <!-- Committee ID Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="committee_id">
                        <i class="fas fa-id-badge text-amber-600 mr-1"></i>
                        Committee ID
                    </label>
                    <input 
                        type="text" 
                        id="committee_id" 
                        name="committee_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 transition @error('committee_id') border-red-500 @enderror"
                        placeholder="Enter your committee ID (e.g., COM001)"
                        value="{{ old('committee_id') }}"
                        required
                        autofocus
                    >
                    @error('committee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="committee_password">
                        <i class="fas fa-lock text-amber-600 mr-1"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="committee_password" 
                            name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 transition @error('password') border-red-500 @enderror"
                            placeholder="Enter password"
                            required
                        >
                        <button 
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-amber-600"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-amber-600 to-orange-500 text-white py-3 rounded-lg font-semibold hover:shadow-lg transform hover:scale-105 transition duration-200"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    LOGIN AS COMMITTEE
                </button>
            </form>

            <!-- Student Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm mb-2">Are you a student?</p>
                <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium inline-flex items-center transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Student Login
                </a>
            </div>

            <!-- Demo Credentials -->
            <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <p class="text-xs text-amber-800 font-semibold mb-2">
                    <i class="fas fa-info-circle mr-1"></i> Demo Credentials:
                </p>
                <div class="text-xs text-amber-700 space-y-1">
                    <p><strong>Committee ID:</strong> COM001</p>
                    <p><strong>Password:</strong> committee123</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('committee_password');
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