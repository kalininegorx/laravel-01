<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Только администратор может создавать категории');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Category::create($validated);
    return redirect()->route('categories.index')->with('success', 'Категория создана');
}

public function edit(Category $category)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Только администратор может редактировать категории');
    }

    return view('categories.edit', compact('category'));
}

public function update(Request $request, Category $category)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Только администратор может обновлять категории');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $category->update($validated);
    return redirect()->route('categories.index')->with('success', 'Категория обновлена');
}

public function destroy(Category $category)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Только администратор может удалять категории');
    }

    $category->delete();
    return redirect()->route('categories.index')->with('success', 'Категория удалена');
    }
}
