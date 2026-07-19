@extends('backend.layouts.app')

@section('content')

  <style>
    .roleEdit, .roleDelete{
      color: #030303bd !important;
      text-decoration: none !important;
    }
    .user-th { 
      background-color: #18274a !important;
	    color: #fff !important;
    }

    #roleTable {
      table-layout: fixed;
      width: 100%;
    }

    #roleTable th, #roleTable td {
      width: 8%;
    }
    #roleTable th:nth-child(1), #roleTable td:nth-child(1) {
      width: 5%;
    }
    #roleTable th:nth-child(2), #roleTable td:nth-child(2) {
      width: 14%;
    }
    #roleTable th:nth-child(3), #roleTable td:nth-child(3) {
      width: 16%;
    }
    #roleTable th:nth-child(4), #roleTable td:nth-child(4) {
      width: 10%;
    } 
    #roleTable th:nth-child(5), #roleTable td:nth-child(5) {
      width: 6%;
    }
    #roleTable th:nth-child(6), #roleTable td:nth-child(6) {
      width: 8%;
    }
    #roleTable th:nth-child(7), #roleTable td:nth-child(7) {
      width: 7%;
    }
    #roleTable th:nth-child(8), #roleTable td:nth-child(8) {
      width: 8%;
    }
    #roleTable th:nth-child(9), #roleTable td:nth-child(9) {
      width: 10%;
    }
    #roleTable th:nth-child(10), #roleTable td:nth-child(10) {
      width: 10%;
    }
    #roleTable th:nth-child(11), #roleTable td:nth-child(11) {
      width: 6%;
    }

    .user-profile-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
    }

    .add-button {
      float:left;
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
      display: flex !important;
      align-items: center; 
      position: relative;
      text-decoration: none !important;
    }

    .common-btn:hover{
      background-color: #18274a !important;
      color: #fff !important;
    }
  </style>
  <!-- Main content --> 
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <a href="{{ route('admin.roles.create') }}" class="btn btn-success common-btn add-button" > 
          <i class="fa-solid fa-user-plus"></i> <span class="ml-2">Add New Role</span></a>
        </div>
        
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Roles</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>

  <!-- Main content -->
  <section class="content"> 
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
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
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="roleTable" class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th class="user-th">Role Id</th>
                    <th class="user-th">Role Name</th>
                    <th class="user-th">Created At</th>
                    <th class="user-th">Status</th>
                    <th class="user-th">Action</th>
                </tr>
                <tr> 
                  <th></th>
                  <th><input type="text" placeholder="Search" class="form-control form-control-sm" /></th>
                  <th></th>
                  <th> 
                    <select id="roleStatusSearch" class="form-select form-select-sm" onclick="event.stopPropagation()">
                      <option value="">Select</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($roleData))                 
                  @foreach($roleData as $roleRes)
                  
                    <tr>
                      <td>{{ $roleRes->id}}</td>
                      <td>{{ $roleRes->name}}</td>
                      <td>{{ $roleRes->created_at}}</td>
                      <td>
                        @if($roleRes->status == 1 && $roleRes->deleted_at == 0)
                          <span class="badge bg-success">Active</span>
                        @else
                          <span class="badge bg-danger">Inactive</span>
                        @endif
                      </td>
                      <td>
                          <a href="{{ route('admin.roles.edit', $roleRes->id) }}" class="roleEdit" title="Edit Role">
                            <i class="fas fa-edit"></i> 
                          </a>
                            &nbsp;

                          <a class="roleDelete" data-role-id="@php echo $roleRes->id @endphp" title="Delete Role">
                            <i class="fas fa-trash"></i>
                          </a>
                      </td>
                    </tr>
                    @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> 
  </section>
  <!-- /.content -->
@endsection

@push('scripts')
<script>
  $(document).ready(function() { 
    $('.roleDelete').on('click', function () {

      let roleId = $(this).data('role-id');

      // SweetAlert confirm
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => { 
          if (result.isConfirmed) {

            // AJAX delete request
            $.ajax({
              url: "{{ url('admin/roles') }}/" + roleId + "/destroy",
              type: "DELETE",
              data: {
                  _token: "{{ csrf_token() }}"
              },
              success: function(response) {
                if (response.status) {
                  // SweetAlert success
                  Swal.fire('Deleted!', response.message, 'success' ).then(() => {
                      // Reload the page after deletion
                      location.reload();
                  });
                } else {
                  // SweetAlert error
                  Swal.fire( 'Error!', response.message, 'error' );
                }
              },
              error: function(xhr) {
                Swal.fire( 'Error!', 'Something went wrong!', 'error');
              }
          });
        }
      });
    });
  });
 
</script>
@endpush
