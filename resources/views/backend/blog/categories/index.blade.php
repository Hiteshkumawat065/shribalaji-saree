@extends('backend.layouts.app')

@section('title', 'Blog Categories')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blog Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Blog Categories</li>
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
                <form method="GET" action="{{ route('admin.blog.categories') }}" class="d-flex gap-2">
                    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name/slug">
                    <button class="btn btn-primary" type="submit">Search</button>
                    <a href="{{ route('admin.blog.categories') }}" class="btn btn-light">Reset</a>
                </form>
                <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-success">Add Category</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Sort</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td class="font-weight-bold">{{ $c->name }}</td>
                                    <td class="text-muted small">{{ $c->slug }}</td>
                                    <td>
                                        <span class="badge {{ $c->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $c->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $c->sort_order }}</td>
                                    <td>
                                        <a href="{{ route('admin.blog.categories.edit', $c->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">{{ $categories->links() }}</div>
        </div>
    </section>
@endsection

