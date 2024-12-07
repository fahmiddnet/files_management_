@extends('backend.admin_master')
@section('admin')


<div class="page-content "> <!-- start:: Main Content -->
    <div class="container-fluid"><!-- start:Container -->

    <!-- start page title -->
    <div class="row">
        <div class="col-xl-4">
            <div class="page-title-box">
                <h4 class="title-default display-inline mr-15">Permissin List</h4>
                <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">Add New</a>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12 col-xl-12 mb-20">
            <div class="rh-links">
                <ul>
                    {{-- <li><a href="{{ route('permissions.index')}}" >All </a></li> --}}
                    {{-- <li><a href="{{route('trash.list')}}" class="active"> Trash ({{$trash_permission_count}})</a></li> --}}
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
                                    <th width="10%">#</th>
                                    <th width="30%">Name</th>
                                    <th width="30%">Created at</th>
                                    <th width="30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                <tr id="permission_ids_{{$permission->id}}">
                                    <th scope="row"><input type="checkbox" class="permission-checkbox" id="permission-{{$permission->id}}" name="permission_ids[]" value="{{$permission->id}}"/></th>
                                    <td>{{$permission->name ?? ''}}</td>
                                    <td>{{\Carbon\Carbon::parse($permission->create_at)->format('d M Y')}}</td>
                                    {{-- <td>Created at {{$permission->created_at->diffForHumans()}}</td> --}}
                                    <td>
                                        {{-- <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-success sm rh-btn" title="View"><i class=" fas fa-eye"></i></a> --}}
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-info sm rh-btn" title="Edit Data"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete" class="btn btn-danger sm rh-btn"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <td colspan="6">No permissions found</td>
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
            {{ $permissions->appends(request()->input())->links('pagination::bootstrap-5') }}
        </div>
    </div> <!-- end:Container -->
</div> <!-- end:: Main Content -->
@endsection

@section('scripts')

<script>
    $(document).ready(function () {
        $('#select-all-permission-id').click(function () {
            $('.permission-checkbox').prop('checked', this.checked);
        });

        $('.permission-checkbox').change(function () {
            var ids = [];
            $('.permission-checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            console.log(ids);
            // You can send 'ids' to your server using AJAX here if needed
        });

        // Form submission
        $('#bulk-action-form').submit(function (e) {
            e.preventDefault(); // Prevent normal form submission
            var permissionIds = [];

            $('.permission-checkbox:checked').each(function () {
                permissionIds.push($(this).val());
            });

            if (permissionIds.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select at least one permission.'
                });
                return;
            }

            $.ajax({
                type: 'permission',
                url: $(this).attr('action'),
                data: {
                    _token: '{{ csrf_token() }}',
                    permission_ids: permissionIds
                },
                success: function (response) {
                    console.log(response);
                    // Handle success, e.g., show a success message, reload page, etc.
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Selected permissions deleted successfully.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                            // Uncheck all checkboxes after deletion
                            $('.permission-checkbox').prop('checked', false);
                            $('#select-all-permission-id').prop('checked', false);
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
