@extends('backend.admin_master')
@section('admin')


<div class="page-content "> <!-- start:: Main Content -->
    <div class="container-fluid"><!-- start:Container -->

    <!-- start page title -->
    <div class="row">
        <div class="col-xl-4">
            <div class="page-title-box">
                <h4 class="title-default display-inline mr-15">Project File List</h4>
                <a href="{{ route('projectfiles.create') }}" class="btn btn-primary btn-sm">Add New</a>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12 col-xl-12 mb-20">
            <div class="rh-links">
                <ul>
                    {{-- <li><a href="{{ route('organizations.index')}}" >All </a></li> --}}
                    {{-- <li><a href="{{route('trash.list')}}" class="active"> Trash ({{$trash_post_count}})</a></li> --}}
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
                    <div class="row">
                        @foreach($projects as $project)
                        @if(!$project->orgFiles->isEmpty())

                        <div class="col-lg-12">

                            <!-- Card -->
                            <div class="card border-2 mb-4">
                                <!--Card content-->
                                <div class="card-header">    
                                    <h4 class="card-title">{{$project->name}}</h4>
                                </div>
                                <div class="card-body">
                                    <!--Text-->
                                    <p class="card-text mb-2">{!! $project->project_details !!}</p>
                        
                                    @foreach($project->orgFiles as $orgfile)
                                    <div class="fh-list">
                                        <div class="overflow-hidden">
                                            <div class="fh-item-content">
                                                <span class="title-small">{{$orgfile->name ?? ''}}</span>
                                            </div>
                                            <div class="fh-item-width">
                                                {{-- <a href="{{ route('projectfiles.show', $file->id) }}" class="btn btn-success sm rh-btn"
                                                    title="View"><i class=" fas fa-eye"></i> View</a> --}}
                                                <a href="{{ route('projectfiles.edit', $orgfile->id) }}" class="btn btn-info sm rh-btn"
                                                    title="Edit Data"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('projectfiles.destroy', $orgfile->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="delete" class="btn btn-danger sm rh-btn"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Card -->
                        </div>
                        @endif
                        @endforeach                        
                        

                                
                    </div>
                </div>
                <!-- Pagination -->
                <!-- Add your pagination links here if needed -->
            </div>
        </div>
        <div class="text-center">
            {{ $projects->appends(request()->input())->links('pagination::bootstrap-5') }}
        </div>
    </div> <!-- end:Container -->
</div> <!-- end:: Main Content -->
@endsection

@section('scripts')

<script>
    $(document).ready(function () {
        $('#select-all-post-id').click(function () {
            $('.post-checkbox').prop('checked', this.checked);
        });

        $('.post-checkbox').change(function () {
            var ids = [];
            $('.post-checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            console.log(ids);
            // You can send 'ids' to your server using AJAX here if needed
        });

        // Form submission
        $('#bulk-action-form').submit(function (e) {
            e.preventDefault(); // Prevent normal form submission
            var postIds = [];

            $('.post-checkbox:checked').each(function () {
                postIds.push($(this).val());
            });

            if (postIds.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select at least one post.'
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: {
                    _token: '{{ csrf_token() }}',
                    post_ids: postIds
                },
                success: function (response) {
                    console.log(response);
                    // Handle success, e.g., show a success message, reload page, etc.
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Selected posts deleted successfully.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                            // Uncheck all checkboxes after deletion
                            $('.post-checkbox').prop('checked', false);
                            $('#select-all-post-id').prop('checked', false);
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
