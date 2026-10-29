@extends('user.layout.app')

@section('title', 'Contests')
@section('page-title', 'Contests')

@section('content')

<!-- HEADER -->
<div class="mb-6">
    <h2 class="text-3xl font-bold">Contests</h2>
    <p class="text-gray-400 text-sm">
        Enter leagues and win massive prizes.
    </p>
</div>

<!-- CONTEST GRID -->
<div class="grid grid-cols-3 gap-6">

    <!-- ================= MEGA CONTEST ================= -->
    <div class="bg-gradient-to-br from-blue-900/40 to-gray-900 p-5 rounded-2xl border border-blue-500/20">

        <!-- Title -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-bold text-lg">Mega Contest</h3>
                <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-1 rounded">
                    MATCH #1
                </span>
            </div>

            <div class="text-blue-400 text-xl">🏆</div>
        </div>

        <!-- Prize + Entry -->
        <div class="flex justify-between mb-4">
            <div>
                <p class="text-gray-400 text-xs">PRIZE POOL</p>
                <h3 class="text-green-400 text-xl font-bold">$1,00,000</h3>
            </div>

            <div class="text-right">
                <p class="text-gray-400 text-xs">ENTRY FEE</p>
                <h3 class="font-bold">$49</h3>
            </div>
        </div>

        <!-- Progress -->
        <div class="mb-3">
            <div class="flex justify-between text-xs text-gray-400 mb-1">
                <span>3847 joined</span>
                <span>1153 spots left</span>
            </div>

            <div class="w-full bg-gray-700 h-2 rounded">
                <div class="bg-blue-500 h-2 rounded w-3/4"></div>
            </div>

            <p class="text-right text-xs text-gray-500 mt-1">77% full</p>
        </div>

        <!-- Button -->
        <button class="w-full bg-gray-700 py-2 rounded-xl text-gray-400 cursor-not-allowed">
            Closed
        </button>

    </div>

    <!-- ================= HEAD TO HEAD ================= -->
    <div class="bg-gradient-to-br from-purple-900/40 to-gray-900 p-5 rounded-2xl border border-purple-500/20">

        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-bold text-lg">Head to Head</h3>
                <span class="text-xs bg-purple-500/20 text-purple-400 px-2 py-1 rounded">
                    MATCH #1
                </span>
            </div>

            <div class="text-purple-400 text-xl">🏆</div>
        </div>

        <div class="flex justify-between mb-4">
            <div>
                <p class="text-gray-400 text-xs">PRIZE POOL</p>
                <h3 class="text-green-400 text-xl font-bold">$200</h3>
            </div>

            <div class="text-right">
                <p class="text-gray-400 text-xs">ENTRY FEE</p>
                <h3 class="font-bold">$99</h3>
            </div>
        </div>

        <div class="mb-3">
            <div class="flex justify-between text-xs text-gray-400 mb-1">
                <span>1 joined</span>
                <span>1 spot left</span>
            </div>

            <div class="w-full bg-gray-700 h-2 rounded">
                <div class="bg-purple-500 h-2 rounded w-1/2"></div>
            </div>

            <p class="text-right text-xs text-gray-500 mt-1">50% full</p>
        </div>

        <button class="w-full bg-gradient-to-r from-purple-500 to-pink-500 py-2 rounded-xl">
            Pay $99 — Join
        </button>

    </div>

    <!-- ================= SMALL LEAGUE ================= -->
    <div class="bg-gradient-to-br from-green-900/40 to-gray-900 p-5 rounded-2xl border border-green-500/20">

        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-bold text-lg">Small League</h3>
                <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded">
                    MATCH #1
                </span>
            </div>

            <div class="text-green-400 text-xl">🏆</div>
        </div>

        <div class="flex justify-between mb-4">
            <div>
                <p class="text-gray-400 text-xs">PRIZE POOL</p>
                <h3 class="text-green-400 text-xl font-bold">$5,000</h3>
            </div>

            <div class="text-right">
                <p class="text-gray-400 text-xs">ENTRY FEE</p>
                <h3 class="font-bold">$19</h3>
            </div>
        </div>

        <div class="mb-3">
            <div class="flex justify-between text-xs text-gray-400 mb-1">
                <span>312 joined</span>
                <span>188 spots left</span>
            </div>

            <div class="w-full bg-gray-700 h-2 rounded">
                <div class="bg-green-500 h-2 rounded w-2/3"></div>
            </div>
        </div>

        <button class="w-full bg-green-600 py-2 rounded-xl hover:bg-green-700">
            Join Contest
        </button>

    </div>

</div>

<!-- ================= WINNERS CIRCLE ================= -->
<div class="mt-8 grid grid-cols-3 gap-6">

    <div class="bg-gradient-to-br from-pink-900/40 to-gray-900 p-5 rounded-2xl border border-pink-500/20">

        <div class="flex justify-between mb-4">
            <h3 class="font-bold">Winners Circle</h3>
            <span class="text-pink-400">🏆</span>
        </div>

        <span class="text-xs bg-pink-500/20 text-pink-400 px-2 py-1 rounded">
            MATCH #1
        </span>

        <div class="flex justify-between mt-4">
            <div>
                <p class="text-gray-400 text-xs">PRIZE POOL</p>
                <h3 class="text-green-400 text-xl font-bold">$50,000</h3>
            </div>

            <div>
                <p class="text-gray-400 text-xs">ENTRY FEE</p>
                <h3>$99</h3>
            </div>
        </div>

    </div>

</div>

@endsection