@extends('backend.layouts.app')

@section('title', 'Newsletter Subscribers')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Newsletter Subscribers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
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

            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('admin.newsletter') }}" class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Search</label>
                            <input name="q" value="{{ request('q') }}" class="form-control" placeholder="email...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-control">
                                <option value="">All</option>
                                <option value="1" @selected(request('is_active')==='1')>Active</option>
                                <option value="0" @selected(request('is_active')==='0')>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            <a href="{{ route('admin.newsletter') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Subscribed</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $s)
                                <tr>
                                    <td>{{ $s->id }}</td>
                                    <td class="font-weight-bold">{{ $s->email }}</td>
                                    <td>
                                        <span class="badge {{ $s->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $s->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ optional($s->subscribed_at)->format('d M, Y') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.newsletter.toggle', $s->id) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-primary" type="submit">
                                                {{ $s->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No subscribers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">{{ $subscribers->links() }}</div>
        </div>
    </section>
@endsection

