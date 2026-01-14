@extends('layouts.app')

@section('title', 'Edit Product - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="bg-gray-100 min-h-screen py-6">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Product</h1>
                <p class="text-gray-600">Update product details</p>
            </div>

            <form action="{{ route('committee.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Name *</label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description *</label>
                    <textarea 
                        name="description"
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('description') border-red-500 @enderror"
                        required
                    >{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price & Original Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Current Price (RM) *</label>
                        <input 
                            type="number" 
                            name="price"
                            value="{{ old('price', $product->price) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Original Price (RM)</label>
                        <input 
                            type="number" 
                            name="original_price"
                            value="{{ old('original_price', $product->original_price) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                        >
                    </div>
                </div>

                <!-- Stock & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Stock Quantity *</label>
                        <input 
                            type="number" 
                            name="stock"
                            value="{{ old('stock', $product->stock) }}"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Category *</label>
                        <select 
                            name="category"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required
                        >
                            <option value="merch" {{ $product->category == 'merch' ? 'selected' : '' }}>Merchandise</option>
                            <option value="tech" {{ $product->category == 'tech' ? 'selected' : '' }}>Tech Devices</option>
                            <option value="arts" {{ $product->category == 'arts' ? 'selected' : '' }}>Arts & Crafts</option>
                            <option value="clothing" {{ $product->category == 'clothing' ? 'selected' : '' }}>Clothing</option>
                        </select>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Material</label>
                        <input 
                            type="text" 
                            name="material"
                            value="{{ old('material', $product->material) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Size</label>
                        <input 
                            type="text" 
                            name="size"
                            value="{{ old('size', $product->size) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Weight</label>
                        <input 
                            type="text" 
                            name="weight"
                            value="{{ old('weight', $product->weight) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                        >
                    </div>
                </div>

                <!-- Current Image & Upload New -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    
                    @if($product->main_image)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-48 h-48 object-cover rounded-lg border-2 border-gray-300">
                    </div>
                    @endif
                    
                    <input 
                        type="file" 
                        name="main_image"
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                        onchange="previewImage(event)"
                    >
                    <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                    
                    <!-- New Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                        <img id="preview" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg border-2 border-green-500">
                    </div>
                </div>

                <!-- Active Status -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ $product->is_active ? 'checked' : '' }}
                            class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500"
                        >
                        <span class="ml-2 text-gray-700 font-semibold">Product is Active (visible to customers)</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button 
                        type="submit"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Update Product
                    </button>
                    <a 
                        href="{{ route('committee.products') }}"
                        class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection