@extends('layouts.app')

@section('title', 'Add New Product - I-CEMP')

@section('content')
@include('homepage.components.header')

<div class="bg-gray-100 min-h-screen py-6">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Add New Product</h1>
                <p class="text-gray-600">Fill in the details to create a new product listing</p>
            </div>

            <form action="{{ route('committee.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Name *</label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror"
                        placeholder="e.g., Taekwondo Design Pin"
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
                        placeholder="Describe your product..."
                        required
                    >{{ old('description') }}</textarea>
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
                            value="{{ old('price') }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('price') border-red-500 @enderror"
                            placeholder="10.00"
                            required
                        >
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Original Price (RM) <span class="text-gray-500 text-sm">(Optional)</span></label>
                        <input 
                            type="number" 
                            name="original_price"
                            value="{{ old('original_price') }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="15.00"
                        >
                        <p class="text-sm text-gray-500 mt-1">For showing discount</p>
                    </div>
                </div>

                <!-- Stock & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Stock Quantity *</label>
                        <input 
                            type="number" 
                            name="stock"
                            value="{{ old('stock') }}"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('stock') border-red-500 @enderror"
                            placeholder="50"
                            required
                        >
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Category *</label>
                        <select 
                            name="category"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('category') border-red-500 @enderror"
                            required
                        >
                            <option value="">Select Category</option>
                            <option value="merch" {{ old('category') == 'merch' ? 'selected' : '' }}>Merchandise</option>
                            <option value="tech" {{ old('category') == 'tech' ? 'selected' : '' }}>Tech Devices</option>
                            <option value="arts" {{ old('category') == 'arts' ? 'selected' : '' }}>Arts & Crafts</option>
                            <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Specifications -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Material <span class="text-gray-500 text-sm">(Optional)</span></label>
                        <input 
                            type="text" 
                            name="material"
                            value="{{ old('material') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="e.g., Stainless Steel"
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Size <span class="text-gray-500 text-sm">(Optional)</span></label>
                        <input 
                            type="text" 
                            name="size"
                            value="{{ old('size') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="e.g., M, L, XL"
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Weight <span class="text-gray-500 text-sm">(Optional)</span></label>
                        <input 
                            type="text" 
                            name="weight"
                            value="{{ old('weight') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="e.g., 100g"
                        >
                    </div>
                </div>

                <!-- Product Image -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image <span class="text-gray-500 text-sm">(Optional)</span></label>
                    <input 
                        type="file" 
                        name="main_image"
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                        onchange="previewImage(event)"
                    >
                    <p class="text-sm text-gray-500 mt-1">Max 2MB (JPG, PNG, GIF)</p>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="preview" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg border-2 border-gray-300">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button 
                        type="submit"
                        class="flex-1 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Add Product
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
