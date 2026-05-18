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
}
