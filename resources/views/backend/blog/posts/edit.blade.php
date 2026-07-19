@extends('backend.layouts.app')

@section('title', 'Edit Blog Post')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Blog Post</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blog.posts') }}">Blog Posts</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="POST" action="{{ route('admin.blog.posts.update', $post->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="blog_category_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('blog_category_id', $post->blog_category_id) == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input name="slug" class="form-control" value="{{ old('slug', $post->slug) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Excerpt</label>
                            <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" rows="8" class="form-control">{{ old('content', $post->content) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                                Published
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Published at</label>
                            <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\\TH:i')) }}">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.blog.posts') }}" class="btn btn-light">Back</a>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

