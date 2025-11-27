@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    <div class="bg-white rounded-lg shadow-md w-full py-8 px-10 mx-auto max-w-2xl">
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
