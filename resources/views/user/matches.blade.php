@extends('user.layout.app')

@section('title', 'Live Matches')
@section('page-title', 'Live Matches')

@section('content')

<!-- Page Heading -->
<div class="mb-6">
    <h2 class="text-3xl font-bold mb-2">Match Center</h2>
    <p class="text-gray-400">Track live scores and upcoming fixtures.</p>
</div>

<!-- Filters -->
<div class="flex gap-3 mb-6">
    <button class="px-4 py-2 bg-blue-600 rounded-full text-sm">All</button>
    <button class="px-4 py-2 bg-gray-800 rounded-full text-sm hover:bg-gray-700">Live</button>
    <button class="px-4 py-2 bg-gray-800 rounded-full text-sm hover:bg-gray-700">Upcoming</button>
    <button class="px-4 py-2 bg-gray-800 rounded-full text-sm hover:bg-gray-700">Completed</button>
</div>

<!-- ================= LIVE MATCH ================= -->
<div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-6 rounded-2xl mb-6 border border-red-500/20">

    <!-- LIVE Badge -->
    <div class="flex justify-end mb-3">
        <span class="bg-red-500/20 text-red-400 px-3 py-1 text-xs rounded-full">
            🔴 LIVE
        </span>
    </div>

    <!-- Teams -->
    <div class="grid grid-cols-3 items-center text-center mb-6">

        <!-- Team 1 -->
        <div>
            <h3 class="text-2xl font-bold">India</h3>
            <p class="text-blue-400 text-lg">245/6 (40 ov)</p>
        </div>

        <!-- VS -->
        <div>
            <div class="bg-gray-700 w-12 h-12 mx-auto flex items-center justify-center rounded-full">
                VS
            </div>
            <p class="text-xs text-gray-400 mt-2">Cricket • 07:30 pm</p>
        </div>

        <!-- Team 2 -->
        <div>
            <h3 class="text-2xl font-bold">Australia</h3>
            <p class="text-blue-400 text-lg">198/4 (35 ov)</p>
        </div>

    </div>

    <!-- Bottom -->
    <div class="flex justify-between items-center">

        <p class="text-gray-400 text-sm">📍 MCG, Melbourne</p>

        <a href="{{route('contests')}}" class="bg-blue-500 px-5 py-2 rounded-full text-sm hover:bg-blue-600">
            ⚡ My Teams
        </a>

    </div>

</div>


<!-- ================= UPCOMING MATCH ================= -->
<div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-6 rounded-2xl border border-blue-500/20">

    <!-- Upcoming Badge -->
    <div class="flex justify-end mb-3">
        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 text-xs rounded-full">
            ⏳ UPCOMING
        </span>
    </div>

    <!-- Teams -->
    <div class="grid grid-cols-3 items-center text-center mb-6">

        <!-- Team 1 -->
        <div>
            <h3 class="text-2xl font-bold">Mumbai Indians</h3>
        </div>

        <!-- VS -->
        <div>
            <div class="bg-gray-700 w-12 h-12 mx-auto flex items-center justify-center rounded-full">
                VS
            </div>
            <p class="text-xs text-gray-400 mt-2">Cricket • 01:00 am</p>
        </div>

        <!-- Team 2 -->
        <div>
            <h3 class="text-2xl font-bold">Chennai Super Kings</h3>
        </div>

    </div>

    <!-- Bottom -->
    <div class="flex justify-end">
        <a href="{{route('contests')}}" class="bg-purple-600 px-5 py-2 rounded-full text-sm hover:bg-purple-700">
            Join Contests
        </a>
    </div>

</div>

@endsection