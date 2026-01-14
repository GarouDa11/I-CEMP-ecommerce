@extends('layouts.app')

@section('title', 'Home - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    <!-- Banner Section -->
    <div class="bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl p-8 mb-8 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Cultural Week's Offer!</h2>
                <p class="text-lg opacity-90">Special discounts on selected items</p>
                <button class="mt-4 bg-white text-teal-600 px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition">
                    Shop Now
                </button>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-gift text-9xl opacity-20"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-3">
            @include('homepage.components.sidebar')
        </div>

        <!-- Main Content -->
        <div class="col-span-12 lg:col-span-9">
            <!-- Featured Clubs -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Featured Clubs</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('club.show', 'entrepreneurship') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Entrepreneurship Club</h3>
                                <p class="text-gray-600">Business merch & accessories</p>
                            </div>
                            <i class="fas fa-briefcase text-4xl text-blue-500"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('club.show', 'swimming') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Swimming Club</h3>
                                <p class="text-gray-600">Sports gear & equipment</p>
                            </div>
                            <i class="fas fa-swimming-pool text-4xl text-cyan-500"></i>
                        </div>
                    </a>
                </div>
            </section>

            <!-- Featured Products -->
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Featured Products</h2>
                    <a href="{{ route('products.all') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($products as $product)
                        @include('homepage.components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addToCart(productId) {
        alert('Added to cart! (Product ID: ' + productId + ')');
    }
    
    function toggleWishlist(productId) {
        alert('Added to wishlist! (Product ID: ' + productId + ')');
    }
</script>
@endpush
@endsection