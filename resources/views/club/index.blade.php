@extends('layouts.app')

@section('title', $club->name . ' - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    <!-- Club Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <!-- Put club logo here -->
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $club->name }}</h1>
                    <p class="text-gray-600">{{ $club->description }}</p>
                </div>
            </div>
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> Follow
            </button>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    placeholder="Search in club..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                <option value="merch">Merchandise</option>
                <option value="tech">Tech Devices</option>
                <option value="arts">Arts & Crafts</option>
                <option value="clothing">Clothing</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="latest">Latest</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="popular">Most Popular</option>
            </select>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($products as $product)
            @include('homepage.components.product-card', ['product' => $product])
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">No products available</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection