<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blog Posts') }}
            </h2>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Create New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Posts List Container -->
            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                        <div class="flex justify-between items-start">
                            <div>
                                @if($post->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mb-2">
                                        {{ $post->category }}
                                    </span>
                                @endif
                                <h3 class="text-lg font-bold text-gray-900 mb-1">
                                    <a href="{{ route('posts.show', $post->id) }}" class="hover:text-indigo-600">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <!-- Meta Info: Author & Date -->
                                <p class="text-xs text-gray-500 mb-3">
                                    @if($post->author)
                                        By <span class="font-medium text-gray-700">{{ $post->author }}</span> &bull;
                                    @endif
                                    @if($post->published_at)
                                        Published on {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}
                                    @else
                                        Created {{ $post->created_at->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->body }}</p>

                        <div class="flex items-center space-x-4 text-sm">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View</a>
                            <a href="{{ route('posts.edit', $post->id) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">Edit</a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                        No posts found. Create your first post!
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
