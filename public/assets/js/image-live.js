function readURL(input, status) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.image-live img').attr('src', e.target.result);

        }
        reader.readAsDataURL(input.files[0]);
    }

}
$('.image-live img').css('cursor','pointer');
$('.image-live img').click(() => {
    $('.image-live input[type=file]').click();
});
$('.file-live').change(function() {
    var file = $(this);
    var files_obj = file[0].files;
    var file_size = files_obj[0].size;

    $('.image-live').siblings('.text-danger').remove();
    if (file_size > 1024000) {
        $('.image-live').after('<div class="text-danger"><i>File Tidak Boleh Lebih besar dari 1Mb</i></div>');
        return;
    }

    readURL(this);
});