@extends('backend.layouts.app')

@section('title', 'SEO - Products')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SEO - Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">SEO Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('admin.seo.products') }}" class="d-flex gap-2">
                        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name / SKU / slug">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{ route('admin.seo.products') }}" class="btn btn-light">Reset</a>
                    </form>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Slug</th>
                                <th>Meta title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td class="font-weight-bold">{{ $p->name }}</td>
                                    <td>{{ $p->sku }}</td>
                                    <td class="text-muted small">{{ $p->slug }}</td>
                                    <td>{{ $p->meta_title }}</td>
                                    <td>
                                        <a href="{{ route('admin.seo.products.edit', $p->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection

