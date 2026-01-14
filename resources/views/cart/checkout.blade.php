@extends('layouts.app')

@section('title', 'Checkout - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Delivery Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                        Delivery Information
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                            <input 
                                type="text" 
                                name="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ auth()->user()->name }}"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                            <input 
                                type="tel" 
                                name="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="01X-XXXX XXXX"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Delivery Address</label>
                            <textarea 
                                name="address"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Room/Block, College Name"
                                required
                            ></textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Additional Notes (Optional)</label>
                            <textarea 
                                name="notes"
                                rows="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Any special instructions..."
                            ></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-credit-card mr-2 text-blue-600"></i>
                        Payment Method
                    </h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="payment_method" value="tng" class="w-5 h-5 text-blue-600" checked>
                            <div class="ml-3 flex items-center justify-between flex-1">
                                <div>
                                    <p class="font-semibold text-gray-800">Touch 'n Go eWallet</p>
                                    <p class="text-sm text-gray-500">Pay with TnG eWallet</p>
                                </div>
                                <i class="fas fa-wallet text-2xl text-blue-600"></i>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="payment_method" value="fpx" class="w-5 h-5 text-blue-600">
                            <div class="ml-3 flex items-center justify-between flex-1">
                                <div>
                                    <p class="font-semibold text-gray-800">Online Banking (FPX)</p>
                                    <p class="text-sm text-gray-500">Select your bank</p>
                                </div>
                                <i class="fas fa-university text-2xl text-blue-600"></i>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="payment_method" value="card" class="w-5 h-5 text-blue-600">
                            <div class="ml-3 flex items-center justify-between flex-1">
                                <div>
                                    <p class="font-semibold text-gray-800">Credit/Debit Card</p>
                                    <p class="text-sm text-gray-500">Visa, Mastercard</p>
                                </div>
                                <i class="fas fa-credit-card text-2xl text-blue-600"></i>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-box mr-2 text-blue-600"></i>
                        Items Ordered ({{ $cartItems->count() }})
                    </h2>
                    
                    <div class="space-y-3">
                        @foreach($cartItems as $item)
                        <div class="flex gap-4 pb-3 border-b border-gray-200 last:border-0">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                <!-- Put product image here -->
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-600">RM {{ number_format($item->product->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>RM {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Discount</span>
                            <span class="text-green-600">-RM {{ number_format($discount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery Fee</span>
                            <span>FREE</span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-xl font-bold text-gray-800">
                            <span>Total</span>
                            <span class="text-blue-600">RM {{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition"
                    >
                        Place Order
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        By placing order, you agree to our Terms & Conditions
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection