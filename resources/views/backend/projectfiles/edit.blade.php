@extends('backend.admin_master')
@section('admin')


<div class="page-content "> <!-- start:: Main Content -->
    <div class="container-fluid"><!-- start:Container -->

        <!-- start page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="page-title-box">
                    <h4 class="title-default display-inline mr-15">Edit Project File</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('projectfiles.update',$orgFile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
        <div class="row">
            <div class="col-lg-9 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <fieldset disabled>
                            <div class="mb-3">
                                <label for="org">Project</label>
                                <select name="project_id" id="org" class="form-control mb-3" aria-label="Large select example">
                                    <option value="{{$projectid}}" selected>{{$projectName}}</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- start: genarel settings -->
                        <div class="excerpt">
                            <div id="accordion" class="custom-accordion">
                                <div class="card">
                                    <a href="#general_settings" class="text-dark" data-bs-toggle="collapse"
                                                    aria-expanded="false"
                                                    aria-controls="collapseOne">
                                        <div class="card-header" id="headingOne">
                                            <h6 class="m-0">
                                                Files 
                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                            </h6>
                                        </div>
                                    </a>
                                    <div id="general_settings" class="collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <div class="col-sm-12 mb-3">
                                                <div class="col-sm-12 mb-2">
                                                    <label class="col-form-label">File name</label>
                                                    <input value="{{$orgFile->custom_name}}" name="custom_file_name" class="form-control" type="text" placeholder="File name">
                                                    @error('custom_file_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-12">
                                                    <input name="file_name" class="form-control" type="file">
                                                    <span>{{basename($orgFile->file_name)}}</span>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                        <!-- end: genarel settings -->
                    
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xl-3">
                <div class="sidebar">
                    <div id="accordion" class="custom-accordion">
                        <div class="card">
                            <a href="#publish" class="text-dark" data-bs-toggle="collapse"
                                            aria-expanded="true"
                                            aria-controls="collapseOne">
                                <div class="card-header" id="headingOne">
                                    <h6 class="m-0">
                                        Publish
                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                    </h6>
                                </div>
                            </a>

                            <div id="publish" class="collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="">
                                        <ul>
                                            <li><b>Note:</b><br>
                                            {{-- <fieldset>
                                                <input type="radio" name="project_status" value="1" checked>
                                                <label>Active</label><br>
                                                <input type="radio" name="project_status" value="0">
                                                <label>Inactive</label>
                                            </fieldset> --}}
                                        </ul>
                                    </div>
                                    <div class="card-foot" style="">
                                        <button type="submit" class="btn btn-sm btn-primary btn-primary waves-effect waves-light">Update</button>
                                        <a href="{{ route('projectfiles.index') }}" class="btn btn-danger btn-sm">Cancle</a>
                                    </div>
                                </div>
                            </div>
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
   Dropzone.autoDiscover = false;    
    const dropzone = $("#image").dropzone({ 
			uploadprogress: function(file, progress, bytesSent) {
         
    },
      url:  "{{ route('projects.create') }}",
      maxFiles: 10,
      paramName: 'image',
      addRemoveLinks: true,
      acceptedFiles: "image/jpeg,image/png,image/gif",
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }, success: function(file, response){

        var html = `<div class="col-xl-3">
                        <div class="card">
                            <img src="${response.imagePath}" alt="logo"/>
                            <input type="text" name="caption[]" value="" class="form-control"/>
                            <input type="hidden" name="image_id[]" value="${response.image_id}" class="form-control"/>
                        </div>
                    </div>`;
        $("#gallery_append").append(html);
        this.removeFile(file);            
      }
  });

  $("#postForm").submit(function(event){
     
    event.preventDefault();
        

        $.ajax({
            url:"{{ route('projects.store') }}",
            data:$(this).serializeArray(),
            method:'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(response){
                toastr.success(response.message);
                window.location.href = "/posts"
            } // success end

        }); // ajax end

    }) // submit end

</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<script>
    
</script>
@endsection
