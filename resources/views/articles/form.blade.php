@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>{{ $title }}</h2>
            <a href="{{ $previous }}" title="Add new data">Back</a>
        </div>

        <form action="{{ $update ? route('article.edit', $id) : route('article.new') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            <div class="form-group mb-4">
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ? old('title') : $post['title']; }}">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @error('slug')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mb-4">
                <label for="title">Upload Image</label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                @error('file')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="content">Content</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="3">{{ old('content') ? old('content') : $post['content']; }}</textarea>
                @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('article') }}" class="btn btn-link" title="Back to Article Page">Cancel</a>
            </div>
        </form>
    </div>
@endsection