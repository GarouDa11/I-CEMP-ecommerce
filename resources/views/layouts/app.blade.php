<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'I-CEMP E-Commerce')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    {{-- Success/Error Messages Toast --}}
    @if (session('success'))
    <div id="toast-success" class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in">
        <i class="fas fa-check-circle text-2xl"></i>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div id="toast-error" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in">
        <i class="fas fa-exclamation-circle text-2xl"></i>
        <span class="font-semibold">{{ session('error') }}</span>
    </div>
    @endif

    @yield('content')
    
    @stack('scripts')
    
    <script>
        // Auto-hide toasts after 3 seconds
        setTimeout(function() {
            const toasts = document.querySelectorAll('[id^="toast-"]');
            toasts.forEach(toast => {
                if (toast) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.transition = 'all 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }
            });
        }, 3000);
    </script>
    
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
    </style>
</body>
</html>