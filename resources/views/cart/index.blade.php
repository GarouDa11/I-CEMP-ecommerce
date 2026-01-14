@extends('layouts.app')

@section('title', 'Shopping Cart - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Shopping Cart</h1>

    @if($cartItems->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex gap-4">
                    <!-- Product Image -->
                    <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        <!-- Put product image here -->
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/100?text=No+Image'">
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $item->product->club_name }}</p>
                            </div>
                            <button onclick="removeFromCart({{ $item->id }})" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button 
                                    onclick="updateQuantity({{ $item->id }}, -1)"
                                    class="px-3 py-1 hover:bg-gray-100"
                                >
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <span class="px-4 py-1 border-x border-gray-300">{{ $item->quantity }}</span>
                                <button 
                                    onclick="updateQuantity({{ $item->id }}, 1)"
                                    class="px-3 py-1 hover:bg-gray-100"
                                >
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-blue-600">RM {{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                <p class="text-sm text-gray-500">RM {{ number_format($item->product->price, 2) }} each</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                        <span>RM {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Discount</span>
                        <span class="text-green-600">-RM {{ number_format($discount, 2) }}</span>
                    </div>
                    <hr>
                    <div class="flex justify-between text-xl font-bold text-gray-800">
                        <span>Total</span>
                        <span class="text-blue-600">RM {{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <button 
                    onclick="window.location.href='{{ route('checkout.index') }}'"
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition"
                >
                    Proceed to Checkout
                </button>

                <button 
                    onclick="window.location.href='{{ route('home') }}'"
                    class="w-full mt-3 border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition"
                >
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Your cart is empty</h2>
        <p class="text-gray-600 mb-6">Add some products to get started!</p>
        <button 
            onclick="window.location.href='{{ route('home') }}'"
            class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
        >
            Start Shopping
        </button>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function updateQuantity(itemId, change) {
        fetch(`/cart/update/${itemId}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ change: change })
        }).then(() => location.reload());
    }
    
    function removeFromCart(itemId) {
        if (confirm('Remove this item from cart?')) {
            fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        }
    }
</script>
@endpush
@endsection