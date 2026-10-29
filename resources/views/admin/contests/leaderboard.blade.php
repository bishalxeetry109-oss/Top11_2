@extends('admin.layout.app')

@section('title', 'Contest Leaderboard')
@section('page-title', 'Contest Leaderboard')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Contest Leaderboard</h2>
        <p class="text-gray-400">{{ $contest->name }} - {{ $contest->match->team_a }} vs {{ $contest->match->team_b }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.contests.calculateRankings', $contest->id) }}" 
           class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Calculate Rankings
        </a>
        <a href="{{ route('admin.contests.distributePrizes', $contest->id) }}" 
           class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Distribute Prizes
        </a>
        <a href="{{ route('managecontests', $contest->match_id) }}" 
           class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Contests
        </a>
    </div>
</div>

<!-- Contest Info Card -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6 mb-6">
    <div class="grid grid-cols-4 gap-6">
        <div>
            <p class="text-gray-400 text-sm">Contest Name</p>
            <p class="text-xl font-bold">{{ $contest->name }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-sm">Entry Fee</p>
            <p class="text-xl font-bold text-green-400">₹{{ number_format($contest->entry_fee, 2) }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-sm">Prize Pool</p>
            <p class="text-xl font-bold text-purple-400">₹{{ number_format($contest->prize_pool, 2) }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-sm">Total Entries</p>
            <p class="text-xl font-bold text-cyan-400">{{ $entries->count() }}</p>
        </div>
    </div>
</div>

<!-- Leaderboard Table -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Rank</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Team</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Points</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Winnings</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($entries as $entry)
                <tr class="table-row hover:bg-gray-800/50 transition-colors">
                    <td class="px-6 py-4">
                        @if($entry->rank === 1)
                            <span class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center text-sm font-bold text-black">
                                1
                            </span>
                        @elseif($entry->rank === 2)
                            <span class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-sm font-bold text-black">
                                2
                            </span>
                        @elseif($entry->rank === 3)
                            <span class="w-8 h-8 rounded-full bg-amber-700 flex items-center justify-center text-sm font-bold text-white">
                                3
                            </span>
                        @else
                            <span class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-sm font-bold">
                                {{ $entry->rank ?? '-' }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-sm font-bold">
                                {{ substr($entry->user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="font-semibold">{{ $entry->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $entry->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $entry->team->team_name }}</p>
                        <p class="text-xs text-gray-400">{{ $entry->team->players->count() }} players</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-green-400 font-bold text-lg">{{ $entry->points }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($entry->winnings > 0)
                            <span class="text-purple-400 font-bold">₹{{ number_format($entry->winnings, 2) }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                        No entries yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
