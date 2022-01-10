
getKaryawanData()

function getKaryawanData() {
    ajaxRequest.get({
        "url": '/admin/karyawan/get'
    }).then(function(result){
        console.log(result);
        $('#karyawan-table').html(`<table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Telepon</th>
                                                <th>Divisi</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="user-data">
                                            
                                        </tbody>
                                    </table>`)

        let userData = ``
        $.each(result, function(i, v){
            userData = userData + `<tr>
                                        <td class="user-data-img">
                                            <div style="background-image: url(${v.foto})"></div>
                                        </td>
                                        <td class="user-data">${v.nik}</td>
                                        <td class="user-data">${v.nama}</td>
                                        <td class="user-data">${v.telepon}</td>
                                        <td class="user-data">${v.divisi.nama}</td>
                                        <td style="padding-top: 20px">
                                            <button class="btn-table-action edit" data-toggle="modal" data-target="#modalEdit"
                                                data-id="${v.id}"
                                                data-nik="${v.nik}"
                                                data-nama="${v.nama}"
                                                data-telepon="${v.telepon}"
                                                data-divisi="${v.divisi.id}"><i class="fas fa-cog"></i>
                                            </button>
                                            &nbsp;
                                            <button class="btn-table-action delete" data-toggle="modal" data-target="#modalDelete"
                                                data-id="${v.id}"
                                                data-nik="${v.nik}"
                                                data-nama="${v.nama}"><i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>`
        })

        $('#user-data').html(userData)
        modalEdit()
        modalDelete()
    })
}

$('#btn-add-user').on('click', function(){
    $('#btn-add-user').attr('disabled', true)
    if ($('#addNik').val().length == 0) {
        alert('Masukkan NIK')
    }else if ($('#addNama').val().length == 0) {
        alert('Masukkan nama')
    }else if ($('#addTelepon').val().length == 0) {
        alert('Masukkan telepon')
    }else if ($('#addDivisi').val().length == 0) {
        alert('Pilih divisi')
    }else{
        let data = {
            "nik": $('#addNik').val(),
            "nama": $('#addNama').val(),
            "telepon": $('#addTelepon').val(),
            "divisi": $('#addDivisi').val(),
        }

        ajaxRequest.post({
            "url": "/admin/karyawan/add",
            "data": data
        }).then(function(result){
            $('#btn-add-user').removeAttr('disabled')
            if (result.response == "failed") {
                toastr.option = {
                    "timeout": "5000"
                }
                toastr["info"](result.message)
            }else if(result.response == "success"){
                getKaryawanData()
                $('#modalInput').modal('hide')
                $('#addNik').val('')
                $('#addNama').val('')
                $('#addTelepon').val('')
                $('#addDivisi').val('')
                toastr.option = {
                    "timeout": "5000"
                }
                toastr["success"](result.message)
            }
        })
    }
})

function modalEdit() {
    $('.btn-table-action.edit').on('click', function(){
        $('#editId').val($(this).data('id'))
        $('#editNik').val($(this).data('nik'))
        $('#editNama').val($(this).data('nama'))
        $('#editTelepon').val($(this).data('telepon'))
        $(`#editDivisi option[value="${$(this).data('divisi')}"]`).attr('selected', true)
    })
}

$('#modalEdit').on('hide.bs.modal', function(){
    $('#editDivisi').val('')
})

function modalDelete() {
    $('.btn-table-action.delete').unbind('click')
    $('.btn-table-action.delete').on('click', function(){
        $('#deleteId').val($(this).data('id'))
        $('#deleteNik').val($(this).data('nik'))
        $('#delete-warning-message').html('Hapus karyawan ' + $(this).data('nama') + ' ?')
    })
}

$('#btn-edit-karyawan').on('click', function(){
    if ($('#editNama').val().length == 0) {
        alert('Masukkan nama')
    }else if ($('#editTelepon').val().length == 0) {
        alert('Masukkan telepon')
    }else if ($('#editDivisi').val().length == 0) {
        alert('Pilih divisi')
    }else{
        $('#btn-edit-karyawan').attr('disabled', true)

        let data = {
            "id": $('#editId').val(),
            "nik": $("#editNik").val(),
            "nama": $('#editNama').val(),
            "telepon": $('#editTelepon').val(),
            "divisi": $('#editDivisi').val(),
        }

        ajaxRequest.post({
            "url": "/admin/karyawan/update",
            "data": data
        }).then(function(result){
            $('#btn-edit-karyawan').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            $('#modalEdit').modal('hide')
            getKaryawanData()
        })
    }
})

$('#btn-delete-karyawan').on('click', function(){
    $(this).attr('disabled', 'disabled')

    let data = {
        "id": $('#deleteId').val(),
        "nik": $('#deleteNik').val()
    }

    ajaxRequest.post({
        "url": "/admin/karyawan/delete",
        "data": data
    }).then(function(result){
        $('#btn-delete-karyawan').removeAttr('disabled')
        toastr.option = {
            "timeout": "5000"
        }
        toastr["success"](result.message)
        $('#modalDelete').modal('hide')
        getKaryawanData()
    })
})