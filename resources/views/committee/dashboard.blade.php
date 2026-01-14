@extends('layouts.app')

@section('title', 'Committee Dashboard - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="bg-gray-100 min-h-screen py-6">
    <div class="container mx-auto px-4">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-lg shadow-lg p-6 mb-6 text-white">
            <h1 class="text-3xl font-bold mb-2">Welcome, {{ $committee->club_name }}!</h1>
            <p class="text-orange-100">Manage your products and track your sales</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Products -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Products</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalProducts }}</h3>
                    </div>
                    <div class="bg-blue-100 rounded-full p-4">
                        <i class="fas fa-box text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Sales -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Items Sold</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSales }}</h3>
                    </div>
                    <div class="bg-green-100 rounded-full p-4">
                        <i class="fas fa-shopping-cart text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Revenue</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">RM {{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                    <div class="bg-orange-100 rounded-full p-4">
                        <i class="fas fa-dollar-sign text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <a href="{{ route('committee.products.create') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-4 mr-4">
                        <i class="fas fa-plus text-green-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Add New Product</h3>
                        <p class="text-gray-500">Create a new product listing</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('committee.products') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-4 mr-4">
                        <i class="fas fa-list text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">View All Products</h3>
                        <p class="text-gray-500">Manage your product inventory</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Products -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Products</h2>
            
            @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Product</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stock</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Sold</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products->take(5) as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <img src="{{ $product->main_image ? asset('storage/' . $product->main_image) : 'https://via.placeholder.com/50' }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-10 h-10 rounded object-cover mr-3">
                                    <span class="font-medium text-gray-800">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">RM {{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $product->stock }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $product->sold_count }}</td>
                            <td class="px-4 py-3">
                                @if($product->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('committee.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg mb-4">No products yet</p>
                <a href="{{ route('committee.products.create') }}" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                    Add Your First Product
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection