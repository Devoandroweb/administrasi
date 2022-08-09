// submit data
function saveForm(form,url,modal,statusSubmit,method = "post",igoneinput = []){
     
    var result = false;
    var validate = false;
    var msg = null;
    validate = validateInput(form,igoneinput);
    if(statusSubmit == 1){//new
        msg = 'Menambahkan';
    }else if(statusSubmit == 2){//update
        msg = 'Mengubah';
    }
    if(validate){
       
        $.ajax({
            type: method,
            url: url,
            data: form.serialize()+ '&_method=' + method,
            dataType: "JSON",
            success: function (response) {
                $.destroyModal(modal);
                $('#data').DataTable().destroy();
                setDataTable();
                iziToast.success({
                    title: 'Success',
                    message: 'Success '+msg+' data',
                    position: 'topRight'
                });
                result = true;
            }
        });
    }
    return result;
}