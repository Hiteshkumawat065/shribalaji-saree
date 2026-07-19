@extends('backend.layouts.app')

@section('title', 'Adjust Stock')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Adjust Stock</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventory') }}">Inventory</a></li>
                        <li class="breadcrumb-item active">Adjust</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.inventory.adjust') }}" class="row g-2 align-items-end mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Product</label>
                            <select name="product_id" class="form-control" required>
                                <option value="">Select product</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" @selected((string)request('product_id') === (string)$p->id)>
                                        {{ $p->name }} (SKU: {{ $p->sku }}) — Stock: {{ $p->stock }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit">Load Variants</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('admin.inventory.adjust.store') }}">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ old('product_id', request('product_id')) }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Variant (optional)</label>
                                    <select name="product_variant_id" class="form-control">
                                        <option value="">No variant (update product stock)</option>
                                        @foreach($variants as $v)
                                            <option value="{{ $v->id }}" @selected((string)old('product_variant_id') === (string)$v->id)>
                                                {{ $v->sku }} — Stock: {{ $v->stock }} — {{ $v->size }} {{ $v->color }} {{ $v->fabric }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control" required>
                                        <option value="in" @selected(old('type')==='in')>IN (add)</option>
                                        <option value="out" @selected(old('type')==='out')>OUT (deduct)</option>
                                        <option value="adjust" @selected(old('type')==='adjust')>ADJUST (set exact)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" min="1" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Note</label>
                            <input name="note" class="form-control" value="{{ old('note') }}" placeholder="Reason: supplier delivery, correction, damaged goods...">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.inventory') }}" class="btn btn-light">Cancel</a>
                            <button class="btn btn-success" type="submit">
                                <i class="fa-solid fa-check"></i> Update Stock
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

