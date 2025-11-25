@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    <div class="py-4 px-4 max-w-7xl mx-auto flex flex-col w-full items-end sm:justify-between sm:items-center gap-4 sm:flex-row lg:px-0">
        <form class="w-full sm:w-lg">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('author'))
                <input type="hidden" name="author" value="{{ request('author') }}">
            @endif
            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="search" name="search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#FFAB2F] focus:border-[#FFAB2F]"
                    placeholder="Search for article" autocomplete="off" />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-[#FFAB2F] hover:bg-[#FF9D0A] focus:ring-4 focus:outline-none focus:ring-[#F59300] font-medium rounded-lg text-sm px-4 py-2">Search</button>
            </div>
        </form>
        <div>
            <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button"
                class="flex w-25 items-center justify-center rounded-lg border border-gray-200 bg-[#FFAB2F] px-2 py-2 text-sm font-medium text-white hover:bg-[#FF9D0A] hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-[#FF9D0A] sm:w-auto">
                <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
                </svg>
                Sort
                <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 9-7 7-7-7" />
                </svg>
            </button>
            <div id="dropdownSort1" class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-[#FFAB2F] shadow"
                data-popper-placement="bottom">
                <ul class="py-2 text-left text-sm font-medium text-white" aria-labelledby="sortDropdownButton">
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}" class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-[#FFBE5C]">
                            Oldest </a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-[#FFBE5C]">
                            Newest </a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'most-commented']) }}" class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-[#FFBE5C]">
                            Most commented </a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'a-to-z']) }}" class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-[#FFBE5C]">
                            A → Z </a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'z-to-a']) }}" class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-[#FFBE5C]">
                            Z → A </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="my-4 px-4 mx-auto max-w-7xl lg:px-0">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md flex flex-col min-h-80 h-full">
                    <div class="flex justify-between items-center mb-5 text-gray-500">
                        <a href="{{ route('posts', ['category' => $post->category->slug]) }}">
                            <span
                                class="bg-{{ $post->category->color }}-100 text-rose-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                {{ $post->category->name }}
                            </span>
                        </a>
                        <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('post', $post->slug) }}">
                        <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 hover:underline">
                            {{ $post->title }}</h2>
                    </a>
                    <p class="mb-5 font-light text-gray-500">{{ Str::limit($post->content, 150) }}
                    </p>
                    <div class="flex justify-between items-center mt-auto">
                        <a href="{{ route('posts', ['author' => $post->author->username]) }}">
                            <div class="flex items-center space-x-3">
                                <img class="w-7 h-7 rounded-full" src="{{ $post->author->photo }}"
                                    alt="{{ $post->author->name }}" />
                                <span class="font-medium text-sm">
                                    {{ $post->author->name }}
                                </span>
                            </div>
                        </a>
                        <a href="{{ route('post', $post->slug) }}"
                            class="inline-flex items-center font-medium text-[#FF9D0A] text-sm hover:underline">
                            Read more &raquo;
                        </a>
                    </div>
                </article>
            @empty
                <div>
                    <p class="font-sm  text-xl my-4">Article not found!</p>
                    <a href="/blog" class="block text-[#FF9D0A] hover:underline">&laquo; Back to blog</a>
                </div>
            @endforelse
        </div>
        {{ $posts->links() }}
    </div>
@endsection
