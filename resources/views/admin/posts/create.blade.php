@extends('admin.layout.app')

@section('title','Create Post')
@section('page-title','Create Post')

@section('content')

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold">Create Post</h2>
        <p class="text-gray-400 mt-1">
            Share updates, match news and announcements
        </p>
    </div>

    <a href="{{ route('posts.index') }}"
       class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-xl transition">
        Back
    </a>
</div>

<form action="{{ route('posts.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- LEFT SIDE -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Main Composer -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-6 border border-gray-700">

                <div class="flex items-center gap-4 mb-6">

                    <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-xl font-bold">
                        A
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg">
                            Admin Post Composer
                        </h3>
                        <p class="text-sm text-gray-400">
                            What's happening today?
                        </p>
                    </div>

                </div>

                <!-- Title -->
                <div class="mb-5">

                    <input type="text"
                           name="title"
                           placeholder="Write an attention grabbing title..."
                           class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-4 text-lg focus:border-blue-500 focus:outline-none">

                </div>

                <!-- Content -->
                <div>

                    <textarea
                        rows="10"
                        name="content"
                        placeholder="Write your news, announcement or update..."
                        class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-4 resize-none focus:border-blue-500 focus:outline-none"></textarea>

                </div>

            </div>

            <!-- Image Upload -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-6 border border-gray-700">

                <h3 class="font-semibold text-lg mb-4">
                    Featured Image
                </h3>

                <label
                    class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-600 rounded-2xl cursor-pointer hover:border-blue-500 transition">

                    <svg class="w-12 h-12 text-gray-400 mb-3"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.9A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>

                    <p class="text-gray-300">
                        Click to upload image
                    </p>

                    <span class="text-xs text-gray-500 mt-2">
                        PNG, JPG, WEBP
                    </span>

                    <input type="file"
                           name="image"
                           class="hidden">
                </label>

            </div>

        </div>

        <!-- RIGHT SIDEBAR -->
        <div class="space-y-6">

            <!-- Post Settings -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-6 border border-gray-700">

                <h3 class="font-semibold text-lg mb-5">
                    Post Settings
                </h3>

                <div class="space-y-4">

                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            Category
                        </label>

                        <select name="category"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">

                            <option>News</option>
                            <option>Match Update</option>
                            <option>Announcement</option>
                            <option>Fantasy Tips</option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            Status
                        </label>

                        <select name="status"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">

                            <option value="draft">
                                Draft
                            </option>

                            <option value="published">
                                Publish
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            Tags
                        </label>

                        <input type="text"
                               name="tags"
                               placeholder="cricket,ipl,news"
                               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                    </div>

                </div>

            </div>

            <!-- Preview Card -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-6 border border-gray-700">

                <h3 class="font-semibold mb-4">
                    Preview
                </h3>

                <div class="bg-gray-800 rounded-2xl overflow-hidden">

                    <div class="h-40 bg-gradient-to-r from-blue-600 to-purple-600"></div>

                    <div class="p-4">

                        <div class="flex items-center gap-3 mb-3">

                            <div class="w-10 h-10 rounded-full bg-blue-600"></div>

                            <div>
                                <p class="font-semibold">
                                    Top11 Admin
                                </p>

                                <p class="text-xs text-gray-400">
                                    Just now
                                </p>
                            </div>

                        </div>

                        <h4 class="font-semibold text-lg mb-2">
                            Your title appears here
                        </h4>

                        <p class="text-sm text-gray-400">
                            Content preview will appear here...
                        </p>

                    </div>

                </div>

            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-3">

                <button type="submit"
                    name="status"
                    value="draft"
                    class="w-full py-3 rounded-2xl bg-gray-700 hover:bg-gray-600 font-medium">

                    Save Draft

                </button>

                <button type="submit"
                    name="status"
                    value="published"
                    class="w-full py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 font-semibold">

                    Publish Post

                </button>

            </div>

        </div>

    </div>

</form>

@endsection