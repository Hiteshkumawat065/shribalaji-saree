@extends('backend.layouts.app')

@section('title', 'Homepage Sections')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Homepage Sections</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Homepage Sections</li>
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

            <div class="card mb-3">
                <div class="card-header font-weight-bold">Add Section</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.homepage.sections.store') }}" class="row g-2 align-items-end">
                        @csrf
                        <div class="col-md-3">
                            <label class="form-label">Key</label>
                            <input name="key" class="form-control" placeholder="hero/new_arrivals/..." required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Title</label>
                            <input name="title" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subtitle</label>
                            <input name="subtitle" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sort</label>
                            <input type="number" min="0" name="sort_order" class="form-control" value="0">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">On</label>
                            <div>
                                <input type="checkbox" name="is_active" value="1" checked>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success" type="submit">Add</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Status</th>
                                <th>Sort</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $s)
                                <tr>
                                    <td class="font-weight-bold">{{ $s->key }}</td>
                                    <td>{{ $s->title }}</td>
                                    <td>{{ $s->subtitle }}</td>
                                    <td>
                                        <span class="badge {{ $s->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $s->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $s->sort_order }}</td>
                                    <td style="min-width: 380px;">
                                        <form method="POST" action="{{ route('admin.homepage.sections.update', $s->id) }}" class="row g-2 align-items-end">
                                            @csrf
                                            <div class="col-md-3">
                                                <input name="title" class="form-control form-control-sm" value="{{ $s->title }}" placeholder="Title">
                                            </div>
                                            <div class="col-md-4">
                                                <input name="subtitle" class="form-control form-control-sm" value="{{ $s->subtitle }}" placeholder="Subtitle">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" min="0" name="sort_order" class="form-control form-control-sm" value="{{ $s->sort_order }}">
                                            </div>
                                            <div class="col-md-1">
                                                <input type="checkbox" name="is_active" value="1" {{ $s->is_active ? 'checked' : '' }}>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-sm btn-outline-success" type="submit">Save</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No sections found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

