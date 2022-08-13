$(document).on('click','.delete',function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Kamu Yakin?',
            text: "Menghapus data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
            }).then((result) => {
            if (result.isConfirmed) {
                deleteData($(this).attr('href'),'post',{_method:'delete'});
            }
        })
    
});
function deleteData(url,type = "get",method = null){
    $.ajax({
        type: type,
        url: url,
        data : method,
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                iziToast.success({
                    title: 'Success',
                    message: response.msg,
                    position: 'topRight'
                });
                $('#data').DataTable().destroy();
                setDataTable();
            }
        }
    });
}