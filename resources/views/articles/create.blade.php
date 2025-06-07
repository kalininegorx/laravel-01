@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4">
    <h1 class="text-2xl font-bold mb-4">Создать статью </h1>

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Заголовок</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Содержимое</label>
            <textarea name="content" class="w-full border rounded px-3 py-2" rows="5" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Категории</label>
            @foreach ($categories as $category)
                <label class="inline-flex items-center mr-4">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="mr-2">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
</div>
@endsection
