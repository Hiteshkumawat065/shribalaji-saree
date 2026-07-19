@extends('backend.layouts.app')

@section('title', 'Returns')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Requests</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Returns</li>
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
                    <form method="GET" action="{{ route('admin.returns') }}" class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Search</label>
                            <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Order #, user, reason...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                @foreach(['requested','approved','rejected','refunded','closed'] as $st)
                                    <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            <a href="{{ route('admin.returns') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order</th>
                                <th>User</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Refund</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returns as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td class="font-weight-bold">
                                        {{ $r->order?->order_number ?? ('#'.$r->order_id) }}
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $r->user?->name }}</div>
                                        <div class="text-muted small">{{ $r->user?->email }}</div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $r->reason }}</div>
                                        <div class="text-muted small">{{ $r->details }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ ucfirst($r->status) }}</span>
                                    </td>
                                    <td>
                                        @if($r->refund_amount !== null)
                                            ₹{{ number_format((float)$r->refund_amount, 2) }} ({{ $r->refund_method ?? '—' }})
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ optional($r->created_at)->format('d M, Y') }}</td>
                                    <td style="min-width: 340px;">
                                        <form method="POST" action="{{ route('admin.returns.status', $r->id) }}" class="d-flex gap-2 align-items-end">
                                            @csrf
                                            <div>
                                                <label class="form-label small mb-1">Status</label>
                                                <select name="status" class="form-control form-control-sm">
                                                    @foreach(['requested','approved','rejected','refunded','closed'] as $st)
                                                        <option value="{{ $st }}" @selected($r->status===$st)>{{ ucfirst($st) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="form-label small mb-1">Refund ₹</label>
                                                <input name="refund_amount" class="form-control form-control-sm" value="{{ $r->refund_amount }}">
                                            </div>
                                            <div>
                                                <label class="form-label small mb-1">Method</label>
                                                <input name="refund_method" class="form-control form-control-sm" value="{{ $r->refund_method }}" placeholder="original/bank/wallet">
                                            </div>
                                            <div>
                                                <label class="form-label small mb-1">Note</label>
                                                <input name="admin_note" class="form-control form-control-sm" value="{{ $r->admin_note }}" placeholder="Admin note">
                                            </div>
                                            <button class="btn btn-sm btn-outline-success" type="submit">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No return requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $returns->links() }}
            </div>
        </div>
    </section>
@endsection

