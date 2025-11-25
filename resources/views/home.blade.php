@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    <div class="my-4 px-4 py-12 mx-auto max-w-7xl lg:px-0 bg-linear-to-r from-rose-100 to-orange-50 rounded-2xl">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                Welcome to <span class="text-[#FFAB2F]">Blogify</span>
            </h1>
            <p class="text-gray-600 text-lg">
                Find interesting articles about technology, design, and coding.
            </p>
            <a href="{{ route('posts') }}"
                class="mt-6 inline-block bg-[#FFAB2F] text-white font-semibold py-2 px-5 rounded-lg hover:bg-[#f99f1a] transition">
                Start Reading
            </a>
        </div>
    </div>
    <div class="my-4 px-4 mx-auto max-w-7xl lg:px-0">
        <h2 class="text-2xl font-bold mt-15 mb-6 text-gray-800">Artikel Terbaru</h2>
        @if ($posts->count())
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
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
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada postingan.</p>
        @endif
    </div>
@endsection
