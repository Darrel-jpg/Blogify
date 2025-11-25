@props(['comment'])

<article class="p-6 mb-4 text-base bg-white rounded-lg shadow-md">
    <footer class="flex justify-between items-center mb-2">
        <div class="flex items-center">
            <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold">
                <img class="mr-2 w-6 h-6 rounded-full" src="{{ $comment->user->photo }}"
                    alt="{{ $comment->user->name }}">
                {{ $comment->user->name }}
            </p>
            <p class="text-sm text-gray-600">
                <time datetime="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</time>
            </p>
        </div>
    </footer>
    <p class="text-gray-500 break-all whitespace-pre-line">{{ $comment->content }}</p>
    @auth
        <button onclick="document.getElementById('reply-{{ $comment->id }}').classList.toggle('hidden')"
            class="flex items-center mt-3 text-sm text-gray-500 hover:underline font-medium">
            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
            </svg>
            Reply
        </button>
        <form id="reply-{{ $comment->id }}" action="{{ route('comment.store', $comment->post->slug) }}" method="POST"
            class="mt-3 hidden">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="content" rows="3" class="w-full p-2 text-sm border rounded-lg focus:ring focus:ring-[#FFAB2F]"
                placeholder="Write a reply..." required></textarea>
            <button type="submit"
                class="mt-2 inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-rose-700 rounded-lg hover:bg-rose-800">
                Reply
            </button>
        </form>
    @endauth
</article>

@if ($comment->replies->count())
    <div class="ml-6 lg:ml-12">
        @foreach ($comment->replies as $reply)
            <x-comment :comment="$reply" />
        @endforeach
    </div>
@endif
