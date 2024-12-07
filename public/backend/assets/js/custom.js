$(document).ready(function (){
    $('#select-all').click(function (){
        if(this.checked){
            $(':checkbox').each(function (){
                this.checked = true;
            });
        }else {
            $(':checkbox').each(function (){
                this.checked = false;
            });
        }
    });

    $('#user_image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showUserImage').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });

    $('#cat_banner_img').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#show_cat_bnner_img').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });

    $('#page_banner').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#show_page_banner').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});

// textarea issues solved 
tinymce.init({
    selector: '#elm1',
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    },
});

tinymce.init({
    selector: '#elm2',
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    },
});


$(document).ready(function() {
    $('.select2').select2();
});