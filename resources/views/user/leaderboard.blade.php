@extends('user.layout.app')

@section('title', 'Leaderboard')
@section('page-title', 'Leaderboard')

@section('content')

<!-- HEADER -->
<div class="text-center mb-10">

    <!-- Trophy Icon -->
    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-400 text-2xl">
        🏆
    </div>

    <h2 class="text-3xl font-bold text-yellow-400">
        Global Leaderboard
    </h2>

    <p class="text-gray-400 text-sm mt-2">
        The best of the best. Where do you stand?
    </p>

</div>

<!-- TOP 3 PLAYERS -->
<div class="flex justify-center items-end gap-8 mb-12">

    <!-- 2nd -->
    <div class="text-center">
        <div class="w-14 h-14 mx-auto rounded-full bg-gray-500 flex items-center justify-center mb-2">
            PR
        </div>
        <p class="text-sm text-gray-300">ProDrafter</p>

        <div class="bg-gray-700 w-32 h-24 rounded-t-xl flex items-center justify-center mt-3">
            2nd
        </div>
    </div>

    <!-- 1st -->
    <div class="text-center">
        <div class="w-16 h-16 mx-auto rounded-full bg-yellow-500 flex items-center justify-center mb-2 text-black font-bold">
            CR
        </div>
        <p class="text-sm text-yellow-400">CricketKing</p>

        <div class="bg-yellow-500/30 w-36 h-32 rounded-t-xl flex items-center justify-center mt-3 text-yellow-300 font-bold">
            1st
        </div>
    </div>

    <!-- 3rd -->
    <div class="text-center">
        <div class="w-14 h-14 mx-auto rounded-full bg-orange-500 flex items-center justify-center mb-2">
            AL
        </div>
        <p class="text-sm text-gray-300">AlexStriker</p>

        <div class="bg-orange-500/30 w-32 h-20 rounded-t-xl flex items-center justify-center mt-3">
            3rd
        </div>
    </div>

</div>

<!-- TABLE -->
<div class="bg-gray-800 rounded-2xl p-5">

    <!-- Table Header -->
    <div class="grid grid-cols-4 text-gray-400 text-sm border-b border-gray-700 pb-2 mb-3">
        <span>Rank</span>
        <span>Player</span>
        <span>Total Points</span>
        <span>Prize Won</span>
    </div>

    <!-- Row -->
    <div class="grid grid-cols-4 items-center py-3 border-b border-gray-700">

        <span class="text-yellow-400 font-bold">#1</span>

        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-xs">
                CR
            </div>
            CricketKing
        </div>

        <span class="text-green-400">15,420.5</span>

        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm w-fit">
            $5,000
        </span>

    </div>

    <!-- Row -->
    <div class="grid grid-cols-4 items-center py-3 border-b border-gray-700">

        <span>#2</span>

        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center text-xs">
                PR
            </div>
            ProDrafter
        </div>

        <span>14,980</span>

        <span class="bg-gray-600 px-3 py-1 rounded-full text-sm w-fit">
            $2,500
        </span>

    </div>

    <!-- Row -->
    <div class="grid grid-cols-4 items-center py-3">

        <span>#3</span>

        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-xs">
                AL
            </div>
            AlexStriker
        </div>

        <span>14,200</span>

        <span class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-sm w-fit">
            $1,000
        </span>

    </div>

</div>

@endsection