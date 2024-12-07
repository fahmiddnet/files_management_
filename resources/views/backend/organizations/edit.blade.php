@extends('backend.admin_master')
@section('admin')


<div class="page-content "> <!-- start:: Main Content -->
    <div class="container-fluid"><!-- start:Container -->

        <!-- start page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="page-title-box">
                    <h4 class="title-default display-inline mr-15">Add New Organization </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('organizations.update',$organization->id)}}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div>
                                <label for="org_name" class="col-form-label">Name</label>
                                <input value="{{old('org_name',$organization->org_name)}}" id="org_name" class="form-control" type="text" placeholder="Organization name" name="org_name">
                                @error('org_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="col-form-label">Number</label>
                            <input value="{{ old('org_phone',$organization->org_phone)}}" name="org_phone" class="form-control" type="text"  id="phone_number" placeholder="Phone number">
                            @error('org_phone')
                                    <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- start: organization address -->
                        <div class="excerpt">
                            <div id="accordion" class="custom-accordion">
                                <div class="card">
                                    <a href="#org_address" class="text-dark" data-bs-toggle="collapse"
                                                    aria-expanded="false"
                                                    aria-controls="collapseOne">
                                        <div class="card-header" id="headingOne">
                                            <h6 class="m-0">
                                                Address
                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                            </h6>
                                        </div>
                                    </a>
                                    <div id="org_address" class="collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <textarea id="elm2" name="org_address">{{old('org_address',$organization->org_address)}}</textarea>
                                            {{-- <div class="col-sm-12 mb-3">
                                                <div class="col-sm-12">
                                                    <textarea id="elm2" name="post_content"></textarea>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: organization address -->
                        <!-- start: organization details -->
                        <div class="excerpt">
                            <div id="accordion" class="custom-accordion">
                                <div class="card">
                                    <a href="#org_details" class="text-dark" data-bs-toggle="collapse"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne">
                                        <div class="card-header" id="headingOne">
                                            <h6 class="m-0">
                                                Organization Details
                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                            </h6>
                                        </div>
                                    </a>
        
                                    <div id="org_details" class="collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <div class="texteditor">
                                                {{-- <label class="col-form-label">Organization Details</label> --}}
                                                <textarea id="elm1" name="org_info">{{old('org_info',$organization->org_info)}}</textarea>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: organization details -->

                        <!-- start: photo gallery -->
                        {{-- <div class="excerpt">
                            <div id="accordion" class="custom-accordion">
                                <div class="card">
                                    <a href="#photo_gallery" class="text-dark" data-bs-toggle="collapse"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne">
                                        <div class="card-header" id="headingOne">
                                            <h6 class="m-0">
                                                Photo Gallery
                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                            </h6>
                                        </div>
                                    </a>
                                    <div id="photo_gallery" class="collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <div id="image" class="dropzone dz-clickable">
                                                <div class="dz-message needsclick">    
                                                    <br>Drop files here or click to upload.<br><br>                                            
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" id="gallery_append"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- end: photo gallery -->
                        <div class="card-foot">
                            <button type="submit" class="btn btn-md btn-primary waves-effect waves-light">Update</button>
                            <a href="{{ route('organizations.index') }}" class="btn btn-danger btn-md">Cancle</a>
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
       url:  "{{ route('organizations.create') }}",
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
             url:"{{ route('organizations.store') }}",
             data:$(this).serializeArray(),
             method:'post',
             dataType: 'json',
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             },
             success: function(response){
                 toastr.success(response.message);
                 window.location.href = "/organizations"
             } // success end
 
         }); // ajax end
 
     }) // submit end
 
 </script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endsection
