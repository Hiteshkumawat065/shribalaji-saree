@extends('backend.layouts.app')

@section('title', 'Contact Inquiries')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Contact Inquiries</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Inquiries</li>
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
                    <form method="GET" action="{{ route('admin.contact.inquiries') }}" class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Search</label>
                            <input name="q" value="{{ request('q') }}" class="form-control" placeholder="name, email, subject...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                @foreach(['new','in_progress','resolved','closed'] as $st)
                                    <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            <a href="{{ route('admin.contact.inquiries') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inquiries as $i)
                                <tr>
                                    <td>{{ $i->id }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $i->name }}</div>
                                        <div class="text-muted small">{{ $i->email }} {{ $i->phone ? '· '.$i->phone : '' }}</div>
                                    </td>
                                    <td>{{ $i->subject }}</td>
                                    <td style="max-width: 420px;">
                                        <div class="text-truncate" title="{{ $i->message }}">{{ $i->message }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ ucfirst(str_replace('_',' ',$i->status)) }}</span></td>
                                    <td class="text-muted small">{{ optional($i->created_at)->format('d M, Y') }}</td>
                                    <td style="min-width: 320px;">
                                        <form method="POST" action="{{ route('admin.contact.inquiries.status', $i->id) }}" class="d-flex gap-2 align-items-end">
                                            @csrf
                                            <div>
                                                <label class="form-label small mb-1">Status</label>
                                                <select name="status" class="form-control form-control-sm">
                                                    @foreach(['new','in_progress','resolved','closed'] as $st)
                                                        <option value="{{ $st }}" @selected($i->status===$st)>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label small mb-1">Admin note</label>
                                                <input name="admin_note" class="form-control form-control-sm" value="{{ $i->admin_note }}" placeholder="Note">
                                            </div>
                                            <button class="btn btn-sm btn-outline-success" type="submit">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No inquiries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">{{ $inquiries->links() }}</div>
        </div>
    </section>
@endsection

