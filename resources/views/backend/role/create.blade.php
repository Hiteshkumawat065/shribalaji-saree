@extends('backend.layouts.app')

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
          <a href="{{ route('admin.roles') }}">
              <button class="mb-0 text-gray-800 dd-none d-sm-inline-block btn btn-sm btn-primary shadow-sm common-btn">
                <i class="fa-solid fa-chevron-left"></i> <span class="ml-2">Back </span>
              </button>
          </a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.roles') }}">Roles</a></li>
            <li class="breadcrumb-item active">Role Form</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <form id="roleAddForm" method="POST" action="{{ route('admin.roles.store') }}" autocomplete="off" enctype="multipart/form-data">
          <div class="card-body">
            @csrf
            <p class="role-form">Create Role</p>
            <div class="row">
              <!-- Full Name --> 
              <div class="col-md-12">
                <div class="form-group">
                  <label>Name <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                  @error('name')
                      <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Permissions <span class="text-danger">*</span></label>
                  @if(!empty($allPermissions))  
                    @foreach($allPermissions as $permission)
                    <input type="checkbox"
                          name="permissions[]"
                          value="{{ $permission->name }}"
                          {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                    {{ $permission->name }}
                    @endforeach
                  @endif
                </div>
              </div>
            </div> 
          </div>

          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary px-4 common-btn">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
  
  $(document).ready(function() { 
    $('#roleAddForm').validate({
      rules: {
          name: {
              required: true,
              minlength: 3
          }, 
      },
      messages: {
          name: {
              required: "Please enter the role name",
              minlength: "Name must be at least 3 characters long"
          },
      },
      errorElement: 'span',
      errorClass: 'invalid-feedback',
      highlight: function(element) {
          $(element).addClass('is-invalid');
      },
      unhighlight: function(element) {
          $(element).removeClass('is-invalid');
      },
      errorPlacement: function(error, element) {
          if(element.prop('type') === 'file') {
              error.insertAfter(element);
          } else {
              error.insertAfter(element);
          }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    setTimeout(function() {
        $('.alert-danger').fadeOut('slow');
        $('.alert-success').fadeOut('slow');
    }, 3000);
  });
 
</script>
@endpush


