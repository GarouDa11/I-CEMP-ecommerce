@extends('layouts.app')

@section('title', 'Payment Successful - I-CEMP')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-blue-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <!-- Success Icon -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-center">
            <div class="w-24 h-24 mx-auto mb-4 bg-white rounded-full flex items-center justify-center">
                <i class="fas fa-check text-5xl text-green-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Payment Successful!</h1>
            <p class="text-green-100">Thank you for your purchase</p>
        </div>

        <!-- Payment Details -->
        <div class="p-8">
            <div class="text-center mb-6">
                <p class="text-gray-600 mb-4">Your payment has been processed successfully. You will receive a confirmation email shortly.</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount Paid</span>
                    <span class="font-bold text-gray-800">RM {{ number_format($order->total, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Transaction ID</span>
                    <span class="font-mono text-sm font-semibold text-gray-800">{{ $transaction->transaction_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Method</span>
                    <span class="text-gray-800">{{ ucfirst($transaction->method) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date</span>
                    <span class="text-gray-800">{{ $transaction->created_at->format('d M Y, g:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Merchant</span>
                    <span class="text-gray-800">I-CEMP</span>
                </div>
            </div>

            <div class="space-y-3">
                <button 
                    onclick="window.location.href='{{ route('order.detail', $order->id) }}'"
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition"
                >
                    View Order Details
                </button>
                
                <button 
                    onclick="window.location.href='{{ route('home') }}'"
                    class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition"
                >
                    Back to Home
                </button>
            </div>
        </div>
    </div>
</div>
@endsection