@extends('layouts.app')

@section('title', $product->name . ' - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    {{-- Breadcrumb --}}
    <nav class="text-sm mb-6">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="{{ route('category.show', $product->category) }}" class="hover:text-blue-600">{{ ucfirst($product->category) }}</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-800">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Product Images --}}
        <div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                <div class="aspect-square bg-gray-100">
                    <img 
                        id="mainImage"
                        src="{{ $product->image_url }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-full object-cover"
                        onerror="this.src='https://via.placeholder.com/600?text=No+Image'"
                    >
                </div>
            </div>
            
            {{-- Thumbnail Gallery --}}
            @if($product->images && $product->images->count() > 0)
            <div class="grid grid-cols-4 gap-2">
                {{-- Main image as first thumbnail --}}
                <div 
                    class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 border-blue-500"
                    onclick="changeImage('{{ $product->image_url }}')"
                >
                    <img src="{{ $product->image_url }}" alt="Main view" class="w-full h-full object-cover">
                </div>
                
                {{-- Additional images --}}
                @foreach($product->images as $image)
                <div 
                    class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 border-transparent hover:border-blue-500 transition"
                    onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')"
                >
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product view" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Product Details --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            {{-- Club Name --}}
            <div class="mb-4">
                <a href="{{ route('club.show', $product->committee_id) }}" class="text-blue-600 hover:underline text-sm flex items-center">
                    <i class="fas fa-store mr-2"></i>
                    {{ $product->committee->club_name }}
                </a>
            </div>

            {{-- Product Name --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
            
            {{-- Price --}}
            <div class="flex items-baseline mb-4">
                <span class="text-4xl font-bold text-blue-600">RM {{ number_format($product->price, 2) }}</span>
                @if($product->original_price && $product->original_price > $product->price)
                <span class="text-xl text-gray-400 line-through ml-3">RM {{ number_format($product->original_price, 2) }}</span>
                <span class="ml-3 bg-red-500 text-white px-2 py-1 rounded text-sm font-bold">
                    -{{ $product->getDiscountPercentage() }}%
                </span>
                @endif
            </div>

            {{-- Stock & Sold Info --}}
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-box mr-2"></i>
                    <span class="text-sm">
                        Stock: <span class="font-semibold">{{ $product->stock }}</span>
                    </span>
                </div>
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-fire text-orange-500 mr-2"></i>
                    <span class="text-sm">
                        <span class="font-semibold">{{ $product->sold_count }}</span> sold
                    </span>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-2">Description</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
            </div>

            {{-- Specifications --}}
            @if($product->material || $product->size || $product->weight)
            <div class="mb-6 bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-3">Specifications</h3>
                <div class="space-y-2 text-gray-600 text-sm">
                    @if($product->material)
                    <div class="flex">
                        <span class="font-medium w-24">Material:</span>
                        <span>{{ $product->material }}</span>
                    </div>
                    @endif
                    
                    @if($product->size)
                    <div class="flex">
                        <span class="font-medium w-24">Size:</span>
                        <span>{{ $product->size }}</span>
                    </div>
                    @endif
                    
                    @if($product->weight)
                    <div class="flex">
                        <span class="font-medium w-24">Weight:</span>
                        <span>{{ $product->weight }}</span>
                    </div>
                    @endif
                    
                    <div class="flex">
                        <span class="font-medium w-24">Category:</span>
                        <span>{{ ucfirst($product->category) }}</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- Quantity Selector --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Quantity</label>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button 
                            onclick="decreaseQty()" 
                            class="px-4 py-2 hover:bg-gray-100 transition"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                        >
                            <i class="fas fa-minus"></i>
                        </button>
                        <input 
                            type="number" 
                            id="quantity" 
                            value="1" 
                            min="1" 
                            max="{{ $product->stock }}"
                            class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                        >
                        <button 
                            onclick="increaseQty()" 
                            class="px-4 py-2 hover:bg-gray-100 transition"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                        >
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <span class="text-gray-600">
                        @if($product->stock > 0)
                            {{ $product->stock }} available
                        @else
                            <span class="text-red-500 font-semibold">Out of Stock</span>
                        @endif
                    </span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3">
                @if($product->stock > 0)
                <form action="{{ route('checkout.buy-now') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="buy-now-quantity" value="1">
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition"
                    >
                        Buy Now
                    </button>
                </form>
                
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity" value="1">
                    <button 
                        type="submit"
                        class="w-full bg-blue-100 text-blue-600 py-3 px-6 rounded-lg font-semibold hover:bg-blue-200 transition"
                    >
                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                    </button>
                </form>
                @else
                <button 
                    disabled
                    class="flex-1 bg-gray-300 text-gray-500 py-3 px-6 rounded-lg font-semibold cursor-not-allowed"
                >
                    Out of Stock
                </button>
                @endif
                
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                    @csrf
                    <button 
                        type="submit"
                        class="bg-gray-100 text-gray-600 py-3 px-6 rounded-lg hover:bg-red-50 hover:text-red-500 transition {{ $isLiked ? 'text-red-500' : '' }}"
                    >
                        <i class="{{ $isLiked ? 'fas' : 'far' }} fa-heart text-xl"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function changeImage(imageSrc) {
        document.getElementById('mainImage').src = imageSrc;
        
        // Update border on thumbnails
        document.querySelectorAll('.aspect-square').forEach(thumb => {
            thumb.classList.remove('border-blue-500');
            thumb.classList.add('border-transparent');
        });
        event.currentTarget.classList.remove('border-transparent');
        event.currentTarget.classList.add('border-blue-500');
    }

    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
            // Update hidden inputs
            document.getElementById('buy-now-quantity').value = current + 1;
            document.getElementById('cart-quantity').value = current + 1;
        }
    }
    
    function decreaseQty() {
        const input = document.getElementById('quantity');
        const min = parseInt(input.min);
        const current = parseInt(input.value);
        if (current > min) {
            input.value = current - 1;
            // Update hidden inputs
            document.getElementById('buy-now-quantity').value = current - 1;
            document.getElementById('cart-quantity').value = current - 1;
        }
    }
    
    // Sync quantity when changed manually
    document.getElementById('quantity').addEventListener('change', function() {
        document.getElementById('buy-now-quantity').value = this.value;
        document.getElementById('cart-quantity').value = this.value;
    });
</script>
@endpush
@endsection