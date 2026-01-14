@extends('layouts.app')

@section('title', 'My Profile - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Profile Picture -->
                <div class="text-center mb-6">
                    <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        <div class="relative inline-block">
                            <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center overflow-hidden">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user text-white text-4xl"></i>
                                @endif
                            </div>
                            <label for="profile_photo" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition">
                                <i class="fas fa-camera text-sm"></i>
                            </label>
                            <input 
                                type="file" 
                                id="profile_photo" 
                                name="profile_photo" 
                                accept="image/*"
                                class="hidden"
                                onchange="document.getElementById('photoForm').submit()"
                            >
                        </div>
                    </form>
                    <h2 class="font-bold text-xl text-gray-800">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ auth()->user()->matric_id }}</p>
                </div>

                <!-- Menu -->
                <nav class="space-y-2">
                    <a href="#account" onclick="showSection('account')" class="profile-menu-item bg-blue-50 text-blue-600 flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-user mr-3"></i>
                        <span>My Account</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="profile-menu-item flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-shopping-bag mr-3"></i>
                        <span>My Orders</span>
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="profile-menu-item flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-heart mr-3"></i>
                        <span>My Wishlist</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="profile-menu-item flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        <span>My Cart</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Account Section -->
            <div id="account-section" class="profile-section">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Account</h2>
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                                <input 
                                    type="text" 
                                    name="name"
                                    value="{{ auth()->user()->name }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Matric ID</label>
                                <input 
                                    type="text" 
                                    value="{{ auth()->user()->matric_id }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input 
                                type="email" 
                                name="email"
                                value="{{ auth()->user()->email }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                                <input 
                                    type="tel" 
                                    name="phone"
                                    value="{{ auth()->user()->phone }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Mahallah</label>
                                <input 
                                    type="text" 
                                    name="mahallah"
                                    value="{{ auth()->user()->mahallah }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="e.g., Mahallah Uthman"
                                >
                            </div>
                        </div>

                        <button 
                            type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection