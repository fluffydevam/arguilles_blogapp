<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // READ ALL
    public function index(Request $request)
    {
        $query = Post::query();

        // Filter by date range if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('published_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $posts = $query->latest('published_at')->get();

        return view('posts.index', compact('posts'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('posts.create');
    }

    // STORE DATA
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'body' => 'required|string',
        ]);

        Post::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category' => $validated['category'],
            'author' => Auth::user()->name, // Automatically fetch the logged-in poster's name
            'published_at' => now(),        // Automatically capture current date and time
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    // SHOW SINGLE POST
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // SHOW EDIT FORM
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // UPDATE DATA
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'body' => 'required|string',
        ]);

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category' => $validated['category'],
            // Author remains unchanged on edit, or you can update it if needed
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    // DELETE DATA
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Post deleted successfully.');
    }
}
