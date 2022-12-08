@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-end">
            <a href="{{ route('article') }}" title="Add new data">Back</a>
        </div>

        <div class="d-flex">
            <img src="{{ asset('storage/'.$article->article_image) }}" alt="{{ $article->title }}" width="150px" class="me-4" />
            <div class="p-2">
                <h2>{{ $article->title }}</h2>
                <p>publish at {{ date("d/m/Y", strtotime($article->created_at)) }}</p>
                {{ $article->content}}
                <small>created by {{ $article->article_creator }}</small>
            </div>
        </div>
    </div>
@endsection