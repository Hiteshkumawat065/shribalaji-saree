@extends('backend.layouts.app')

@section('title', 'Edit Banner')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Banner</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.banners') }}">Banners</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input name="title" class="form-control" value="{{ old('title', $banner->title) }}">
                        </div>
                        <div class="form-group">
                            <label>Subtitle</label>
                            <input name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
                        </div>
                        <div class="form-group">
                            <label>Link URL</label>
                            <input name="link_url" class="form-control" value="{{ old('link_url', $banner->link_url) }}">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select name="position" class="form-control" required>
                                @foreach(['home_hero','home_offer','category_top'] as $pos)
                                    <option value="{{ $pos }}" @selected(old('position', $banner->position)===$pos)>{{ $pos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sort order</label>
                            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order) }}">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image_path" class="form-control">
                            @if($banner->image_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$banner->image_path) }}" style="height:60px;">
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                Active
                            </label>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.banners') }}" class="btn btn-light">Back</a>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

