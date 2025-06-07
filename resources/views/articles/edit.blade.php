@extends('layout')

@section('title', 'Редактировать статью')

@section('content')
    <h1>Редактировать статью</h1>

    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Содержимое</label>
            <textarea name="content" id="content" class="form-control" rows="6" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="categories" class="form-label">Категории</label>
            <select name="categories[]" id="categories" class="form-control" multiple>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @if ($article->categories->contains($category->id)) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Обновить</button>
    </form>
@endsection
