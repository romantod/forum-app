<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount('threads')
            ->with(['threads' => fn($q) => $q->latest()->limit(1)->with('user')])->get();

        return Inertia::render('Forum/Categories/Index', ['categories' => $categories]);
    }
    
}
