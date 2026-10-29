@extends('user.layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-blue-900 to-purple-900 p-6 rounded-xl mb-6">
    <h2 class="text-2xl font-bold mb-2">
        Welcome back, <span class="text-blue-400">AlexStriker</span>
    </h2>
    <p class="text-gray-300 mb-4">
        Weekend contests are live. Build your team and climb the leaderboard.
    </p>

    <a href="/contests" class="bg-blue-500 px-5 py-2 rounded-lg hover:bg-blue-600">
        Join Contests →
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-4 gap-4 mb-6">

    <div class="bg-gray-800 p-4 rounded-xl text-center">
        <p class="text-gray-400 text-sm">Total Points</p>
        <h3 class="text-2xl font-bold text-blue-400">1,285</h3>
    </div>

    <div class="bg-gray-800 p-4 rounded-xl text-center">
        <p class="text-gray-400 text-sm">Global Rank</p>
        <h3 class="text-2xl font-bold text-purple-400">#42</h3>
    </div>

    <div class="bg-gray-800 p-4 rounded-xl text-center">
        <p class="text-gray-400 text-sm">Teams Created</p>
        <h3 class="text-2xl font-bold text-green-400">5</h3>
    </div>

    <div class="bg-gray-800 p-4 rounded-xl text-center">
        <p class="text-gray-400 text-sm">Wallet Balance</p>
        <h3 class="text-2xl font-bold text-yellow-400">$8,500</h3>
    </div>

</div>

<!-- Main Section -->
<div class="grid grid-cols-3 gap-6">

    <!-- Live Matches -->
    <div class="col-span-2">
        <h3 class="text-lg font-semibold mb-3">Live & Upcoming Matches</h3>

        <!-- Match Card -->
        <div class="bg-gray-800 p-4 rounded-xl mb-4 flex justify-between items-center">
            <div>
                <p class="font-bold">India vs Australia</p>
                <p class="text-green-400 text-sm">145/2 (15.2) • LIVE</p>
            </div>

            <a href="/contests" class="bg-blue-500 px-4 py-2 rounded-lg text-sm">
                View Contests
            </a>
        </div>

        <!-- Upcoming -->
        <div class="bg-gray-800 p-4 rounded-xl flex justify-between items-center">
            <div>
                <p class="font-bold">Manchester City vs Arsenal</p>
                <p class="text-yellow-400 text-sm">Starting Soon</p>
            </div>

            <a href="/contests" class="bg-blue-500 px-4 py-2 rounded-lg text-sm">
                View Contests
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div>
        <h3 class="text-lg font-semibold mb-3">Recent Activity</h3>

        <div class="bg-gray-800 p-4 rounded-xl space-y-4 text-sm">

            <div>
                <p>🏆 Won ₹2000 in IND vs AUS contest</p>
                <span class="text-gray-400">2h ago</span>
            </div>

            <div>
                <p>👥 Created team for SL vs PAK</p>
                <span class="text-gray-400">5h ago</span>
            </div>

            <div>
                <p>📈 Moved up 12 positions</p>
                <span class="text-gray-400">1 day ago</span>
            </div>

        </div>
    </div>

</div>

@endsection