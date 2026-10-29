@extends('admin.layout.app')

@section('title', 'Contest Management')
@section('page-title', 'Contest Management')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Contest Management</h2>
        <p class="text-gray-400">Manage contests for {{ $match->team_a }} vs {{ $match->team_b }}</p>
    </div>
    <a href="{{ route('contests.create', ['id'=>$id]) }}" 
       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Create Contest
    </a>
</div>

<!-- Match Info Card -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold">{{ $match->team_a }} vs {{ $match->team_b }}</h3>
                <p class="text-gray-400">{{ $match->sport }} • {{ $match->venue }}</p>
                <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($match->date)->format('M d, Y') }} at {{ $match->match_time }}</p>
            </div>
        </div>
        <div class="text-right">
            @if($match->status === 'UPCOMING')
                <span class="px-4 py-2 rounded-full text-sm bg-yellow-500/20 text-yellow-400">Upcoming</span>
            @elseif($match->status === 'LIVE')
                <span class="px-4 py-2 rounded-full text-sm bg-green-500/20 text-green-400 animate-pulse">Live</span>
            @else
                <span class="px-4 py-2 rounded-full text-sm bg-gray-500/20 text-gray-400">Completed</span>
            @endif
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">TOTAL CONTESTS</p>
        <h3 class="text-2xl font-bold text-cyan-400">{{ $contests->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">OPEN</p>
        <h3 class="text-2xl font-bold text-green-400">{{ $contests->where('status', 'open')->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">LIVE</p>
        <h3 class="text-2xl font-bold text-yellow-400">{{ $contests->where('status', 'live')->count() }}</h3>
    </div>
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
        <p class="text-gray-400 text-xs">TOTAL PRIZE POOL</p>
        <h3 class="text-2xl font-bold text-purple-400">₹{{ number_format($contests->sum('prize_pool'), 2) }}</h3>
    </div>
</div>

<!-- Contests Table -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Contest</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Entry Fee</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Prize Pool</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Spots</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($contests as $contest)
                <tr class="table-row hover:bg-gray-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">{{ $contest->name }}</p>
                                <p class="text-xs text-gray-400">ID: {{ $contest->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-green-400 font-semibold">₹{{ number_format($contest->entry_fee, 2) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-purple-400 font-semibold">₹{{ number_format($contest->prize_pool, 2) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="text-white">{{ $contest->joined_spots }} / {{ $contest->max_spots }}</p>
                            <div class="w-full bg-gray-700 rounded-full h-2 mt-1">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($contest->joined_spots / $contest->max_spots) * 100 }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($contest->status === 'open')
                            <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400">Open</span>
                        @elseif($contest->status === 'live')
                            <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400 animate-pulse">Live</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs bg-gray-500/20 text-gray-400">Closed</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <!-- View Leaderboard -->
                            <a href="{{ route('admin.contests.leaderboard', $contest->id) }}" 
                               class="px-3 py-1 rounded-lg text-xs bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition-colors">
                                Leaderboard
                            </a>
                            
                            <!-- Edit -->
                            <a href="{{ route('admin.contests.edit', $contest->id) }}" 
                               class="px-3 py-1 rounded-lg text-xs bg-green-500/20 text-green-400 hover:bg-green-500/30 transition-colors">
                                Edit
                            </a>
                            
                            <!-- Delete -->
                            <form action="{{ route('admin.contests.destroy', $contest->id) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this contest?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 rounded-lg text-xs bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                        No contests found. <a href="{{ route('contests.create', ['id'=>$id]) }}" class="text-blue-400 hover:underline">Create your first contest</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
