@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    <div class="bg-white rounded-lg shadow-md w-full py-8 px-10 mx-auto max-w-2xl">
        {{-- <h2 class="mb-4 text-xl font-bold text-gray-900">{{ $post ? 'Edit Post' : 'Create New Post' }}</h2> --}}
        <form action="{{ $post ? route('update', $post->id) : route('store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Post Title</label>
                    <input type="text" name="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                        placeholder="Type your post title" value="{{ old('title', $post->title ?? '') }}" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                    <select id="category-select" name="category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5">
                        <option value="" disabled {{ $post ? '' : 'selected' }}>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        <option value="other">+ Create new category</option>
                    </select>
                    <div id="new-category-wrapper" class="hidden mt-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900">New Category</label>
                        <input type="text" name="new_category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                            placeholder="Enter new category name">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Content</label>
                    <div class="bg-gray-50 w-full border border-gray-300 rounded-lg shadow-xs">
                        <div class="flex items-center justify-between px-3 py-2 border-b border-gray-300">
                            <div class="flex flex-wrap items-center divide-md sm:divide-x sm:rtl:divide-x-reverse">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                    <button type="button"
                                        class="p-2 text-body rounded-sm cursor-pointer hover:text-heading hover:bg-gray-200">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8" />
                                        </svg>
                                        <span class="sr-only">Attach file</span>
                                    </button>
                                    <button type="button"
                                        class="p-2 text-body rounded-sm cursor-pointer hover:text-heading hover:bg-gray-200">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M16 18H8l2.5-6 2 4 1.5-2 2 4Zm-1-8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" />
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 18h8l-2-4-1.5 2-2-4L8 18Zm7-8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" />
                                        </svg>
                                        <span class="sr-only">Upload image</span>
                                    </button>
                                    <button type="button"
                                        class="p-2 text-body rounded-sm cursor-pointer hover:text-heading hover:bg-gray-200">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 9h.01M8.99 9H9m12 3a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM6.6 13a5.5 5.5 0 0 0 10.81 0H6.6Z" />
                                        </svg>
                                        <span class="sr-only">Add emoji</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 rounded-lg">
                            <textarea id="content" name="content" rows="8"
                                class="block bg-gray-50 w-full px-0 text-sm text-heading border-0 focus:ring-0 placeholder:text-body"
                                placeholder="Write an article..." required>{{ old('content', $post->content ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-[#FFAB2F] rounded-lg hover:bg-[#FF9D0A] transition">
                        {{ $post ? 'Update Post' : 'Create Post' }}
                    </button>

                    <a href="{{ route('posts') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                </div>
        </form>
    </div>
    <script>
        document.getElementById('category-select').addEventListener('change', function() {
            const wrapper = document.getElementById('new-category-wrapper');

            if (this.value === 'other') {
                wrapper.classList.remove('hidden');
                wrapper.querySelector('input').required = true;
            } else {
                wrapper.classList.add('hidden');
                wrapper.querySelector('input').required = false;
            }
        });
    </script>
@endsection
