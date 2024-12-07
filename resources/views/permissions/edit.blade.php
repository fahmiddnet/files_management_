@extends('backend.admin_master')
@section('admin')


<div class="page-content "> <!-- start:: Main Content -->
    <div class="container-fluid"><!-- start:Container -->

        <!-- start page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="page-title-box">
                    <h4 class="title-default display-inline mr-15">Add New Permission </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('permissions.update', $permission->id)}}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div>
                                <label for="permission-title" class="col-form-label">Title</label>
                                <input id="permission-title" class="form-control" type="text"  name="permission_title">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="permission-name" class="col-form-label">Name</label>
                            <input value="{{ old('name',$permission->name)}}" name="name" class="form-control" type="text"  id="permission-name">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="card-foot">
                            <button type="submit" class="btn btn-sm btn-primary btn-primary waves-effect waves-light">Update</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-danger btn-sm">Cancle</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        </form>
    </div> <!-- end:Container -->
</div> <!-- end:: Main Content -->
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endsection
