@extends('backend.admin_master')
@section('admin')


<div class="page-content "> <!-- start:: Main Content -->
    <div class="container-fluid"><!-- start:Container -->

    <!-- start page title -->
    <div class="row">
        <div class="col-xl-4">
            <div class="page-title-box">
                <h4 class="title-default display-inline mr-15">Role List</h4>
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Add New</a>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12 col-xl-12 mb-20">
            <div class="rh-links">
                <ul>
                    {{-- <li><a href="{{ route('roles.index')}}" >All </a></li> --}}
                    {{-- <li><a href="{{route('trash.list')}}" class="active"> Trash ({{$trash_role_count}})</a></li> --}}
                </ul>
            </div>
            {{-- <a href="" class="btn btn-danger" id="deleteAllselectedRecord">Delete</a> --}}
        
            <div class="row">
                <div class="col-lg-3 col-xl-3">
                    <div class="rh-select-wrap">
                       <!-- Bulk options form -->
                   
                    </div>
                </div>
                
                <div class="col-lg-3 col-xl-4">
                    <form action="#" method="GET">
                        <div class="rh-select-wrap">
                            <input type="search" name="search_string" id="search" class="form-control"/>
                        </div>
                        <div class="rh-bttn-wrap">
                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="20%">Name</th>
                                    <th width="30%">Permission</th>
                                    <th width="20%">Created at</th>
                                    <th width="40%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr id="role_ids_{{$role->id}}">
                                    <th scope="row"><input type="checkbox" class="role-checkbox" id="role-{{$role->id}}" name="role_ids[]" value="{{$role->id}}"/></th>
                                    <td>{{$role->name ?? ''}}</td>
                                    {{-- <td>Permission</td> --}}
                                    <td>{{$role->permissions->pluck('name')->implode(',') ?? ''}}</td>
                                    <td>{{\Carbon\Carbon::parse($role->create_at)->format('d M Y')}}</td>
                                    <td>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info sm rh-btn" title="Edit Data"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete" class="btn btn-danger sm rh-btn"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <td colspan="6">No roles found</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination -->
                <!-- Add your pagination links here if needed -->
            </div>
        </div>
        <div class="text-center">
            {{ $roles->appends(request()->input())->links('pagination::bootstrap-5') }}
        </div>
    </div> <!-- end:Container -->
</div> <!-- end:: Main Content -->
@endsection

@section('scripts')

<script>
    $(document).ready(function () {
        $('#select-all-role-id').click(function () {
            $('.role-checkbox').prop('checked', this.checked);
        });

        $('.role-checkbox').change(function () {
            var ids = [];
            $('.role-checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            console.log(ids);
            // You can send 'ids' to your server using AJAX here if needed
        });

        // Form submission
        $('#bulk-action-form').submit(function (e) {
            e.preventDefault(); // Prevent normal form submission
            var roleIds = [];

            $('.role-checkbox:checked').each(function () {
                roleIds.push($(this).val());
            });

            if (roleIds.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select at least one role.'
                });
                return;
            }

            $.ajax({
                type: 'role',
                url: $(this).attr('action'),
                data: {
                    _token: '{{ csrf_token() }}',
                    role_ids: roleIds
                },
                success: function (response) {
                    console.log(response);
                    // Handle success, e.g., show a success message, reload page, etc.
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Selected roles deleted successfully.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                            // Uncheck all checkboxes after deletion
                            $('.role-checkbox').prop('checked', false);
                            $('#select-all-role-id').prop('checked', false);
                        }
                    });
                },
                error: function (error) {
                    console.error(error);
                    // Handle error, e.g., show an error message, etc.
                }
            });
        });
    });
</script>

@endsection
