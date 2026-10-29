@extends('user.layout.app')

@section('title', 'My Teams')
@section('page-title', 'My Teams')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">My Teams</h2>

    <a href="/create-team"
       class="bg-blue-600 px-5 py-2 rounded-lg hover:bg-blue-700 shadow">
        + Create Team
    </a>
</div>

<!-- Teams Grid -->
<div class="grid grid-cols-2 gap-6">

    <!-- TEAM CARD -->
    <div class="bg-gray-800 rounded-2xl p-5 shadow-lg">

        <!-- Top -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Team 1</h3>
            <span class="text-xs bg-gray-700 px-2 py-1 rounded">
                2 Contests
            </span>
        </div>

        <!-- PLAYERS VISUAL (like ground view) -->
        <div class="bg-green-900/40 rounded-xl p-4 mb-4">

            <div class="grid grid-cols-3 gap-3 text-center text-xs">

                <!-- Player -->
                <div>
                    <div class="w-10 h-10 mx-auto bg-blue-500 rounded-full flex items-center justify-center">
                        WK
                    </div>
                    <p class="mt-1">Dhoni</p>
                </div>

                <div>
                    <div class="w-10 h-10 mx-auto bg-purple-500 rounded-full flex items-center justify-center">
                        BAT
                    </div>
                    <p class="mt-1">Kohli</p>
                </div>

                <div>
                    <div class="w-10 h-10 mx-auto bg-purple-500 rounded-full flex items-center justify-center">
                        BAT
                    </div>
                    <p class="mt-1">Rohit</p>
                </div>

                <div>
                    <div class="w-10 h-10 mx-auto bg-yellow-500 rounded-full flex items-center justify-center">
                        AR
                    </div>
                    <p class="mt-1">Stokes</p>
                </div>

                <div>
                    <div class="w-10 h-10 mx-auto bg-red-500 rounded-full flex items-center justify-center">
                        BOWL
                    </div>
                    <p class="mt-1">Bumrah</p>
                </div>

            </div>

        </div>

        <!-- Captain / VC -->
        <div class="flex justify-between text-sm mb-4">
            <span class="bg-blue-600 px-2 py-1 rounded text-xs">
                C: Kohli
            </span>

            <span class="bg-purple-600 px-2 py-1 rounded text-xs">
                VC: Rohit
            </span>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">

            <button class="text-blue-400 text-sm hover:underline">
                Edit Team
            </button>

            <a href="{{route('contests')}}"
               class="bg-green-500 px-4 py-2 rounded-lg text-sm hover:bg-green-600">
                Join Contest
            </a>

        </div>

    </div>


    <!-- SECOND TEAM -->
    <div class="bg-gray-800 rounded-2xl p-5 shadow-lg">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Team 2</h3>
            <span class="text-xs bg-gray-700 px-2 py-1 rounded">
                1 Contest
            </span>
        </div>

        <div class="bg-green-900/40 rounded-xl p-4 mb-4">
            <div class="grid grid-cols-3 gap-3 text-center text-xs">

                <div>
                    <div class="w-10 h-10 mx-auto bg-blue-500 rounded-full flex items-center justify-center">
                        WK
                    </div>
                    <p class="mt-1">Buttler</p>
                </div>

                <div>
                    <div class="w-10 h-10 mx-auto bg-purple-500 rounded-full flex items-center justify-center">
                        BAT
                    </div>
                    <p class="mt-1">Smith</p>
                </div>

                <div>
                    <div class="w-10 h-10 mx-auto bg-yellow-500 rounded-full flex items-center justify-center">
                        AR
                    </div>
                    <p class="mt-1">Maxwell</p>
                </div>

            </div>
        </div>

        <div class="flex justify-between text-sm mb-4">
            <span class="bg-blue-600 px-2 py-1 rounded text-xs">
                C: Smith
            </span>

            <span class="bg-purple-600 px-2 py-1 rounded text-xs">
                VC: Maxwell
            </span>
        </div>

        <div class="flex justify-between items-center">

            <button class="text-blue-400 text-sm hover:underline">
                Edit Team
            </button>

            <a href="/contests"
               class="bg-green-500 px-4 py-2 rounded-lg text-sm hover:bg-green-600">
                Join Contest
            </a>

        </div>

    </div>

</div>

@endsection