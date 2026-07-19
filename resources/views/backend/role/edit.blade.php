@extends('backend.layouts.app')

@section('content')

  <style>
    .userEdit, .userDelete{
      color: #030303bd !important;
      text-decoration: none !important;
    }
    
    label {
      font-weight: 500 !important;
    }

    .password-toggle {
      position: absolute;
      top: 50px;
      right: 12px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
    }

    .form-control.is-invalid,
    .was-validated .form-control:invalid {
      background-image: none !important;
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

    #profile_image {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    #file_name {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: 0;
        border: 1px solid #dee2e6 !important;
    }


    .custom-btn {
      font-size: 17px !important; 
      background-color: #fff !important;
      color: #18274a !important;
      border: 1px solid #dee2e6 !important;
      padding: 5px 20px 5px 20px !important;
      align-items: center; 
      position: relative;
      text-decoration: none !important;
    }

    .custom-btn:hover{
      background-color: #18274a !important;
      color: #fff !important;
    }


  </style>
  <!-- Content Header (Page header) --> 
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Success message -->
      
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <div class="col-sm-6">
          <a href="{{ route('admin.roles') }}">
            <button class="mb-0 text-gray-800 dd-none d-sm-inline-block btn btn-sm btn-primary shadow-sm common-btn">
              <i class="fas fa-chevron-left"></i> <span class="ml-2">Back </span>
            </button>
          </a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.roles') }}">Roles</a></li>
            <li class="breadcrumb-item active">Role Edit Form</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <form id="roleEditForm" method="POST" action="{{ route('admin.roles.update', $role->id) }}" autocomplete="off" enctype="multipart/form-data">
          <div class="card-body">
            @csrf

            <div class="row">
              <!-- Full Name --> 
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}">
                  @error('name')
                      <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Permissions</label>
                  <div class="border rounded p-3 bg-light" style="max-height:220px;overflow-y:auto;">
                  @foreach($permissions as $permission)
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="permissions[]" id="perm-{{ $permission->id }}" value="{{ $permission->name }}"
                        {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                      <label class="form-check-label" for="perm-{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                  @endforeach
                  </div>
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
    // Form Validation
    $('#roleEditForm').validate({
      rules: {
          name: {
              required: true,
              minlength: 3
          },
          
      },
      messages: {
          name: {
              required: "Please enter role name",
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
  });
 
</script>
@endpush
