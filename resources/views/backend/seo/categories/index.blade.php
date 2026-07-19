@extends('backend.layouts.app')

@section('title', 'SEO - Categories')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SEO - Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">SEO Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('admin.seo.categories') }}" class="d-flex gap-2">
                        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name / slug">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{ route('admin.seo.categories') }}" class="btn btn-light">Reset</a>
                    </form>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Meta title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td class="font-weight-bold">{{ $c->name }}</td>
                                    <td class="text-muted small">{{ $c->slug }}</td>
                                    <td>{{ $c->meta_title }}</td>
                                    <td>
                                        <a href="{{ route('admin.seo.categories.edit', $c->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </section>
@endsection

