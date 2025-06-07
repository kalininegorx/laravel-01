@extends('layouts.app')

@section('content')
    <h1>Категории</h1>
    <a href="{{ route('categories.create') }}">Создать категорию</a>

    @foreach ($categories as $category)
        <div>
            <h2>{{ $category->name }}</h2>
            <p>{{ $category->description }}</p>
        </div>
    @endforeach
@endsection
