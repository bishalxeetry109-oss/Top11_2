@extends('admin.layout.app')

@section('title', 'Create Contest')
@section('page-title', 'Create Contest')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Create New Contest</h2>
        <p class="text-gray-400">Create a contest for {{ $match->team_a }} vs {{ $match->team_b }}</p>
    </div>
    <a href="{{ route('contests.index', ['id'=>$id]) }}" 
       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Contests
    </a>
</div>

<!-- Match Info Card -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6 mb-6">
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
</div>

<!-- Create Contest Form -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6">
    <form action="{{ route('contests.store', $id) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- Contest Name -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Contest Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                       placeholder="e.g., Mega Contest">
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Entry Fee -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Entry Fee (₹)</label>
                <input type="number" name="entry_fee" value="{{ old('entry_fee') }}" min="0" step="0.01" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('entry_fee') border-red-500 @enderror"
                       placeholder="e.g., 49">
                @error('entry_fee')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- Prize Pool -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Prize Pool (₹)</label>
                <input type="number" name="prize_pool" value="{{ old('prize_pool') }}" min="0" step="0.01" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('prize_pool') border-red-500 @enderror"
                       placeholder="e.g., 100000">
                @error('prize_pool')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Max Spots -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Max Spots</label>
                <input type="number" name="max_spots" value="{{ old('max_spots') }}" min="2" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('max_spots') border-red-500 @enderror"
                       placeholder="e.g., 1000">
                @error('max_spots')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- First Prize (Optional) -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">First Prize (₹) - Optional</label>
                <input type="number" name="first_prize" value="{{ old('first_prize') }}" min="0" step="0.01"
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('first_prize') border-red-500 @enderror"
                       placeholder="e.g., 50000">
                @error('first_prize')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Winners Count (Optional) -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Winners Count - Optional</label>
                <input type="number" name="winners_count" value="{{ old('winners_count') }}" min="1"
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('winners_count') border-red-500 @enderror"
                       placeholder="e.g., 10">
                @error('winners_count')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('contests.index', ['id'=>$id]) }}" 
               class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center gap-2 transition-colors font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Contest
            </button>
        </div>
    </form>
</div>

@endsection
