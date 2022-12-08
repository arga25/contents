@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>Articles</h2>
            <a href="{{ route('article.new') }}" title="Add new data">Add New</a>
        </div>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if($articles->count() > 0)
                    @foreach($articles as $article)
                        <tr>
                            <th scope="row">{{ ($first + $loop->index)}}</th>
                            <td>
                                <img src="{{ asset('storage/'.$article->article_image) }}" alt="{{ $article->title }}" width="50px" />
                            </td>
                            <td>{{ $article->title }}</td>
                            <td style="max-width:300px;">{{ $article->content }}</td>
                            <td class="text-center">
                                <a href="{{ route('article.show', $article->id) }}" class="btn btn-link me-2" title="Show {{ $article->title }}">show</a>
                                <a href="{{ route('article.edit', $article->id) }}" class="btn btn-link me-2" title="Edit {{ $article->title }}">edit</a>
                                <a href="{{ route('article.del', $article->id) }}" class="btn btn-link" title="Delete {{ $article->title }}">delete</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Belum ada data yang di input</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{ $articles->links() }}
    </div>
@endsection