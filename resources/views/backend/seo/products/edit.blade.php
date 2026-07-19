@extends('backend.layouts.app')

@section('title', 'SEO - Edit Product')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SEO - {{ $product->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.seo.products') }}">SEO Products</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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

            <div class="card card-primary">
                <form method="POST" action="{{ route('admin.seo.products.update', $product->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Meta title</label>
                            <input name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}">
                        </div>
                        <div class="form-group">
                            <label>Meta description</label>
                            <textarea name="meta_description" rows="4" class="form-control">{{ old('meta_description', $product->meta_description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta keywords</label>
                            <input name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $product->meta_keywords) }}" placeholder="comma,separated,keywords">
                        </div>
                        <div class="form-group">
                            <label>Canonical URL</label>
                            <input name="canonical_url" class="form-control" value="{{ old('canonical_url', $product->canonical_url) }}">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.seo.products') }}" class="btn btn-light">Back</a>
                        <button class="btn btn-success" type="submit">Save SEO</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

