getDivisiData()

function getDivisiData() {
    ajaxRequest.get({
        "url": "/admin/divisi/get"
    }).then(function(result){
        let divisiData = ``

        let no = 1
        $.each(result.data, function(i, v){
            divisiData = divisiData + `<tr>
                                            <td>${no}</td>
                                            <td>${v.nama}</td>
                                            <td>${v.jam_masuk}</td>
                                            <td>${v.jam_keluar}</td>
                                            <td>
                                                <button class="btn-table-action edit" data-toggle="modal" data-target="#modalEdit" 
                                                    data-id="${v.id}"
                                                    data-nama="${v.nama}"
                                                    data-jm="${v.jam_masuk}"
                                                    data-jk="${v.jam_keluar}"><i class="fas fa-cog"></i>
                                                </button>
                                                &nbsp;
                                                <button class="btn-table-action delete" data-toggle="modal" data-target="#modalDelete"
                                                    data-id="${v.id}"
                                                    data-nama="${v.nama}"><i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>`
            no = no + 1
        })

        $('#divisi-data').empty()
        $('#divisi-data').html(divisiData)

        modalEdit()
        modalDelete()
    })
}

$('#btn-add-divisi').on('click', function(){
    if ($('#addNama').val().length == 0) {
        alert('Masukkan nama divisi')
    }else if ($('#addJm').val().length == 0) {
        alert('Masukkan jam masuk')
    }else if ($('#addJk').val().length == 0) {
        alert('Masukkan jam keluar')
    }else{
        $(this).attr('disabled', 'disabled')

        let data = {
            "nama": $('#addNama').val(),
            "jam_masuk": $('#addJm').val(),
            "jam_keluar": $('#addJk').val()
        }

        ajaxRequest.post({
            "url": "/admin/divisi/add",
            "data": data
        }).then(function(result){
            $('#btn-add-divisi').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            $('#modalInput').modal('hide')
            $('#addNama').val('')
            $('#addJm').val('')
            $('#addJk').val('')
            getDivisiData()
        })
    }
})

function modalEdit() {
    $('.btn-table-action.edit').unbind('click')
    $('.btn-table-action.edit').on('click', function(){
        $('#editId').val($(this).data('id'))
        $('#editNama').val($(this).data('nama'))
        $('#editJm').val($(this).data('jm'))
        $('#editJk').val($(this).data('jk'))
    })
}

function modalDelete() {
    $('.btn-table-action.delete').unbind('click')
    $('.btn-table-action.delete').on('click', function(){
        $('#deleteId').val($(this).data('id'))
        $('#delete-warning-message').html('Hapus divisi ' + $(this).data('nama') + ' ?')
    })
}

$('#btn-edit-divisi').on('click', function(){
    if ($('#editNama').val().length == 0) {
        alert('Masukkan nama divisi')
    }else if ($('#editJm').val().length == 0) {
        alert('Masukkan jam masuk')
    }else if ($('#editJk').val().length == 0) {
        alert('Masukkan jam keluar')
    }else{
        $(this).attr('disabled', 'disabled')

        let data = {
            "id": $('#editId').val(),
            "nama": $('#editNama').val(),
            "jam_masuk": $('#editJm').val(),
            "jam_keluar": $('#editJk').val()
        }

        ajaxRequest.post({
            "url": "/admin/divisi/update",
            "data": data
        }).then(function(result){
            $('#btn-edit-divisi').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            $('#modalEdit').modal('hide')
            getDivisiData()
        })
    }
})

$('#btn-delete-divisi').on('click', function(){
    $(this).attr('disabled', 'disabled')

    let data = {
        "id": $('#deleteId').val()
    }

    ajaxRequest.post({
        "url": "/admin/divisi/delete",
        "data": data
    }).then(function(result){
        $('#btn-delete-divisi').removeAttr('disabled')
        toastr.option = {
            "timeout": "5000"
        }
        toastr["success"](result.message)
        $('#modalDelete').modal('hide')
        getDivisiData()
    })
})
