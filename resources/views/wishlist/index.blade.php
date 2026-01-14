@extends('layouts.app')

@section('title', 'My Wishlist - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">My Wishlist</h1>

    @if($wishlist->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($wishlist as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <a href="{{ route('product.show', $item->product->id) }}">
                <div class="relative pb-[100%] bg-gray-100">
                    <img 
                        src="{{ $item->product->image_url }}" 
                        alt="{{ $item->product->name }}" 
                        class="absolute inset-0 w-full h-full object-cover"
                        onerror="this.src='https://via.placeholder.com/300?text=No+Image'"
                    >
                </div>
            </a>
            
            <div class="p-4">
                <div class="text-xs text-gray-500 mb-1">{{ $item->product->committee->club_name }}</div>
                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $item->product->name }}</h3>
                
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xl font-bold text-blue-600">RM {{ number_format($item->product->price, 2) }}</span>
                </div>
                
                <div class="flex gap-2">
                    <form action="{{ route('cart.add', $item->product->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button 
                            type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm"
                        >
                            <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                        </button>
                    </form>
                    
                    <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST">
                        @csrf
                        <button 
                            type="submit"
                            class="bg-red-100 text-red-600 py-2 px-4 rounded-lg hover:bg-red-200 transition"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-heart text-gray-300 text-6xl mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Your wishlist is empty</h2>
        <p class="text-gray-600 mb-6">Add products you love to your wishlist!</p>
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition inline-block">
            Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection