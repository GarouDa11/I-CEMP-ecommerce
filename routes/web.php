<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Committee;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// ============================================================
// Authentication Routes
// ============================================================
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $credentials = request()->validate([
        'student_id' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('matric_id', $credentials['student_id'])->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        Auth::login($user);
        return redirect()->route('home')->with('success', 'Login successful!');
    }

    return back()->withErrors([
        'student_id' => 'Invalid credentials.',
    ])->withInput();
})->name('login.submit');

Route::get('/committee-login', function () {
    return view('auth.committee-login');
})->name('committee.login');

Route::post('/committee-login', function () {
    $credentials = request()->validate([
        'committee_id' => 'required',
        'password' => 'required',
    ]);

    $committee = Committee::where('committee_id', $credentials['committee_id'])->first();

    if ($committee && Hash::check($credentials['password'], $committee->password)) {
        Auth::guard('committee')->login($committee);
        return redirect()->route('committee.dashboard')->with('success', 'Welcome back, ' . $committee->club_name . '!');
    }

    return back()->withErrors([
        'committee_id' => 'Invalid credentials.',
    ])->withInput();
})->name('committee.login.submit');

// Student Logout
Route::post('/logout', function () {
    Auth::logout();
    session()->flush();
    session()->regenerate();
    return redirect()->route('login')->with('status', 'You have been logged out successfully.');
})->name('logout');

Route::get('/logout', function () {
    Auth::logout();
    session()->flush();
    session()->regenerate();
    return redirect()->route('login')->with('status', 'You have been logged out successfully.');
});

// Committee Logout
Route::post('/committee-logout', function () {
    Auth::guard('committee')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('status', 'You have been logged out successfully.');
})->name('committee.logout');

// ============================================================
// Homepage & Main Routes
// ============================================================
Route::get('/', function () {
    $products = Product::with('committee')
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get();
    
    return view('homepage.index', compact('products'));
})->name('home');

Route::get('/products', function () {
    $products = Product::with('committee')
        ->where('is_active', true)
        ->paginate(20);
    
    return view('homepage.index', compact('products'));
})->name('products.all');

// ============================================================
// Club Routes
// ============================================================
Route::get('/club/{id}', function ($id) {
    $club = Committee::findOrFail($id);
    $products = Product::where('committee_id', $id)
        ->where('is_active', true)
        ->paginate(20);
    
    return view('club.index', compact('club', 'products'));
})->name('club.show');

// ============================================================
// Product Routes
// ============================================================
Route::get('/product/{id}', function ($id) {
    $product = Product::with(['committee', 'images'])->findOrFail($id);
    
    $isLiked = false;
    if (auth()->check()) {
        $isLiked = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->exists();
    }
    
    return view('club.show', compact('product', 'isLiked'));
})->name('product.show');

// ============================================================
// Category Routes
// ============================================================
Route::get('/category/{category}', function ($category) {
    $products = Product::with('committee')
        ->where('category', $category)
        ->where('is_active', true)
        ->paginate(20);
    
    return view('homepage.index', compact('products'));
})->name('category.show');

// ============================================================
// Cart Routes (Protected)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/cart', function () {
        $cartItems = Cart::with('product.committee')
            ->where('user_id', auth()->id())
            ->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        $discount = 0;
        $total = $subtotal - $discount;
        
        return view('cart.index', compact('cartItems', 'subtotal', 'discount', 'total'));
    })->name('cart.index');

    // FIXED: Return back with success message instead of JSON
    Route::post('/cart/add/{productId}', function ($productId) {
        $product = Product::findOrFail($productId);
        
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();
        
        if ($cartItem) {
            if ($cartItem->quantity < $product->stock) {
                $cartItem->quantity += 1;
                $cartItem->save();
            }
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => request('quantity', 1),
            ]);
        }
        
        // Redirect back with toast notification
        return back()->with('success', '✅ Product added to cart successfully!');
    })->name('cart.add');

    Route::patch('/cart/update/{itemId}', function ($itemId) {
        $cartItem = Cart::where('id', $itemId)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        $change = request('change', 0);
        $newQuantity = $cartItem->quantity + $change;
        
        if ($newQuantity <= 0) {
            $cartItem->delete();
        } else if ($newQuantity <= $cartItem->product->stock) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        }
        
        return response()->json(['success' => true]);
    })->name('cart.update');

    Route::delete('/cart/remove/{itemId}', function ($itemId) {
        Cart::where('id', $itemId)
            ->where('user_id', auth()->id())
            ->delete();
        
        return response()->json(['success' => true]);
    })->name('cart.remove');
});

// ============================================================
// Wishlist Routes (Protected)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', function () {
        $wishlist = Wishlist::with('product.committee')
            ->where('user_id', auth()->id())
            ->get();
        
        return view('wishlist.index', compact('wishlist'));
    })->name('wishlist.index');

    // FIXED: Return back with success message instead of JSON
    Route::post('/wishlist/toggle/{productId}', function ($productId) {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Removed from wishlist');
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
            return back()->with('success', '❤️ Added to wishlist!');
        }
    })->name('wishlist.toggle');
});

// ============================================================
// Checkout Routes (Protected)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/checkout', function () {
        $cartItems = Cart::with('product.committee')
            ->where('user_id', auth()->id())
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        $discount = 0;
        $total = $subtotal - $discount;
        
        return view('cart.checkout', compact('cartItems', 'subtotal', 'discount', 'total'));
    })->name('checkout.index');

    // Buy Now - Direct Checkout (POST)
    Route::post('/checkout/buy-now', function () {
        $validated = request()->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        
        // Check stock
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock!');
        }
        
        // Store in session for checkout
        session([
            'buy_now_product' => [
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]
        ]);
        
        return redirect()->route('checkout.buy-now.page');
    })->name('checkout.buy-now');

    // Buy Now Checkout Page (GET)
    Route::get('/checkout/buy-now-page', function () {
        $buyNow = session('buy_now_product');
        
        if (!$buyNow) {
            return redirect()->route('home')->with('error', 'No product selected!');
        }
        
        $product = Product::with('committee')->findOrFail($buyNow['product_id']);
        $quantity = $buyNow['quantity'];
        
        // Create a fake cart item structure for the checkout view
        $cartItems = collect([
            (object)[
                'product' => $product,
                'quantity' => $quantity,
            ]
        ]);
        
        $subtotal = $product->price * $quantity;
        $discount = 0;
        $total = $subtotal;
        
        return view('cart.checkout', compact('cartItems', 'subtotal', 'discount', 'total'));
    })->name('checkout.buy-now.page');

    // FIXED: Process checkout with real order creation
    Route::post('/checkout/process', function () {
        // Check if it's buy now or cart checkout
        $buyNow = session('buy_now_product');
        
        if ($buyNow) {
            // Buy Now checkout
            $product = Product::findOrFail($buyNow['product_id']);
            $cartItems = collect([
                (object)[
                    'product' => $product,
                    'product_id' => $product->id,
                    'quantity' => $buyNow['quantity'],
                ]
            ]);
        } else {
            // Regular cart checkout
            $cartItems = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty!');
            }
        }
        
        // Validate delivery info
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:tng,fpx,card',
        ]);
        
        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        $discount = 0;
        $total = $subtotal - $discount;
        
        // Create order
        $order = Order::create([
            'order_number' => 'ORD' . strtoupper(substr(uniqid(), -8)),
            'user_id' => auth()->id(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'status' => 'to-receive',
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
            'delivery_address' => $validated['address'],
            'phone' => $validated['phone'],
            'name' => $validated['name'],
            'notes' => $validated['notes'],
        ]);
        
        // Create order items and update product stock
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
            
            // Update product stock and sold count
            $product = Product::find($cartItem->product_id);
            $product->stock -= $cartItem->quantity;
            $product->sold_count += $cartItem->quantity;
            $product->save();
        }
        
        // Clear cart if it was cart checkout (not buy now)
        if (!$buyNow) {
            Cart::where('user_id', auth()->id())->delete();
        }
        
        // Clear buy now session
        session()->forget('buy_now_product');
        
        return redirect()->route('order.success', ['orderId' => $order->id]);
    })->name('checkout.process');
});

// ============================================================
// Order Routes (Protected)
// ============================================================
Route::middleware('auth')->group(function () {
    // FIXED: Get real orders from database
    Route::get('/orders', function () {
        $status = request('status', 'all');
        
        $query = Order::with(['items.product.committee'])
            ->where('user_id', auth()->id());
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $orders = $query->latest()->get();
        
        return view('order.index', compact('orders'));
    })->name('orders.index');

    Route::get('/order/{id}', function ($id) {
        $order = Order::with(['items.product'])->findOrFail($id);
        
        // Verify it's the user's order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('order.detail', compact('order'));
    })->name('order.detail');

    // FIXED: Show real order with correct payment method
    Route::get('/order/success/{orderId}', function ($orderId) {
        $order = Order::with(['items.product'])->findOrFail($orderId);
        
        // Verify it's the user's order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Map payment method to display name
        $paymentMethods = [
            'tng' => 'TnG eWallet',
            'fpx' => 'FPX Online Banking',
            'card' => 'Credit/Debit Card',
        ];
        
        $transaction = (object)[
            'transaction_id' => strtoupper(substr(md5($order->id . time()), 0, 16)),
            'method' => $paymentMethods[$order->payment_method] ?? 'TnG eWallet',
            'created_at' => $order->created_at
        ];
        
        return view('order.success', compact('order', 'transaction'));
    })->name('order.success');

    Route::post('/order/{id}/received', function ($id) {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        $order->status = 'completed';
        $order->save();
        
        return response()->json(['success' => true]);
    })->name('order.received');

    Route::get('/order/{id}/buy-again', function ($id) {
        $order = Order::with('items')->findOrFail($id);
        
        // Add all order items back to cart
        foreach ($order->items as $item) {
            $existingCart = Cart::where('user_id', auth()->id())
                ->where('product_id', $item->product_id)
                ->first();
            
            if ($existingCart) {
                $existingCart->quantity += $item->quantity;
                $existingCart->save();
            } else {
                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                ]);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Items added to cart!');
    })->name('order.buy-again');

    Route::get('/order/{id}/rate', function ($id) {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order.rate', compact('order'));
    })->name('order.rate');
});

// ============================================================
// Profile Routes (Protected)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::patch('/profile/update', function () {
        $user = auth()->user();
        
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'mahallah' => 'nullable|string|max:255',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', 'Profile updated successfully!');
    })->name('profile.update');

    Route::post('/profile/photo', function () {
        request()->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::delete('public/' . $user->profile_photo);
        }

        $path = request()->file('profile_photo')->store('profile_photos', 'public');

        $user->update([
            'profile_photo' => $path,
        ]);

        return back()->with('success', 'Profile photo updated successfully!');
    })->name('profile.photo.update');
});

// ============================================================
// Committee Protected Routes
// ============================================================
Route::middleware('committee')->prefix('committee')->name('committee.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        $committee = auth('committee')->user();
        $products = Product::where('committee_id', $committee->id)->get();
        $totalProducts = $products->count();
        $totalSales = $products->sum('sold_count');
        $totalRevenue = $products->sum(function($product) {
            return $product->price * $product->sold_count;
        });
        
        return view('committee.dashboard', compact('committee', 'products', 'totalProducts', 'totalSales', 'totalRevenue'));
    })->name('dashboard');
    
    // Products Management
    Route::get('/products', function () {
        $committee = auth('committee')->user();
        $products = Product::where('committee_id', $committee->id)->paginate(10);
        
        return view('committee.products.index', compact('products'));
    })->name('products');
    
    // Create Product
    Route::get('/products/create', function () {
        return view('committee.products.create');
    })->name('products.create');
    
    Route::post('/products', function () {
        $committee = auth('committee')->user();
        
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'category' => 'required|in:merch,tech,arts,clothing',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if (request()->hasFile('main_image')) {
            $path = request()->file('main_image')->store('products', 'public');
            $validated['main_image'] = $path;
        }
        
        $validated['committee_id'] = $committee->id;
        $validated['is_active'] = true;
        $validated['sold_count'] = 0;
        
        Product::create($validated);
        
        return redirect()->route('committee.products')->with('success', 'Product added successfully!');
    })->name('products.store');
    
    // Edit Product
    Route::get('/products/{id}/edit', function ($id) {
        $committee = auth('committee')->user();
        $product = Product::where('committee_id', $committee->id)->findOrFail($id);
        
        return view('committee.products.edit', compact('product'));
    })->name('products.edit');
    
    Route::put('/products/{id}', function ($id) {
        $committee = auth('committee')->user();
        $product = Product::where('committee_id', $committee->id)->findOrFail($id);
        
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'category' => 'required|in:merch,tech,arts,clothing',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);
        
        if (request()->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::delete('public/' . $product->main_image);
            }
            $path = request()->file('main_image')->store('products', 'public');
            $validated['main_image'] = $path;
        }
        
        $product->update($validated);
        
        return redirect()->route('committee.products')->with('success', 'Product updated successfully!');
    })->name('products.update');
    
    // Delete Product
    Route::delete('/products/{id}', function ($id) {
        $committee = auth('committee')->user();
        $product = Product::where('committee_id', $committee->id)->findOrFail($id);
        
        if ($product->main_image) {
            Storage::delete('public/' . $product->main_image);
        }
        
        $product->delete();
        
        return redirect()->route('committee.products')->with('success', 'Product deleted successfully!');
    })->name('products.destroy');
});
// ============================================================
// Admin Authentication Routes
// ============================================================
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function () {
    $credentials = request()->validate([
        'admin_id' => 'required',
        'password' => 'required',
    ]);

    $admin = \App\Models\Admin::where('admin_id', $credentials['admin_id'])->first();

    if ($admin && Hash::check($credentials['password'], $admin->password)) {
        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $admin->name . '!');
    }

    return back()->withErrors([
        'admin_id' => 'Invalid credentials.',
    ])->withInput();
})->name('admin.login.submit');

Route::post('/admin/logout', function () {
    Auth::guard('admin')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('admin.login')->with('status', 'Logged out successfully.');
})->name('admin.logout');

// ============================================================
// Admin Protected Routes
// ============================================================
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        $admin = auth('admin')->user();
        
        // Statistics
        $totalUsers = \App\Models\User::count();
        $totalCommittees = \App\Models\Committee::count();
        $totalProducts = \App\Models\Product::count();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::sum('total');
        
        // Recent activities
        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
        $topProducts = \App\Models\Product::orderBy('sold_count', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact(
            'admin', 'totalUsers', 'totalCommittees', 'totalProducts', 
            'totalOrders', 'totalRevenue', 'recentOrders', 'topProducts'
        ));
    })->name('dashboard');
    
    // Manage Committees (Sellers)
    Route::get('/committees', function () {
        $committees = \App\Models\Committee::withCount('products')->get();
        return view('admin.committees.index', compact('committees'));
    })->name('committees.index');
    
    Route::patch('/committees/{id}/toggle', function ($id) {
        $committee = \App\Models\Committee::findOrFail($id);
        
        // Add is_approved column to committees table first via migration
        $committee->is_approved = !$committee->is_approved;
        $committee->save();
        
        return back()->with('success', 'Committee status updated!');
    })->name('committees.toggle');
    
    // Platform Settings
    Route::get('/settings', function () {
        $settings = \App\Models\PlatformSetting::all();
        return view('admin.settings', compact('settings'));
    })->name('settings');
    
    Route::post('/settings', function () {
        $settings = request()->all();
        
        foreach ($settings as $key => $value) {
            if ($key !== '_token') {
                \App\Models\PlatformSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }
        
        return back()->with('success', 'Settings updated successfully!');
    })->name('settings.update');
    
    // Manage Users
    Route::get('/users', function () {
        $users = \App\Models\User::latest()->get();
        return view('admin.users.index', compact('users'));
    })->name('users.index');
    
    // View All Products
    Route::get('/products', function () {
        $products = \App\Models\Product::with('committee')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    })->name('products.index');
    
    // View All Orders
    Route::get('/orders', function () {
        $orders = \App\Models\Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    })->name('orders.index');
});
// ============================================================
// Help & Settings Routes
// ============================================================
Route::get('/help', function () {
    return view('help.index');
})->name('help.index');

Route::get('/settings', function () {
    return view('settings.index');
})->name('settings.index');