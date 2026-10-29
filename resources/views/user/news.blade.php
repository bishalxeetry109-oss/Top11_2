@extends('user.layout.app')

@section('title', 'News Feed')
@section('page-title', 'News Feed')

@section('content')

<!-- PAGE HEADER -->
<div class="mb-6">
    <h2 class="text-2xl font-bold">Community Feed</h2>
    <p class="text-gray-400 text-sm">
        Discuss strategies and celebrate wins.
    </p>
</div>

<!-- CREATE POST BOX -->
<div class="bg-gradient-to-r from-gray-800 to-gray-900 p-5 rounded-2xl mb-6 border border-gray-700">

    <div class="flex gap-4">

        <!-- Avatar -->
        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500"></div>

        <!-- Input -->
        <div class="flex-1">
            <textarea
                placeholder="Share your thoughts or team strategy..."
                class="w-full bg-gray-900 border border-gray-700 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                rows="3"></textarea>

            <div class="flex justify-between items-center mt-3">

                <!-- Upload -->
                <label class="text-gray-400 text-sm cursor-pointer hover:text-white">
                    📷 Photo
                    <input type="file" class="hidden">
                </label>

                <!-- Post Button -->
                <button class="bg-blue-600 px-5 py-2 rounded-full text-sm hover:bg-blue-700">
                    ➤ Post
                </button>

            </div>
        </div>

    </div>

</div>

<!-- POSTS -->
<div class="space-y-5">

    <!-- POST CARD -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 p-5 rounded-2xl border border-gray-700">

        <!-- USER INFO -->
        <div class="flex items-center gap-3 mb-3">

            <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-sm font-bold">
                CR
            </div>

            <div>
                <p class="font-semibold">CricketFan99</p>
                <span class="text-xs text-gray-400">about 2 hours ago</span>
            </div>

        </div>

        <!-- TEXT -->
        <p class="mb-4 text-sm text-gray-300">
            What a crazy finish to the IND vs AUS match! Who had Maxwell as captain? 🔥
        </p>

        <!-- IMAGE -->
        <img src="https://images.unsplash.com/photo-1593766788306-28561086694e"
             class="rounded-xl mb-4 w-full h-64 object-cover" />

        <!-- ACTIONS -->
        <div class="flex justify-between items-center text-sm text-gray-400">

            <div class="flex gap-6">
                <span class="hover:text-white cursor-pointer">❤️ 245</span>
                <span class="hover:text-white cursor-pointer">💬 42</span>
            </div>

            <span class="hover:text-white cursor-pointer">🔗 Share</span>

        </div>

    </div>

</div>

@endsection