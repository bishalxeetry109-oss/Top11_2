<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Heroicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/style.css">
    
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
        
        /* Active menu item */
        .menu-item.active {
            background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        /* Card hover effect */
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
        
        /* Table row hover */
        .table-row:hover {
            background: rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-gray-900 text-white min-h-screen">

<div class="flex h-screen overflow-hidden">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-64 bg-gray-800 flex flex-col justify-between border-r border-gray-700">
        
        <!-- Logo -->
        <div class="p-5">
            <h2 class="text-2xl font-bold mb-8 text-blue-400 flex items-center gap-2">
                <span>🏆</span>
                <span>TOP 11</span>
            </h2>

            <!-- Menu -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'active' : 'hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('users.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('users*') ? 'active' : 'hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    <span>Users</span>
                </a>

                <a href="{{ route('matches.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('managematches*') ? 'active' : 'hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Matches</span>
                </a>

                <a href="{{ route('players.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('players*') ? 'active' : 'hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Players</span>
                </a>
                <a href="{{ route('posts.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('posts*') ? 'active' : 'hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span>Social Feed</span>
                </a>
            </nav>
        </div>

        <!-- Bottom -->
        <div class="p-5 border-t border-gray-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-400 hover:bg-gray-700 transition-all duration-200 w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>

    </aside>


    <!-- ================= MAIN AREA ================= -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- ============ NAVBAR ============ -->
        <header class="bg-gray-800 px-6 py-4 flex justify-between items-center border-b border-gray-700">

            <!-- Page Title -->
            <h1 class="text-xl font-semibold">
                @yield('page-title', 'Dashboard')
            </h1>

            <!-- Right Section -->
            <div class="flex items-center gap-4">

                <!-- Notifications -->
                <button class="relative p-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- User -->
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-medium">{{ session('user_name', 'Admin') }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-sm font-bold">
                        {{ substr(session('user_name', 'A'), 0, 2) }}
                    </div>
                </div>

            </div>

        </header>


        <!-- ============ CONTENT ============ -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

<!-- Toast Notifications -->
@if(session('success'))
<div id="toast-success" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    <span>{{ session('success') }}</span>
</div>
<script>
    setTimeout(() => {
        document.getElementById('toast-success').style.display = 'none';
    }, 3000);
</script>
@endif

@if(session('error'))
<div id="toast-error" class="fixed bottom-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
    <span>{{ session('error') }}</span>
</div>
<script>
    setTimeout(() => {
        document.getElementById('toast-error').style.display = 'none';
    }, 3000);
</script>
@endif

@yield('scripts')

</body>
</html>
