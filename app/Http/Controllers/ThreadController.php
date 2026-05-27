<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function index(Category $category, Request $request) {
        $search = $request->input('search');
        $sort = $request->input('sort', 'latest');

        $threads = $category->threads()
            ->with('user')
            ->withCount('replies')
            ->when($search, fn($q) => $q->where('title', 'like', '%' . $search . '%'))
            ->when($sort === 'popular', 
                fn($q) => $q->orderByDesc('replies_count'),
                fn($q) => $q->latest()
            )
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Forum/Threads/Index', [
            'threads' => $threads, 
            'category' => $category,
            'search' => $search,
            'sort' => $sort,
        ]);
    }
    
    public function show(Category $category, Thread $thread) {
        $thread->load(['replies.user', 'user', 'category']);

        return Inertia::render('Forum/Threads/Show', [
            'thread' => $thread,
            'canEdit' => auth()->check() && (auth()->id() === $thread->user_id || auth()->user()->isModerator()),
            'authUserId' => auth()->id(),
        ]);
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

    public function edit(Category $category, Thread $thread) {
        return Inertia::render('Forum/Threads/Edit', ['thread' => $thread, 'category' => $category]);
    }

    public function update(Request $request, Category $category, Thread $thread) {
        $this->authorize('update', $thread);
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:10',
            ]);
            
        $thread->update($validated);

        return redirect('/forum/' . $category->slug . '/' . $thread->slug)
            ->with('toast', ['type' => 'success', 'message' => 'Тема обновлена!']);
    }

    public function destroy(Category $category, Thread $thread) {
        $this->authorize('delete', $thread);
        $thread->delete();
        
        return redirect('/forum/' . $category->slug)
            ->with('toast', ['type' => 'success', 'message' => 'Тема удалена!']);
    }
}
