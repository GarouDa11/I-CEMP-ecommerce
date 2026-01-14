<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <a href="{{ route('product.show', $product->id) }}" class="block">
        <div class="relative pb-[100%] bg-gray-100">
            <img 
                src="{{ $product->image_url }}" 
                alt="{{ $product->name }}" 
                class="absolute inset-0 w-full h-full object-cover"
                onerror="this.src='https://via.placeholder.com/300?text=No+Image'"
            >
            
            @if($product->getDiscountPercentage() > 0)
            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                -{{ $product->getDiscountPercentage() }}%
            </span>
            @endif

            @if($product->stock < 10 && $product->stock > 0)
            <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded">
                Only {{ $product->stock }} left!
            </span>
            @elseif($product->stock == 0)
            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                Out of Stock
            </span>
            @endif
        </div>
    </a>
    
    <div class="p-4">
        <div class="text-xs text-gray-500 mb-1">{{ $product->committee->club_name }}</div>
        
        <a href="{{ route('product.show', $product->id) }}">
            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 h-12 hover:text-blue-600 transition">
                {{ $product->name }}
            </h3>
        </a>
        
        <div class="flex items-center justify-between mb-3">
            <div>
                <span class="text-xl font-bold text-blue-600">
                    RM {{ number_format($product->price, 2) }}
                </span>
                @if($product->original_price && $product->original_price > $product->price)
                <span class="text-sm text-gray-400 line-through ml-2">
                    RM {{ number_format($product->original_price, 2) }}
                </span>
                @endif
            </div>
        </div>

        @if($product->sold_count > 0)
        <div class="text-xs text-gray-500 mb-3">
            <i class="fas fa-fire text-orange-500 mr-1"></i>
            {{ $product->sold_count }} sold
        </div>
        @endif
        
        <div class="flex gap-2">
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                @csrf
                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition flex items-center justify-center text-sm font-semibold"
                    @if($product->stock == 0) disabled @endif
                >
                    <i class="fas fa-shopping-cart mr-2"></i>
                    {{ $product->stock == 0 ? 'Out of Stock' : 'Add to Cart' }}
                </button>
            </form>
            
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                @csrf
                <button 
                    type="submit"
                    class="bg-gray-100 text-gray-600 py-2 px-4 rounded-lg hover:bg-red-50 hover:text-red-500 transition"
                >
                    <i class="far fa-heart"></i>
                </button>
            </form>
        </div>
    </div>
</div>