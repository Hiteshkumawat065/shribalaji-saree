@extends('backend.layouts.app')

@section('title', 'Products')

@section('content')

<style>
    .productEdit, .productDelete{
      color: #030303bd !important;
      text-decoration: none !important;
    }
    .user-th { 
      background-color: #18274a !important;
	    color: #fff !important;
    }

    #productTable {
      table-layout: fixed;
      width: 100%;
    }

    #productTable th, #productTable td {
      width: 8%;
    }
    #productTable th:nth-child(1), #productTable td:nth-child(1) {
      width: 5%;
    }
    #productTable th:nth-child(2), #productTable td:nth-child(2) {
      width: 14%;
    }
    #productTable th:nth-child(3), #productTable td:nth-child(3) {
      width: 16%;
    }
    #productTable th:nth-child(4), #productTable td:nth-child(4) {
      width: 10%;
    } 
    #productTable th:nth-child(5), #productTable td:nth-child(5) {
      width: 6%;
    }
    #productTable th:nth-child(6), #productTable td:nth-child(6) {
      width: 8%;
    }
    #productTable th:nth-child(7), #productTable td:nth-child(7) {
      width: 7%;
    }
    #productTable th:nth-child(8), #productTable td:nth-child(8) {
      width: 8%;
    }
    #productTable th:nth-child(9), #productTable td:nth-child(9) {
      width: 10%;
    }
    #productTable th:nth-child(10), #productTable td:nth-child(10) {
      width: 10%;
    }
    #productTable th:nth-child(11), #productTable td:nth-child(11) {
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
          <a href="{{ route('admin.products.create') }}" class="btn btn-success common-btn add-button" > 
          <i class="fa-solid fa-user-plus"></i> <span class="ml-2">Add New Product</span></a>
        </div>
        
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
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
            <table id="productTable" class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <tr> 
                  <th></th>
                  <th><input type="text" placeholder="Search" class="form-control form-control-sm" /></th>
                  <th></th>
                  <th></th>
                  <th> 
                    <select id="productStatusSearch" class="form-select form-select-sm" onclick="event.stopPropagation()">
                      <option value="">Select</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse($productData as $product)
                    <tr>
                        <td class="px-6 py-4">{{ $product->id }}</td>
                        <td class="px-6 py-4">{{ $product->name }}</td>
                        <td class="px-6 py-4">₹{{ number_format((float)$product->price, 2) }}</td>
                        <td class="px-6 py-4">{{ $product->stock }}</td>
                        <td>
                          @if($product->is_active)
                            <span class="badge badge-success">Active</span>
                          @else
                            <span class="badge badge-secondary">Inactive</span>
                          @endif
                          @if($product->is_featured)
                            <span class="badge badge-info ml-1">Featured</span>
                          @endif
                        </td>
                        <td>
                          <a href="{{ route('admin.products.edit', $product->id) }}" class="productEdit" title="Edit Product">
                            <i class="fas fa-edit"></i>
                          </a>
                          &nbsp;
                          <a href="#" class="productDelete" data-product-id="{{ $product->id }}" title="Delete Product">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No products found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> 
  </section>
  <!-- /.content -->

<div class="mt-4">
    {{ $productData->links() }}
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    $('.productDelete').on('click', function (e) {
      e.preventDefault();
      var productId = $(this).data('product-id');
      Swal.fire({
        title: 'Delete product?',
        text: 'This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete'
      }).then(function (result) {
        if (!result.isConfirmed) return;
        window.location.href = "{{ url('admin/products') }}/" + productId + "/destroy";
      });
    });

    $('#productTable thead input[type="text"]').on('keydown', function (e) {
      if (e.key !== 'Enter') return;
      var q = $(this).val();
      window.location.href = "{{ route('admin.products.search') }}?q=" + encodeURIComponent(q);
    });
  });
</script>
@endpush