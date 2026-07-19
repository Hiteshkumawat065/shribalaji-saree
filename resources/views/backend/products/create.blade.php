@extends('backend.layouts.app')

@section('title', 'Create Product')

@section('content')
    <style>
        
        label {
            font-weight: 500 !important;
            color: #18274a !important;
        }

        .form-control.is-invalid,
        .was-validated .form-control:invalid {
            background-image: none !important;
        }

        .role-form {
            font-size: 16px;
            font-weight: 600;
        }

        .content-header {
            padding: 10px 0px;
        }

        .common-btn{
            font-size: 18px !important; 
            border-radius: 20px !important;
            background-color: #fff !important;
            color: #18274a !important;
            border: 1px solid #18274a !important;
            padding: 5px 20px 5px 20px !important;
            /* display: flex !important; */
            align-items: center; 
            position: relative;
            text-decoration: none !important;
        }

        .common-btn:hover{
            background-color: #18274a !important;
            color: #fff !important;
        }

    </style>
    <!-- Content Header (Page header) --> 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="col-sm-6">
                    <a href="{{ route('admin.products') }}">
                        <button class="mb-0 text-gray-800 dd-none d-sm-inline-block btn btn-sm btn-primary shadow-sm common-btn">
                            <i class="fa-solid fa-chevron-left"></i> <span class="ml-2">Back </span>
                        </button>
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
                        <li class="breadcrumb-item active">Product Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form id="productAddForm" method="POST" action="{{ route('admin.products.store') }}" autocomplete="off" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <p class="product-form">Create New Product</p>
                        <div class="row">   
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" class="form-control @error('name') is-invalid @enderror" value="{{ old('slug') }}">
                                    @error('slug')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="price" class="form-control @error('name') is-invalid @enderror" value="{{ old('price') }}">
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Stock <span class="text-danger">*</span></label>
                                    <input type="number" name="stock" class="form-control @error('name') is-invalid @enderror" value="{{ old('stock', 0) }}">
                                    @error('stock')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Image <span class="text-danger">*</span></label>
                                    <input type="file" name="image_path">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="mr-2">
                                        <span class="text-gray-700">Active</span>
                                    <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="mr-2">
                                        <span class="text-gray-700">Featured</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary px-4 common-btn"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection