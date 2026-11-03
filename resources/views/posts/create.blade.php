<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf

                        <!-- Title Field -->
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @error('title')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Dropdown Menu -->
                        <div class="mb-4">
                            <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
                            <select name="category" id="category" required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Select Category --</option>
                                <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Lifestyle" {{ old('category') == 'Lifestyle' ? 'selected' : '' }}>Lifestyle</option>
                                <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business</option>
                                <option value="Tutorials" {{ old('category') == 'Tutorials' ? 'selected' : '' }}>Tutorials</option>
                            </select>
                            @error('category')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Body Field -->
                        <div class="mb-4">
                            <label for="body" class="block font-medium text-sm text-gray-700">Body</label>
                            <textarea name="body" id="body" rows="6" required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons / Actions -->
                        <div class="flex items-center justify-end mt-4 space-x-3">
                            <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Post
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
