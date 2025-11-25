@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    <div class="mt-8 pb-16 lg:pt-16 lg:pb-24 lg:mx-30 rounded-lg bg-white shadow-md antialiased">
        <div class="flex justify-between px-4 mx-auto max-w-7xl ">
            <article class="mx-auto w-full max-w-4xl format format-sm sm:format-base lg:format-lg format-blue">
                <header class="mb-4 lg:mb-6 not-format">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('posts') }}" class="font-medium mt-4 text-sm text-[#FFAB2F] hover:underline">
                            &laquo; Back to blog
                        </a>
                        @auth
                            @if (auth()->id() === $post->author_id || auth()->user()->role === 'admin')
                                <div class="flex items-center gap-3 mt-4">
                                    <a href="{{ route('edit', $post->slug) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#FFAB2F] rounded-lg hover:bg-[#FF9D0A] transition">
                                        Edit Post
                                    </a>
                                    <button type="button"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition"
                                        data-modal-target="deleteModal" data-modal-toggle="deleteModal"
                                        data-post-id="{{ $post->id }}"" id="deletePostBtn">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <address class="flex items-center my-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                            <img class="mr-4 w-16 h-16 rounded-full" src="{{ $post->author->photo }}"
                                alt="{{ $post->author->name }}">
                            <div>
                                <a href="{{ route('posts', ['author' => $post->author->username]) }}" rel="author"
                                    class="text-xl font-bold text-gray-900">
                                    {{ $post->author->name }}
                                </a><br>
                                <a href="{{ route('posts', ['category' => $post->category->slug]) }}">
                                    <span
                                        class="bg-{{ $post->category->color }}-100 text-rose-800 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                        {{ $post->category->name }}
                                    </span>
                                </a>
                                <p class="text-sm text-gray-500 mb-1">{{ $post->created_at->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </address>
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl">
                        {{ $post->title }}</h1>
                </header>
                <p class="text-gray-500">{{ $post->content }}</p>
            </article>
        </div>
    </div>
    {{-- COMMENTS --}}
    <section class="pt-8 pb-6 antialiased">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900">
                    Discussion ({{ $post->allComments->count() }})
                </h2>
            </div>
            @auth
                <form action="{{ route('comment.store', $post->slug) }}" method="POST" class="mb-6 rounded-lg shadow-lg">
                    @csrf
                    <div class="py-2 px-4 bg-white rounded-t-lg border border-gray-200">
                        <textarea name="content" rows="5" class="w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"
                            placeholder="Write a comment..." required></textarea>
                    </div>
                    <div class="bg-[#FFAB2F] rounded-b-lg">
                        <button type="submit"
                            class="inline-flex items-center ml-2 my-2 py-2.5 px-4 text-xs font-medium text-white bg-rose-700 rounded-lg hover:bg-rose-800">
                            Post comment
                        </button>
                    </div>
                </form>
            @else
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
                    <p class="text-sm text-gray-700">
                        You must <a href="{{ route('login-register') }}"
                            class="text-[#FFAB2F] font-semibold hover:underline">login</a>
                        or register to post a comment.
                    </p>
                </div>
            @endauth
            @if ($post->comments->isEmpty())
                <p class="text-gray-500 text-md">No comments yet. Be the first to comment!</p>
            @else
                @foreach ($post->comments as $comment)
                    <x-comment :comment="$comment" />
                @endforeach
            @endif
        </div>
    </section>
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
            const deleteBtn = document.getElementById('deletePostBtn');
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deletePostForm');
            const closeButtons = document.querySelectorAll('[data-modal-toggle="deleteModal"]');

            if (deleteBtn) {
                // Open modal
                deleteBtn.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');

                    // Set form action
                    deleteForm.action = `/blog/${postId}`;

                    // Show modal
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });

                // Close modal
                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        deleteModal.classList.add('hidden');
                        deleteModal.classList.remove('flex');
                    });
                });

                // Close on backdrop click
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === deleteModal) {
                        deleteModal.classList.add('hidden');
                        deleteModal.classList.remove('flex');
                    }
                });

                // Close on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                        deleteModal.classList.add('hidden');
                        deleteModal.classList.remove('flex');
                    }
                });
            }
        });
    </script>
@endsection
