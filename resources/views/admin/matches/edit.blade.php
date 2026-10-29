@extends('admin.layout.app')

@section('title', 'Edit Match')
@section('page-title', 'Edit Match')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Edit Match</h2>
        <p class="text-gray-400">Update match details</p>
    </div>
    <a href="{{ route('matches.index') }}" 
       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Matches
    </a>
</div>

<!-- Edit Match Form -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6">
    <form action="{{ route('matches.update', $match->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- Team A -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Team A</label>
                <input type="text" name="team_a" value="{{ old('team_a', $match->team_a) }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('team_a') border-red-500 @enderror"
                       placeholder="e.g., India">
                @error('team_a')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Team B -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Team B</label>
                <input type="text" name="team_b" value="{{ old('team_b', $match->team_b) }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('team_b') border-red-500 @enderror"
                       placeholder="e.g., Australia">
                @error('team_b')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- Sport -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Sport</label>
                <select name="sport" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('sport') border-red-500 @enderror">
                    <option value="Cricket" {{ old('sport', $match->sport) == 'Cricket' ? 'selected' : '' }}>Cricket</option>
                    <option value="Football" {{ old('sport', $match->sport) == 'Football' ? 'selected' : '' }}>Football</option>
                    <option value="Kabaddi" {{ old('sport', $match->sport) == 'Kabaddi' ? 'selected' : '' }}>Kabaddi</option>
                </select>
                @error('sport')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Venue -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Venue</label>
                <input type="text" name="venue" value="{{ old('venue', $match->venue) }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('venue') border-red-500 @enderror"
                       placeholder="e.g., Wankhede Stadium, Mumbai">
                @error('venue')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-3 gap-6 mb-6">
            <!-- Date -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Match Date</label>
                <input type="date" name="date" value="{{ old('date', $match->date) }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('date') border-red-500 @enderror">
                @error('date')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Time -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Match Time</label>
                <input type="time" name="time" value="{{ old('time', $match->match_time) }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('time') border-red-500 @enderror">
                @error('time')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Status</label>
                <select name="status" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('status') border-red-500 @enderror">
                    <option value="UPCOMING" {{ old('status', $match->status) == 'UPCOMING' ? 'selected' : '' }}>Upcoming</option>
                    <option value="LIVE" {{ old('status', $match->status) == 'LIVE' ? 'selected' : '' }}>Live</option>
                    <option value="DONE" {{ old('status', $match->status) == 'DONE' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('matches.index') }}" 
               class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center gap-2 transition-colors font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Update Match
            </button>
        </div>
    </form>
</div>

@endsection
