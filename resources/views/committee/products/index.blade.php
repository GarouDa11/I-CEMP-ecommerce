@extends('layouts.app')

@section('title', 'My Products - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="bg-gray-100 min-h-screen py-6">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">My Products</h1>
            <a href="{{ route('committee.products.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Product
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative pb-[100%] bg-gray-100">
                    <img src="{{ $product->main_image ? asset('storage/' . $product->main_image) : 'https://via.placeholder.com/300' }}" 
                         alt="{{ $product->name }}" 
                         class="absolute inset-0 w-full h-full object-cover">
                    @if(!$product->is_active)
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <span class="bg-red-500 text-white px-4 py-2 rounded">Inactive</span>
                    </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                    
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-lg font-bold text-blue-600">RM {{ number_format($product->price, 2) }}</span>
                        <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                    </div>
                    
                    <div class="text-sm text-gray-500 mb-3">
                        <i class="fas fa-fire text-orange-500 mr-1"></i>
                        {{ $product->sold_count }} sold
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('committee.products.edit', $product->id) }}" 
                           class="flex-1 bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('committee.products.destroy', $product->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this product?');"
                              class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">No products yet</h2>
            <p class="text-gray-600 mb-6">Start selling by adding your first product!</p>
            <a href="{{ route('committee.products.create') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition inline-block">
                <i class="fas fa-plus mr-2"></i>
                Add Your First Product
            </a>
        </div>
        @endif
    </div>
</div>
@endsection