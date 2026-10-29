@extends('admin.layout.app')

@section('title', 'Match Management')
@section('page-title', 'Match Management')

@section('content')

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">Match Management</h2>
            <p class="text-gray-400">Create and manage cricket matches</p>
        </div>
        <a href="{{ route('matches.create') }}"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Match
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
            <p class="text-gray-400 text-xs">TOTAL MATCHES</p>
            <h3 class="text-2xl font-bold text-cyan-400">{{ $matches->count() }}</h3>
        </div>
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
            <p class="text-gray-400 text-xs">UPCOMING</p>
            <h3 class="text-2xl font-bold text-yellow-400">{{ $matches->where('status', 'UPCOMING')->count() }}</h3>
        </div>
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
            <p class="text-gray-400 text-xs">LIVE</p>
            <h3 class="text-2xl font-bold text-green-400">{{ $matches->where('status', 'LIVE')->count() }}</h3>
        </div>
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-4 rounded-xl">
            <p class="text-gray-400 text-xs">COMPLETED</p>
            <h3 class="text-2xl font-bold text-gray-400">{{ $matches->where('status', 'DONE')->count() }}</h3>
        </div>
    </div>

    <!-- Matches Table -->
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Match</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Sport</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Venue</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Date & Time</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Players</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Contests</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($matches as $match)
                        <tr class="table-row hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $match->team_a }} vs {{ $match->team_b }}</p>
                                        <p class="text-xs text-gray-400">ID: {{ $match->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-300">{{ $match->sport }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $match->venue }}</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-white">
                                        {{ \Carbon\Carbon::parse($match->start_time)->format('M d, Y') }}
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($match->start_time)->format('h:i A') }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($match->status === 'UPCOMING')
                                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400">Upcoming</span>
                                @elseif($match->status === 'LIVE')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400 animate-pulse">Live</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs bg-gray-500/20 text-gray-400">Completed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-cyan-400 font-semibold">{{ $match->players_count ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-purple-400 font-semibold">{{ $match->contests_count ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('matches.edit', $match->id) }}"
                                        class="px-3 py-1 rounded-lg text-xs bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition-colors">
                                        Edit
                                    </a>

                                    <!-- Add Players -->
                                    <a href="{{ route('matches.showNext', $match->id) }}"
                                        class="px-3 py-1 rounded-lg text-xs bg-green-500/20 text-green-400 hover:bg-green-500/30 transition-colors">
                                        Players
                                    </a>

                                    <!-- Contests -->
                                    <a href="{{ route('contests.index', ['id' => $match->id]) }}"
                                        class="px-3 py-1 rounded-lg text-xs bg-purple-500/20 text-purple-400 hover:bg-purple-500/30 transition-colors">
                                        Contests
                                    </a>

                                    <!-- Scores -->
                                    <a href="{{ route('admin.scores.index', $match->id) }}"
                                        class="px-3 py-1 rounded-lg text-xs bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 transition-colors">
                                        Scores
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('matches.destroy', $match->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this match?')">
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
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                No matches found. <a href="{{ route('matches.create') }}"
                                    class="text-blue-400 hover:underline">Create your first match</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection