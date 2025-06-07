@extends('layout')

@section('title', 'Статьи')

@section('content')
    <h1>Список статей</h1>

    <form method="GET" class="mb-3">
        <input type="text" name="search" placeholder="Поиск..." class="form-control" value="{{ request('search') }}">
    </form>

    @foreach ($articles as $article)
        <div class="card mb-2">
            <div class="card-body">
                <h5>{{ $article->title }}</h5>
                <p>{{ \Illuminate\Support\Str::limit($article->content, 100) }}</p>
                <p><small>Категории: {{ $article->categories->pluck('name')->join(', ') }}</small></p>
                <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-primary">Редактировать</a>

                <form method="POST" action="{{ route('articles.destroy', $article) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить статью?')">Удалить</button>
                </form>
            </div>
        </div>
    @endforeach

    {{ $articles->links() }}
@endsection
