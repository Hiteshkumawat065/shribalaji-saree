@extends('backend.layouts.app')

@section('title', 'Reviews')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reviews</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
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
                    <form method="GET" action="{{ route('admin.reviews') }}" class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Search</label>
                            <input name="q" value="{{ request('q') }}" class="form-control" placeholder="User, product, comment, SKU...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="is_approved" class="form-control">
                                <option value="">All</option>
                                <option value="1" @selected(request('is_approved')==='1')>Approved</option>
                                <option value="0" @selected(request('is_approved')==='0')>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            <a href="{{ route('admin.reviews') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $review->user?->name }}</div>
                                            <div class="text-muted small">{{ $review->user?->email }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $review->product?->name }}</div>
                                            <div class="text-muted small">{{ $review->product?->sku }}</div>
                                        </td>
                                        <td>{{ $review->rating }}/5</td>
                                        <td style="max-width: 420px;">
                                            <div class="text-truncate" title="{{ $review->comment }}">{{ $review->comment }}</div>
                                        </td>
                                        <td>
                                            @if($review->is_approved)
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($review->created_at)->format('d M, Y') }}</td>
                                        <td class="d-flex gap-2">
                                            <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}">
                                                @csrf
                                                <input type="hidden" name="is_approved" value="{{ $review->is_approved ? 0 : 1 }}">
                                                <button class="btn btn-sm {{ $review->is_approved ? 'btn-outline-warning' : 'btn-outline-success' }}" type="submit">
                                                    {{ $review->is_approved ? 'Unapprove' : 'Approve' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.reviews.delete', $review->id) }}" onsubmit="return confirm('Delete this review?')">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No reviews found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </section>
@endsection

