@extends('backend.layouts.app')

@section('title', 'Shipping Methods')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Shipping Methods</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Shipping</li>
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
                <div class="card-header font-weight-bold">Add Shipping Method</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.shipping.store') }}" class="row g-2 align-items-end">
                        @csrf
                        <div class="col-md-3">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Cost</label>
                            <input name="cost" class="form-control" value="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Free shipping above (optional)</label>
                            <input name="min_order_amount" class="form-control" placeholder="e.g. 1999">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sort</label>
                            <input name="sort_order" type="number" min="0" class="form-control" value="0">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">On</label>
                            <div><input type="checkbox" name="is_active" value="1" checked></div>
                        </div>
                        <div class="col-md-1">
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
                                <th>Name</th>
                                <th>Cost</th>
                                <th>Free above</th>
                                <th>Status</th>
                                <th>Sort</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($methods as $m)
                                <tr>
                                    <td class="font-weight-bold">{{ $m->name }}</td>
                                    <td>₹{{ number_format((float)$m->cost, 2) }}</td>
                                    <td>{{ $m->min_order_amount !== null ? '₹'.number_format((float)$m->min_order_amount,2) : '—' }}</td>
                                    <td>
                                        <span class="badge {{ $m->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $m->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $m->sort_order }}</td>
                                    <td style="min-width: 420px;">
                                        <form method="POST" action="{{ route('admin.shipping.update', $m->id) }}" class="row g-2 align-items-end">
                                            @csrf
                                            <div class="col-md-3"><input name="name" class="form-control form-control-sm" value="{{ $m->name }}" required></div>
                                            <div class="col-md-2"><input name="cost" class="form-control form-control-sm" value="{{ $m->cost }}" required></div>
                                            <div class="col-md-3"><input name="min_order_amount" class="form-control form-control-sm" value="{{ $m->min_order_amount }}"></div>
                                            <div class="col-md-2"><input name="sort_order" type="number" min="0" class="form-control form-control-sm" value="{{ $m->sort_order }}"></div>
                                            <div class="col-md-1"><input type="checkbox" name="is_active" value="1" {{ $m->is_active ? 'checked' : '' }}></div>
                                            <div class="col-md-1"><button class="btn btn-sm btn-outline-success" type="submit">Save</button></div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No shipping methods found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">{{ $methods->links() }}</div>
        </div>
    </section>
@endsection

