<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('categories')->paginate(10);
        return view('articles.index', compact('articles'));
    }


    public function create()
    {
    $categories = Category::all();
    return view('articles.create', compact('categories'));
    }


    public function store(Request $request)
{
    if (auth()->guest()) {
        abort(403, 'Вы должны быть авторизованы');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'categories' => 'nullable|array',
    ]);

    $article = auth()->user()->articles()->create($validated);
    if ($request->has('categories')) {
        $article->categories()->attach($request->categories);
    }

    return redirect()->route('articles.index')->with('success', 'Статья создана');
}

public function edit(Article $article)
{
    if (auth()->user()->role !== 'admin' && auth()->id() !== $article->user_id) {
        abort(403, 'Недостаточно прав');
    }

    $categories = Category::all();
    return view('articles.edit', compact('article', 'categories'));
}

public function update(Request $request, Article $article)
{
    if (auth()->user()->role !== 'admin' && auth()->id() !== $article->user_id) {
        abort(403, 'Недостаточно прав');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'categories' => 'nullable|array',
    ]);

    $article->update($validated);
    $article->categories()->sync($request->categories);

    return redirect()->route('articles.index')->with('success', 'Статья обновлена');
}

public function destroy(Article $article)
{
    if (auth()->user()->role !== 'admin' && auth()->id() !== $article->user_id) {
        abort(403, 'Недостаточно прав');
    }

    $article->delete();
    return redirect()->route('articles.index')->with('success', 'Статья удалена');
    }
}
