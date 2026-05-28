<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount('threads')
            ->with(['threads' => fn($q) => $q->latest()->limit(1)->with('user')])->get();
        return Inertia::render('Forum/Categories/Index', [
            'categories' => $categories,
            'isAdmin' => auth()->check() && auth()->user()->isAdmin(),
        ]);
    }

    public function adminIndex() {
        $categories = Category::withCount('threads')->get();
        return Inertia::render('Admin/Categories/Index', ['categories' => $categories]);
    }
    
    public function create() {
        return Inertia::render('Admin/Categories/Create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $slug = Str::slug($validated['name']) . '-' . time();

        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => $slug
        ]);

        return redirect('/admin/categories')
            ->with('toast', ['type' => 'success', 'message' => 'Раздел создан!']);
    }

    public function edit(Category $category) {
        return Inertia::render('Admin/Categories/Edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $category->update($validated);

        return redirect('/admin/categories')
            ->with('toast', ['type' => 'success', 'message' => 'Раздел обновлен!']);
    }

    public function destroy(Category $category) {
        $category->delete();

        return redirect('/forum')
            ->with('toast', ['type' => 'success', 'message' => 'Раздел удален!']);
    }
    
}
