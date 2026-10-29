<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="flex h-screen">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-64 bg-gray-800 flex flex-col justify-between p-5">

        <!-- Logo -->
        <div>
            <h2 class="text-2xl font-bold mb-8 text-blue-400">🏆 TOP 11</h2>

            <!-- Menu -->
            <nav class="space-y-3">

                <a href="{{route('userdashboard')}}"
                   class="block px-3 py-2 rounded {{ request()->is('dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    Dashboard
                </a>

                <a href="{{route('myteams')}}"
                   class="block px-3 py-2 rounded {{ request()->is('myteams') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    My Teams
                </a>

                <a href="{{route('matches')}}"
                   class="block px-3 py-2 rounded {{ request()->is('matches') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    Matches
                </a>

                <a href="{{route('leaderboard')}}"
                   class="block px-3 py-2 rounded {{ request()->is('leaderboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    Leaderboard
                </a>

                <a href="{{route('news')}}"
                   class="block px-3 py-2 rounded {{ request()->is('news') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    News Feed
                </a>

            </nav>
        </div>

        <!-- Bottom -->
        <div>

            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button class="text-red-400">Sign Out</button>
            </form>
        </div>

    </aside>


    <!-- ================= MAIN AREA ================= -->
    <div class="flex-1 flex flex-col">

        <!-- ============ NAVBAR ============ -->
        <header class="bg-gray-800 px-6 py-4 flex justify-between items-center border-b border-gray-700">

            <!-- Page Title -->
            <h1 class="text-xl font-semibold">
                @yield('page-title')
            </h1>

            <!-- Right Section -->
            <div class="flex items-center gap-4">

                <!-- Balance -->
                <span class="bg-purple-600 px-4 py-1 rounded-full text-sm">
                    Balance $2450
                </span>

                <!-- User -->
                <div class="flex items-center gap-2">
                    <span class="text-sm">AlexStriker</span>

                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-sm">
                        AS
                    </div>
                </div>

            </div>

        </header>


        <!-- ============ CONTENT ============ -->
        <main class="p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>