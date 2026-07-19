@extends('backend.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Testimonial</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials') }}">Testimonials</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="POST" action="{{ route('admin.testimonials.update', $testimonial->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Designation</label>
                            <input name="designation" class="form-control" value="{{ old('designation', $testimonial->designation) }}">
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <input name="rating" type="number" min="1" max="5" class="form-control" value="{{ old('rating', $testimonial->rating) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" rows="4" class="form-control" required>{{ old('message', $testimonial->message) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Sort order</label>
                            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order) }}">
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                                Active
                            </label>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.testimonials') }}" class="btn btn-light">Back</a>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

