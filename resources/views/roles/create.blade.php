@extends('backend.admin_master')
@section('admin')


<div class="page-content "> <!-- start:: Main Content -->
    <div class="container-fluid"><!-- start:Container -->

        <!-- start page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="page-title-box">
                    <h4 class="title-default display-inline mr-15">Add New Role </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('roles.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div>
                                <label for="role-title" class="col-form-label">Title</label>
                                <input id="role-title" class="form-control" type="text"  name="role_title">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role-name" class="col-form-label">Name</label>
                            <input value="{{ old('name')}}" name="name" class="form-control" type="text"  id="role-name">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            @if($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <input type="checkbox" name="permission[]" class="rounded" id="{{ $permission->id }}"
                                    value="{{ $permission->name }}">
                                    <label for="{{ $permission->id }}">{{ $permission->name }}</label>
                                    <br>
                                @endforeach
                            @endif
                        </div>
                        <div class="card-foot">
                            <button type="submit" class="btn btn-sm btn-primary btn-primary waves-effect waves-light">Save</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-danger btn-sm">Cancle</a>
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
