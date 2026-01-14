@extends('layouts.app')

@section('title', 'My Orders - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">My Purchase</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button 
                    onclick="switchTab('all')"
                    class="tab-button px-6 py-4 text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition whitespace-nowrap border-b-2 border-transparent"
                    data-tab="all"
                >
                    All Orders
                </button>
                <button 
                    onclick="switchTab('to-pay')"
                    class="tab-button px-6 py-4 text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition whitespace-nowrap border-b-2 border-transparent"
                    data-tab="to-pay"
                >
                    To Pay
                </button>
                <button 
                    onclick="switchTab('pending')"
                    class="tab-button px-6 py-4 text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition whitespace-nowrap border-b-2 border-transparent"
                    data-tab="pending"
                >
                    Pending
                </button>
                <button 
                    onclick="switchTab('to-receive')"
                    class="tab-button px-6 py-4 text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition whitespace-nowrap border-b-2 border-transparent"
                    data-tab="to-receive"
                >
                    To Receive
                </button>
                <button 
                    onclick="switchTab('completed')"
                    class="tab-button px-6 py-4 text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition whitespace-nowrap border-b-2 border-transparent"
                    data-tab="completed"
                >
                    Completed
                </button>
                <button 
                    onclick="switchTab('return')"
                    class="tab-button px-6 py-4 text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition whitespace-nowrap border-b-2 border-transparent"
                    data-tab="return"
                >
                    Return/Refund
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <div id="tab-content">
                @forelse($orders as $order)
                <div class="border border-gray-200 rounded-lg mb-4 overflow-hidden hover:shadow-md transition">
                    <!-- Order Header -->
                    <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-b">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $order->created_at->format('d M Y, g:i A') }}
                            </span>
                            <span class="text-sm font-semibold text-gray-800">
                                Order #{{ $order->order_number }}
                            </span>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($order->status == 'completed') bg-green-100 text-green-700
                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status == 'to-receive') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700
                            @endif
                        ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <!-- Order Items -->
                    <div class="p-4">
                        @foreach($order->items as $item)
                        <div class="flex gap-4 mb-3 pb-3 border-b last:border-0 last:mb-0 last:pb-0">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <!-- Put product image here -->
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-1">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $item->product->club_name }}</p>
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800">RM {{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Footer -->
                    <div class="bg-gray-50 px-4 py-3 flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Total: <span class="text-lg font-bold text-blue-600 ml-2">RM {{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="flex gap-2">
                            @if($order->status == 'completed')
                            <button 
                                onclick="window.location.href='{{ route('order.buy-again', $order->id) }}'"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold"
                            >
                                Buy Again
                            </button>
                            <button 
                                onclick="window.location.href='{{ route('order.rate', $order->id) }}'"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-semibold"
                            >
                                Rate Products
                            </button>
                            @elseif($order->status == 'to-receive')
                            <button 
                                onclick="confirmReceived({{ $order->id }})"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold"
                            >
                                Order Received
                            </button>
                            @endif
                            <button 
                                onclick="window.location.href='{{ route('order.detail', $order->id) }}'"
                                class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition text-sm font-semibold"
                            >
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">No orders yet</p>
                    <button 
                        onclick="window.location.href='{{ route('home') }}'"
                        class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        Start Shopping
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@if($order->status == 'to-receive')
<button 
    onclick="markAsReceived({{ $order->id }})"
    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold"
>
    Order Received
</button>
@endif

@push('scripts')
<script>
function confirmReceived(orderId) {
    if (confirm('Confirm that you have received this order?')) {
        fetch(`/order/${orderId}/received`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Order marked as received!');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update order status');
        });
    }
}
</script>
@endpush
@endsection