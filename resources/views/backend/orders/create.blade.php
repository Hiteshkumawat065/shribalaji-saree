@extends('backend.layouts.app')

@section('content')

  <style>
    .userEdit, .userDelete{
      color: #030303bd !important;
      text-decoration: none !important;
    }
    
    label {
      font-weight: 500 !important;
      color: #18274a !important;
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

    #dob {
      cursor: pointer;
    }

    .user-form {
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
        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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
          <a href="{{ route('admin.users') }}">
              <button class="mb-0 text-gray-800 dd-none d-sm-inline-block btn btn-sm btn-primary shadow-sm common-btn">
                <i class="fa-solid fa-chevron-left"></i> <span class="ml-2">Back </span>
              </button>
          </a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
            <li class="breadcrumb-item active">User Form</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <form id="userAddForm" method="POST" action="{{ route('admin.users.store') }}" autocomplete="off" enctype="multipart/form-data">
          <div class="card-body">
            @csrf
            <p class="user-form">Create user</p>
            <div class="row">

              <!-- Full Name --> 
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                  @error('name')
                      <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email <span class="text-danger">*</span></label>
                  <input type="email" name="email"
                      class="form-control @error('email') is-invalid @enderror"
                      value="{{ old('email') }}">
                  @error('email')
                      <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <!-- Mobile -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Mobile No <span class="text-danger">*</span></label>
                  <input type="text" name="mobile_no"
                      class="form-control @error('mobile_no') is-invalid @enderror"
                      value="{{ old('mobile_no') }}">
                  @error('mobile_no')
                      <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <!-- DOB -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dob">Date of Birth</label>
                  <input type="date"  class="form-control @error('dob') is-invalid @enderror" 
                      name="dob" 
                      id="dob" 
                      value="{{ old('dob') }}"
                      placeholder="Select Date of Birth" >
                  @error('dob')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>  

              <!-- Role -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Role <span class="text-danger">*</span></label>
                  <select name="role" class="form-control @error('role') is-invalid @enderror">
                    <option value="">Select Role</option>
                    <option value="superAdmin" {{ old('role')=='superAdmin'?'selected':'' }}>Super Admin</option>
                    <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
                    <option value="user" {{ old('role')=='user'?'selected':'' }}>User</option>
                    <option value="member" {{ old('role')=='member'?'selected':'' }}>Member</option>
                  </select>
                  @error('role')
                      <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <!-- Country -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Country</label>
                  <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                </div>
              </div>

              <!-- Gender -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Gender</label>
                  <select name="gender" class="form-control" required>
                      <option value="">Select Gender</option>
                      <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Male</option>
                      <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female</option>
                      <option value="other" {{ old('gender')=='other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
              </div>
              
              <!-- Address -->
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Address</label>
                      <textarea name="address" class="form-control"
                          rows="2">{{ old('address') }}</textarea>
                  </div>
              </div>

              <!-- Password -->
              <div class="col-md-6">
                <div class="form-group position-relative">
                  <label>Password <span class="text-danger">*</span></label>  
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" id="password" autocomplete="new-password">
                  <span class="password-toggle">
                      <i class="fas fa-eye" id="toggele_password_icon"></i>
                  </span>
                  @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Confirm Password <span class="text-danger">*</span></label>
                  <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" >
                </div>
              </div>


              <!-- Profile Image -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Profile Image <span class="text-danger">*</span></label>
                  <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
                    @error('profile_image')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
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
  // <!-- JS: Password Toggle -->
  const togglePassword = document.getElementById('toggele_password_icon');
  const passwordField = document.getElementById('password');
  
  togglePassword.addEventListener('click', function () {
    const type = passwordField.getAttribute('type') == 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });

  document.addEventListener('DOMContentLoaded', function () {
    const dobInput = document.getElementById('dob');

    dobInput.addEventListener('click', function () {
      if (this.showPicker) {
        this.showPicker();   // Chrome / Edge
      } else {
        this.focus();        // Fallback
      }
    });
  });
 

  $(document).ready(function() { 
    $('#userAddForm').validate({
      rules: {
          name: {
              required: true,
              minlength: 3
          },
          email : {
              required: true,
              email: true
          },
          mobile_no: {
              required: true,
              digits: true,
              minlength: 10,
              maxlength: 15
          },
          dob: {
              required: true,
              date: true
          },
          role: {
              required: true
          },
          gender: {
              required: true
          },
          profile_image: {
              required: true,
              extension: "jpg|jpeg|png"
          },
          password: {
              required: true,
              minlength: 7
          },
          password_confirmation: { // confirm password field
              required: true,
              minlength: 7,
              equalTo: "#password" // must match the password field
          }
      },
      messages: {
          name: {
              required: "Please enter full name",
              minlength: "Name must be at least 3 characters long"
          },
          email: {
              required: "Please enter email",
              email: "Please enter a valid email address"
          },
          mobile_no: {
              required: "Please enter mobile number",
              digits: "Only digits allowed",
              minlength: "Mobile number must be at least 10 digits",
              maxlength: "Mobile number can be maximum 15 digits"
          },
          dob: {
              required: "Please select Date of Birth",
              date: "Please enter a valid date"
          },
          role: {
              required: "Please select a role"
          },
          gender: {
              required: "Please select a gender"
          },
          profile_image: {
              required: "Please upload a profile image",
              extension: "Allowed file types: jpg, jpeg, png"
          },
          password: {
              required: "Please enter a password",
              minlength: "Password must be at least 7 characters"
          },
          password_confirmation: {
              required: "Please confirm your password",
              minlength: "Password must be at least 7 characters",
              equalTo: "Passwords do not match"
          }
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
