@extends('backend.layouts.app')

@section('title', 'Inventory')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inventory Movements</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Inventory</li>
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
                <form method="GET" action="{{ route('admin.inventory') }}" class="d-flex gap-2">
                    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search product, SKU, note...">
                    <select name="type" class="form-control" style="width: 160px;">
                        <option value="">All</option>
                        <option value="in" @selected(request('type')==='in')>IN</option>
                        <option value="out" @selected(request('type')==='out')>OUT</option>
                        <option value="adjust" @selected(request('type')==='adjust')>ADJUST</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                    <a href="{{ route('admin.inventory') }}" class="btn btn-light">Reset</a>
                </form>

                <a href="{{ route('admin.inventory.adjust') }}" class="btn btn-success">
                    <i class="fa-solid fa-pen-to-square"></i> Adjust Stock
                </a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>Type</th>
                                <th>Qty</th>
                                <th>Before</th>
                                <th>After</th>
                                <th>Note</th>
                                <th>By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $m)
                                <tr>
                                    <td>{{ $m->id }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $m->product?->name }}</div>
                                        <div class="text-muted small">{{ $m->product?->sku }}</div>
                                    </td>
                                    <td>
                                        @if($m->variant)
                                            <div class="font-weight-bold">{{ $m->variant->sku }}</div>
                                            <div class="text-muted small">
                                                {{ $m->variant->size }} {{ $m->variant->color }} {{ $m->variant->fabric }}
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $m->type === 'in' ? 'bg-success' : ($m->type === 'out' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ strtoupper($m->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $m->quantity }}</td>
                                    <td>{{ $m->before_stock }}</td>
                                    <td class="font-weight-bold">{{ $m->after_stock }}</td>
                                    <td>{{ $m->note }}</td>
                                    <td class="text-muted small">{{ $m->creator?->email }}</td>
                                    <td class="text-muted small">{{ optional($m->created_at)->format('d M, Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">No movements found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $movements->links() }}
            </div>
        </div>
    </section>
@endsection

