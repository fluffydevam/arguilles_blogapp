<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Post') }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('posts.edit', $post->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit
                </a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Category Badge -->
                    @if($post->category)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mb-3">
                            {{ $post->category }}
                        </span>
                    @endif

                    <!-- Post Title -->
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $post->title }}</h1>

                    <!-- Author & Date Metadata -->
                    <p class="text-sm text-gray-500 mb-6">
                        @if($post->author)
                            By <span class="font-medium text-gray-700">{{ $post->author }}</span> &bull;
                        @endif
                        @if($post->published_at)
                            Published on {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y, g:i a') }}
                        @else
                            Created {{ $post->created_at->format('M d, Y, g:i a') }}
                        @endif
                    </p>

                    <!-- Post Body / Content -->
                    <div class="prose max-w-none text-gray-700 leading-relaxed mb-8 whitespace-pre-line">
                        {{ $post->body }}
                    </div>

                    <!-- Back Button -->
                    <div class="flex items-center border-t border-gray-200 pt-6">
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            &larr; Back to Posts
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
