<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function index(Category $category) {
        $threads = $category->threads()->with('user')->withCount('replies')->latest()->paginate(15);
        return Inertia::render('Forum/Threads/Index', ['threads' => $threads, 'category' => $category]);
    }
    
    public function show(Category $category, Thread $thread) {
        $thread->load(['replies.user', 'user', 'category']);
        return Inertia::render('Forum/Threads/Show', ['thread' => $thread]);
    }

    public function create(Category $category) {
        return Inertia::render('Forum/Threads/Create', ['category' => $category]);
    }

    public function store(Request $request, Category $category) {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:10',
        ]);

        $slug = Str::slug($validated['title']) . '-' . time();

        $thread = $category->threads()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'slug' => $slug,
            'user_id' => auth()->id(),
        ]);

        return redirect('/forum/' . $category->slug . '/' . $thread->slug)
            ->with('toast', ['type' => 'success', 'message' => 'Тема создана!']);
    }
}
