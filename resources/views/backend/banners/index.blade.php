@extends('backend.layouts.app')

@section('title', 'Banners')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Banners</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Banners</li>
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
                <form method="GET" action="{{ route('admin.banners') }}" class="d-flex gap-2">
                    <select name="position" class="form-control" style="width: 220px;">
                        <option value="">All positions</option>
                        @foreach(['home_hero','home_offer','category_top'] as $pos)
                            <option value="{{ $pos }}" @selected(request('position')===$pos)>{{ $pos }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                    <a href="{{ route('admin.banners') }}" class="btn btn-light">Reset</a>
                </form>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-success">Add Banner</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Position</th>
                                <th>Sort</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $b)
                                <tr>
                                    <td>{{ $b->id }}</td>
                                    <td class="font-weight-bold">{{ $b->title }}</td>
                                    <td>{{ $b->position }}</td>
                                    <td>{{ $b->sort_order }}</td>
                                    <td>
                                        <span class="badge {{ $b->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $b->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($b->image_path)
                                            <img src="{{ asset('storage/'.$b->image_path) }}" style="height:40px;">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $b->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">No banners found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">{{ $banners->links() }}</div>
        </div>
    </section>
@endsection

