@extends('backend.layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blog Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Blog Posts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" action="{{ route('admin.blog.posts') }}" class="d-flex gap-2">
                    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search title/slug">
                    <button class="btn btn-primary" type="submit">Search</button>
                    <a href="{{ route('admin.blog.posts') }}" class="btn btn-light">Reset</a>
                </form>
                <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-success">Add Post</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th>Views</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td class="font-weight-bold">{{ $p->title }}</td>
                                    <td>{{ $p->category?->name }}</td>
                                    <td>
                                        <span class="badge {{ $p->is_published ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $p->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ optional($p->published_at)->format('d M, Y') }}</td>
                                    <td>{{ $p->views }}</td>
                                    <td>
                                        <a href="{{ route('admin.blog.posts.edit', $p->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">{{ $posts->links() }}</div>
        </div>
    </section>
@endsection

