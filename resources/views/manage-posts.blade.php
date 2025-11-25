@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    <div class="container mx-auto px-4 py-4">
        <!-- Stats Card (Optional) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="shrink-0 bg-amber-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-[#FF9D0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Posts</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $posts->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Categories</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="shrink-0 bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Authors</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalAuthors }}</p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <form method="GET" action="{{ route('admin.posts') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title post..."
                        class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFAB2F] focus:border-transparent">
                </div>

                <div>
                    <select name="category" onchange="this.form.submit()"
                        class="w-53 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFAB2F]">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}"
                                {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <a href="{{ route('create') }}"
                    class="bg-[#FFAB2F] hover:bg-[#FF9D0A] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add new post
                </a>
                @if (request('search') || request('category'))
                    <a href="{{ route('admin.posts') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>
        <!-- Posts Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Title</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Author</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Create at</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($posts as $post)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-amber-100 rounded-lg mr-3 flex items-center justify-center shrink-0">
                                            <svg class="w-6 h-6 text-[#FF9D0A]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($post->title, 50) }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($post->content, 60) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $post->author->photo }}" alt="{{ $post->author->name }}"
                                            class="w-8 h-8 rounded-full object-cover mr-2">
                                        <div class="text-sm text-gray-900">{{ $post->author->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-lg bg-{{ $post->category->color }}-100 text-rose-800">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $post->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $post->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('post', $post->slug) }}" target="_blank"
                                            class="text-green-600 hover:text-green-800" title="Look at the Frontend">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('edit', $post->slug) }}"
                                            class="text-amber-600 hover:text-amber-800" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button"
                                            class="text-red-600 hover:text-red-800 cursor-pointer delete-post-btn"
                                            title="Delete" data-post-id="{{ $post->id }}"
                                            data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
    <!-- Delete modal -->
    <div id="deleteModal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        data-backdrop-classes="bg-gray-900 bg-opacity-90 fixed inset-0 z-40"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
                <button type="button"
                    class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="deleteModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <svg class="text-gray-400 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor"
                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <p class="mb-4 text-gray-500">Are you sure you want to delete this post?</p>
                <p class="mb-4 text-sm text-gray-400">This action cannot be undone.</p>
                <form action="" method="POST" id="deletePostForm">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal" type="button"
                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 hover:text-gray-900 focus:z-10">
                            No, cancel
                        </button>
                        <button type="submit"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                            Yes, I'm sure
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-post-btn');
            const deleteForm = document.getElementById('deletePostForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    deleteForm.action = `/blog/${postId}`;
                });
            });
        });
    </script>
@endsection
