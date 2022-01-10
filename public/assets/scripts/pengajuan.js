
getPengajuan()

function getPengajuan() {
    ajaxRequest.get({
        "url": "/user/pengajuan/get"
    }).then(function(result){
        if (result.response == "failed") {
            $('#pengajuan').empty()
            $('#pengajuan').html(`<div class="loader">
                                        <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                        <h5 style="margin-top: 2.5rem">${result.message}</h5>
                                    </div>`)
            $('#modalInput .modal-body').html(`<div class="loader">
                                                    <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                    <h5 style="margin-top: 2.5rem">${result.message}</h5>
                                                </div>`)
            $('#modalInput .modal-footer').remove()
        }else{
            $('#pengajuan').empty()
            if (result.data.length == 0) {
                $('#pengajuan').html(`<div class="loader">
                                                <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                <h5 style="margin-top: 2.5rem">Belum ada pengajuan</h5>
                                            </div>`)
            }else{
                $('#pengajuan').html(`<table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Pengajuan</th>
                                                <th>Catatan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-pengajuan">
                                            
                                        </tbody>
                                    </table>`)
    
                $.each(result.data, function(i, v){
                    let action = ``
                    if (v.action == true) {
                        action = action + `<button class="btn-table-action edit" data-toggle="modal" data-target="#modalDelete"
                                                data-id="${v.id}"><i class="fas fa-ban"></i> Batalkan
                                            </button>`
                    }
    
                    $('#data-pengajuan').append(`<tr>
                                                    <td style="padding-top: 11px">${v.tanggal}</td>
                                                    <td style="padding-top: 11px">${v.status}</td>
                                                    <td style="padding-top: 11px">${v.catatan}</td>
                                                    <td style="width: 150px">${action}</td>
                                                </tr>`)
                })
    
                modalDelete()
            }
        }
    })
}

$('#btn-add-pengajuan').on('click', function(){
    if ($('#tanggal').val().length == 0) {
        alert("Masukkan tanggal pengajuan")
    }else if ($('#status').val().length == 0) {
        alert("Pilih jenis pengajuan")
    }else if ($('#catatan').val().length == 0) {
        alert("Masukkan catatan")
    }else{
        $('#btn-add-pengajuan').attr('disabled', true)

        let params = {
            "tanggal": $('#tanggal').val(),
            "status": $('#status').val(),
            "catatan": $('#catatan').val()
        }

        ajaxRequest.post({
            "url": "/user/pengajuan/add",
            "data": params
        }).then(function(result){
            $('#btn-add-pengajuan').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            $('#tanggal').val(''),
            $('#status').val(''),
            $('#catatan').val('')
            $('#modalInput').modal('hide')
            getPengajuan()
        })
    }
})

function modalDelete() {
    $('.btn-table-action.edit').on('click', function(){
        $('#deleteId').val($(this).data('id'))
        $('#delete-warning-message').html('Batalkan pengajuan ?')
    })
}

$('#btn-delete-pengajuan').on('click', function(){
    $('#btn-delete-pengajuan').attr('disabled', true)
    let params = {
        "id": $('#deleteId').val()
    }

    ajaxRequest.post({
        "url": "/user/pengajuan/delete",
        "data": params
    }).then(function(result){
        $('#btn-delete-pengajuan').removeAttr('disabled')
        $('#modalDelete').modal('hide')
        toastr.option = {
            "timeout": "5000"
        }
        toastr["success"](result.message)
        getPengajuan()
    })
})