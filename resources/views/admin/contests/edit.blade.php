@extends('admin.layout.app')

@section('title', 'Edit Contest')
@section('page-title', 'Edit Contest')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Edit Contest</h2>
        <p class="text-gray-400">Update contest details</p>
    </div>
    <a href="{{ route('managecontests', $contest->match_id) }}" 
       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Contests
    </a>
</div>

<!-- Edit Contest Form -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6">
    <form action="{{ route('admin.contests.update', $contest->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- Contest Name -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Contest Name</label>
                <input type="text" name="name" value="{{ old('name', $contest->name) }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                       placeholder="e.g., Mega Contest">
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Entry Fee -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Entry Fee (₹)</label>
                <input type="number" name="entry_fee" value="{{ old('entry_fee', $contest->entry_fee) }}" min="0" step="0.01" required
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
                <input type="number" name="prize_pool" value="{{ old('prize_pool', $contest->prize_pool) }}" min="0" step="0.01" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('prize_pool') border-red-500 @enderror"
                       placeholder="e.g., 100000">
                @error('prize_pool')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Max Spots -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Max Spots</label>
                <input type="number" name="max_spots" value="{{ old('max_spots', $contest->max_spots) }}" min="2" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('max_spots') border-red-500 @enderror"
                       placeholder="e.g., 1000">
                @error('max_spots')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-3 gap-6 mb-6">
            <!-- Status -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Status</label>
                <select name="status" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('status') border-red-500 @enderror">
                    <option value="open" {{ old('status', $contest->status) == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="live" {{ old('status', $contest->status) == 'live' ? 'selected' : '' }}>Live</option>
                    <option value="closed" {{ old('status', $contest->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- First Prize (Optional) -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">First Prize (₹) - Optional</label>
                <input type="number" name="first_prize" value="{{ old('first_prize', $contest->first_prize) }}" min="0" step="0.01"
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('first_prize') border-red-500 @enderror"
                       placeholder="e.g., 50000">
                @error('first_prize')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Winners Count (Optional) -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Winners Count - Optional</label>
                <input type="number" name="winners_count" value="{{ old('winners_count', $contest->winners_count) }}" min="1"
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500 @error('winners_count') border-red-500 @enderror"
                       placeholder="e.g., 10">
                @error('winners_count')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('managecontests', $contest->match_id) }}" 
               class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center gap-2 transition-colors font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Update Contest
            </button>
        </div>
    </form>
</div>

@endsection
