@extends('admin.layout.app')

@section('title', 'Post Comments')
@section('page-title', 'Post Comments')

@section('content')

<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Post Comments</h2>
        <p class="text-gray-400">Manage comments on this post</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" 
       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Posts
    </a>
</div>

<!-- Post Card -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6 mb-6">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-lg font-bold">
            {{ substr($post->user->name, 0, 2) }}
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                <p class="font-semibold">{{ $post->user->name }}</p>
                <span class="px-2 py-1 rounded-full text-xs 
                    @if($post->type === 'news') bg-blue-500/20 text-blue-400
                    @elseif($post->type === 'result') bg-green-500/20 text-green-400
                    @else bg-purple-500/20 text-purple-400
                    @endif">
                    {{ ucfirst($post->type) }}
                </span>
                <span class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-gray-300 mb-4">{{ $post->content }}</p>
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="rounded-lg max-h-64 object-cover mb-4">
            @endif
            <div class="flex items-center gap-4 text-sm text-gray-400">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    {{ $post->likes }} likes
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    {{ $post->comments->count() }} comments
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Comments List -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-700">
        <h3 class="text-lg font-semibold">Comments ({{ $post->comments->count() }})</h3>
    </div>
    <div class="divide-y divide-gray-700">
        @forelse($post->comments as $comment)
        <div class="p-6 hover:bg-gray-800/50 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-sm font-bold">
                    {{ substr($comment->user->name, 0, 2) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <p class="font-semibold">{{ $comment->user->name }}</p>
                            <span class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <form action="{{ route('admin.posts.comments.delete', [$post->id, $comment->id]) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this comment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 rounded-lg text-xs bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                    <p class="text-gray-300">{{ $comment->comment }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-400">
            No comments yet
        </div>
        @endforelse
    </div>
</div>

@endsection
