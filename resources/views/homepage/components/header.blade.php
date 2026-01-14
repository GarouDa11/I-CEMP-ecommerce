<header class="bg-white shadow-md sticky top-0 z-50">
    <!-- Top Bar with Green to Turquoise Gradient -->
    <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-400">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- I-CEMP Logo + IIUM Logo -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="flex items-center space-x-4">
                        <!-- Your I-CEMP Logo -->
                        <img 
                            src="{{ asset('images/icemp-logo.png') }}" 
                            alt="I-CEMP" 
                            class="h-14 w-auto"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                        >
                        <div class="text-white font-bold text-2xl" style="display:none;">I-CEMP</div>
                        
                        <!-- Vertical Divider -->
                        <div class="h-14 w-0.5 bg-black/100"></div>
                        
                        <!-- IIUM Logo -->
                        <img 
                            src="{{ asset('images/iium-logo.png') }}" 
                            alt="IIUM" 
                            class="h-14 w-auto"
                            onerror="this.style.display='none';"
                        >
                    </a>
                </div>
                
                <!-- Search Bar - Desktop -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <div class="relative w-full">
                        <input 
                            type="text" 
                            placeholder="Search products, clubs..."
                            class="w-full px-4 py-2 pl-10 bg-white border border-white/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm"
                        >
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-6">
                    <!-- Cart Icon (Only for students) -->
                    @auth('web')
                    <a href="{{ route('cart.index') }}" class="relative hover:scale-110 transition">
                        <i class="fas fa-shopping-cart text-2xl text-gray-900"></i>
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>
                    @endauth
                    
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 hover:opacity-90 transition">
                            @auth('web')
                                {{-- Student User --}}
                                @if(auth()->user()->profile_photo)
                                    <img 
                                        src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                        alt="Profile" 
                                        class="w-9 h-9 rounded-full object-cover border-2 border-gray-900"
                                    >
                                @else
                                    <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center border-2 border-gray-900">
                                        <i class="fas fa-user text-gray-900"></i>
                                    </div>
                                @endif
                                <span class="hidden md:inline font-medium text-gray-900">{{ auth()->user()->name }}</span>
                            @elseauth('committee')
                                {{-- Committee User --}}
                                <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center border-2 border-gray-900">
                                    <i class="fas fa-store text-white"></i>
                                </div>
                                <span class="hidden md:inline font-medium text-gray-900">{{ auth('committee')->user()->club_name }}</span>
                            @else
                                {{-- Guest --}}
                                <i class="fas fa-user-circle text-2xl text-gray-900"></i>
                                <span class="hidden md:inline text-gray-900 font-medium">Guest</span>
                            @endauth
                            <i class="fas fa-chevron-down text-sm text-gray-900"></i>
                        </button>
                        
                        <!-- Dropdown -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-100">
                            @auth('web')
                                {{-- Student Menu --}}
                                <a href="{{ route('profile.index') }}" class="block px-4 py-3 hover:bg-teal-50 rounded-t-lg transition">
                                    <i class="fas fa-user mr-2 text-teal-600"></i> 
                                    <span class="text-gray-700">My Profile</span>
                                </a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-3 hover:bg-teal-50 transition">
                                    <i class="fas fa-shopping-bag mr-2 text-teal-600"></i> 
                                    <span class="text-gray-700">My Orders</span>
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-3 hover:bg-teal-50 transition">
                                    <i class="fas fa-heart mr-2 text-teal-600"></i> 
                                    <span class="text-gray-700">My Wishlist</span>
                                </a>
                                <hr class="my-1">
                                <a href="#" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="block px-4 py-3 hover:bg-red-50 text-red-600 rounded-b-lg transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                                </a>
                            @elseauth('committee')
                                {{-- Committee Menu --}}
                                <a href="{{ route('committee.dashboard') }}" class="block px-4 py-3 hover:bg-orange-50 rounded-t-lg transition">
                                    <i class="fas fa-tachometer-alt mr-2 text-orange-600"></i> 
                                    <span class="text-gray-700">Dashboard</span>
                                </a>
                                <a href="{{ route('committee.products') }}" class="block px-4 py-3 hover:bg-orange-50 transition">
                                    <i class="fas fa-box mr-2 text-orange-600"></i> 
                                    <span class="text-gray-700">My Products</span>
                                </a>
                                <a href="{{ route('committee.products.create') }}" class="block px-4 py-3 hover:bg-orange-50 transition">
                                    <i class="fas fa-plus-circle mr-2 text-orange-600"></i> 
                                    <span class="text-gray-700">Add Product</span>
                                </a>
                                <hr class="my-1">
                                <a href="#" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form-committee').submit();"
                                   class="block px-4 py-3 hover:bg-red-50 text-red-600 rounded-b-lg transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                                </a>
                            @else
                                {{-- Guest Menu --}}
                                <a href="{{ route('login') }}" class="block px-4 py-3 hover:bg-teal-50 rounded-t-lg transition">
                                    <i class="fas fa-sign-in-alt mr-2 text-teal-600"></i> 
                                    <span class="text-gray-700">Login</span>
                                </a>
                                <a href="{{ route('committee.login') }}" class="block px-4 py-3 hover:bg-orange-50 rounded-b-lg transition">
                                    <i class="fas fa-user-shield mr-2 text-orange-600"></i> 
                                    <span class="text-gray-700">Committee Login</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="md:hidden mt-3">
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Search products..."
                        class="w-full px-4 py-2 pl-10 bg-white border border-white/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm"
                    >
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Logout Forms -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    <form id="logout-form-committee" action="{{ route('committee.logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</header>