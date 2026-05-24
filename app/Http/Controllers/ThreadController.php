<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

}
