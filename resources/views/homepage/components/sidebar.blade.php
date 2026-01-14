<aside class="bg-white rounded-lg shadow-md p-4 sticky top-20">
    <h3 class="font-bold text-lg mb-4 text-gray-800">Categories</h3>
    
    <nav class="space-y-2">
        <a href="{{ route('category.show', 'merch') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group">
            <i class="fas fa-tshirt mr-3 text-gray-400 group-hover:text-blue-600"></i>
            <span>Merchandise</span>
        </a>
        
        <a href="{{ route('category.show', 'tech') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group">
            <i class="fas fa-laptop mr-3 text-gray-400 group-hover:text-blue-600"></i>
            <span>Tech Devices</span>
        </a>
        
        <a href="{{ route('category.show', 'arts') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group">
            <i class="fas fa-palette mr-3 text-gray-400 group-hover:text-blue-600"></i>
            <span>Arts & Crafts</span>
        </a>
        
        <a href="{{ route('category.show', 'clothing') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group">
            <i class="fas fa-shopping-bag mr-3 text-gray-400 group-hover:text-blue-600"></i>
            <span>Clothing</span>
        </a>
    </nav>

    <hr class="my-6">

    <h3 class="font-bold text-lg mb-4 text-gray-800">Help & Support</h3>
    
    <nav class="space-y-2">
        <a href="{{ route('help.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-question-circle mr-3 text-gray-400"></i>
            <span>Customer Service</span>
        </a>
        
        <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-cog mr-3 text-gray-400"></i>
            <span>Settings</span>
        </a>
    </nav>
</aside>