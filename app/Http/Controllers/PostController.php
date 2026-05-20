<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');
        $posts = Post::query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'search' => $search,
        ]);
    }

    public function create() {
        return Inertia::render('Posts/Create');
    }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:10',
        ]);

        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index')
            ->with('toast', ['type' => 'success', 'message' => 'Пост создан!']);
    }

    public function show(Post $post) {
        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    public function edit(Post $post) {
        return Inertia::render('Posts/Edit', ['post' => $post]);
    }
    
    public function update(Request $request, Post $post) {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:10',
        ]);

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('toast', ['type' => 'success', 'message' => 'Пост обновлен!']);
    }

    public function destroy(Post $post) {
        $post->delete();

        return redirect()->route('posts.index');
    }

}
