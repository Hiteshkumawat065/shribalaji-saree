@extends('backend.layouts.app')

@section('title', 'Edit Product')

@section('content')
  <style>
    label { font-weight: 500 !important; color: #18274a !important; }
    .content-header { padding: 10px 0; }
    .common-btn {
      font-size: 18px !important;
      border-radius: 20px !important;
      background-color: #fff !important;
      color: #18274a !important;
      border: 1px solid #18274a !important;
      padding: 5px 20px !important;
      align-items: center;
      text-decoration: none !important;
    }
    .common-btn:hover {
      background-color: #18274a !important;
      color: #fff !important;
    }
  </style>

  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        @if(session('success'))
          <div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
        @endif
        @if(session('error'))
          <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
        @endif

        <div class="col-sm-6">
          <a href="{{ route('admin.products') }}">
            <button type="button" class="btn btn-sm btn-primary shadow-sm common-btn mb-2">
              <i class="fas fa-chevron-left"></i> <span class="ml-2">Back</span>
            </button>
          </a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        {{-- Admin routes use POST for updates (see routes/backend/admin.php) --}}
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" autocomplete="off" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <p class="font-weight-bold mb-3">Edit product</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Product name <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                  @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Slug <span class="text-danger">*</span></label>
                  <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}" required>
                  @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Price <span class="text-danger">*</span></label>
                  <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                  @error('price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Stock <span class="text-danger">*</span></label>
                  <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
                  @error('stock')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Description</label>
                  <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                  @error('description')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Category</label>
                  <select name="category_id" class="form-control">
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ (string)old('category_id', $product->category_id) === (string)$category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('category_id')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Image</label>
                  <input type="file" name="image_path" class="form-control-file">
                  @error('image_path')<span class="text-danger small">{{ $message }}</span>@enderror
                  @if($product->image_path)
                    <div class="mt-2">
                      <img src="{{ asset('storage/'.$product->image_path) }}" alt="" class="img-thumbnail" style="max-height:96px;">
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group form-check">
                  <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">Active</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-check">
                  <input type="checkbox" name="is_featured" value="1" id="is_featured" class="form-check-input" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_featured">Featured</label>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary px-4 common-btn">Update product</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection
