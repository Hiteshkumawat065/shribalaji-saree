@extends('backend.layouts.app')

@section('content')

  <style>
    .userEdit, .userDelete{
      color: #030303bd !important;
      text-decoration: none !important;
    }
    .user-th { 
      background-color: #18274a !important;
	    color: #fff !important;
    }

    #usersTable {
      table-layout: fixed;
      width: 100%;
    }

    #usersTable th, #usersTable td {
      width: 8%;
    }
    #usersTable th:nth-child(1), #usersTable td:nth-child(1) {
      width: 5%;
    }
    #usersTable th:nth-child(2), #usersTable td:nth-child(2) {
      width: 14%;
    }
    #usersTable th:nth-child(3), #usersTable td:nth-child(3) {
      width: 16%;
    }
    #usersTable th:nth-child(4), #usersTable td:nth-child(4) {
      width: 10%;
    } 
    #usersTable th:nth-child(5), #usersTable td:nth-child(5) {
      width: 6%;
    }
    #usersTable th:nth-child(6), #usersTable td:nth-child(6) {
      width: 8%;
    }
    #usersTable th:nth-child(7), #usersTable td:nth-child(7) {
      width: 7%;
    }
    #usersTable th:nth-child(8), #usersTable td:nth-child(8) {
      width: 8%;
    }
    #usersTable th:nth-child(9), #usersTable td:nth-child(9) {
      width: 10%;
    }
    #usersTable th:nth-child(10), #usersTable td:nth-child(10) {
      width: 10%;
    }
    #usersTable th:nth-child(11), #usersTable td:nth-child(11) {
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
          <a href="{{ route('admin.users.create') }}" class="btn btn-success common-btn add-button" > 
          <i class="fa-solid fa-user-plus"></i> <span class="ml-2">Add New User</span></a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
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
            </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="usersTable" class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th class="user-th">S.no</th>
                    <th class="user-th">Name</th>
                    <th class="user-th">Email Id</th>
                    <th class="user-th">Mobile No.</th>
                    <th class="user-th">DOB</th>
                    <th class="user-th">Country</th>
                    <th class="user-th">Profile</th>
                    <th class="user-th">Ip Address</th>
                    <th class="user-th">Role</th>
                    <th class="user-th">Status</th>
                    <th class="user-th">Action</th>
                </tr>
                <tr> 
                  <th></th>
                  <th><input type="text" placeholder="Search" class="form-control form-control-sm" /></th>
                  <th><input type="text" placeholder="Search" class="form-control form-control-sm" /></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>
                    <select id="userRoleSearch" class="form-select form-select-sm" onclick="event.stopPropagation()">
                      <option value="">Select</option>
                      <option value="superAdmin">Super Admin</option>
                      <option value="admin">Admin</option>
                      <option value="user">User</option>
                      <option value="member">Member</option>
                    </select>
                  </th>
                  <th> 
                    <select id="userStatusSearch" class="form-select form-select-sm" onclick="event.stopPropagation()">
                      <option value="">Select</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($userData))
                  @php $i = 1; @endphp                  
                  @foreach($userData as $userRes)
                    <tr @php echo $userRes->is_active == 1 ? 'class="activeStatus"' : 'class="inactiveStatus"'; @endphp>
                      <td>{{ $i }}</td>
                      <td>{{ $userRes->name ?? '-'}}</td>
                      <td>{{ $userRes->email  ?? '-'}}</td>
                      <td>{{ $userRes->userDetails->mobile_no ?? '-' }}</td>
                      <td>
                        {{ !empty($userRes->userDetails->dob)
                            ? \Carbon\Carbon::parse($userRes->userDetails->dob)->format('d M Y')
                            : '-' }}
                      </td>
                      <td>{{ $userRes->userDetails->country ?? '-' }}</td>
                      <td>
                        @if(!empty($userRes->userDetails->profile_image))
                          <img src="{{ asset('storage/' . $userRes->userDetails->profile_image) }}" class="user-profile-img" alt="Profile Image">
                        @else
                          <span>-</span>
                        @endif
                      </td>

                      <td>{{ $userRes->userDetails->ip_address ?? '-' }}</td>
                      <td>{{ ucfirst($userRes->role) ?? '-'}}</td>
                      <td>
                        @if($userRes->is_active == 1)
                          <span class="badge bg-success">Active</span>
                        @else
                          <span class="badge bg-danger">Inactive</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('admin.users.edit', $userRes->id) }}" class="userEdit" title="Edit User">
                          <i class="fas fa-edit"></i> 
                        </a>
                          &nbsp;

												<a class="userDelete" data-user-id="@php echo $userRes->id @endphp" title="Delete GFE">
													<i class="fas fa-trash"></i>
												</a>
                      </td>
                    </tr>
                    @php $i++; @endphp
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
    $('.userDelete').on('click', function () {

      let userId = $(this).data('user-id');

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
              url: "{{ url('admin/users') }}/" + userId + "/destroy",
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
