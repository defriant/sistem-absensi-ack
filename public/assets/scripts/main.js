$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

class requestData {
    post(params){
        let url = params.url
        let data = params.data

        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'POST',
                url: url,
                dataType: "json",
                contentType: 'application/json',
                data: JSON.stringify(data),
                success:function(result){
                    resolve(result)
                },
                error:function(result){
                    alert('Oops! Something went wrong ..')
                }
            })
        })
    }

    get(params){
        let url = params.url

        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: "json",
                contentType: 'application/json',
                success:function(result){
                    resolve(result)
                },
                error:function(result){
                    alert('Oops! Something went wrong ..')
                }
            })
        })
    }
}

const ajaxRequest = new requestData()


$('.date-picker').datetimepicker({
    timepicker: false,
    minDate: 'today',
    format: 'Y-m-d'
})

$('.date-picker-2').datetimepicker({
    timepicker: false,
    format: 'Y-m-d'
})

$('.time-picker').datetimepicker({
    datepicker: false,
    timepicker: true,
    format: 'H:i'
})

$('#btn-change-password').on('click', function(){
    if ($('#old-pass').val().length == 0) {
        alert("Masukkan password lama")
    }else if ($('#new-pass').val().length == 0) {
        alert("Masukkan password baru")
    }else if ($('#confirm-pass').val().length == 0) {
        alert("Masukkan konfirmasi password")
    }else if ($('#new-pass').val() !== $('#confirm-pass').val()) {
        alert("Password baru dan konfirmasi password tidak sesuai")
    }else{
        $('#btn-change-password').attr('disabled', true)

        let params = {
            "oldPass": $('#old-pass').val(),
            "newPass": $('#new-pass').val()
        }

        ajaxRequest.post({
            "url": "/user/change-password",
            "data": params
        }).then(function(result){
            if (result.response == "success") {
                $('#btn-change-password').removeAttr('disabled')
                toastr.option = {
                    "timeout": "5000"
                }
                toastr["success"](result.message)
                $('#old-pass').val('')
                $('#new-pass').val('')
                $('#confirm-pass').val('')
                $('#modalChangePassword').modal('hide')
            }else if(result.response == "failed"){
                alert(result.message)
                $('#btn-change-password').removeAttr('disabled')
            }
        })
    }
})

function tes(params) {
    console.log("tes");
}

function viewImageFullWidth(params) {
    let imageViewFullWidth = document.querySelector('.image-view-full-width')
    let imageView = document.querySelector('.image-view-full-width .image-view')
    let closeImageViewFullWidth = document.querySelector('.image-view-full-width-close')

    imageView.setAttribute("src", params)

    closeImageViewFullWidth.addEventListener('click', function(){
        imageViewFullWidth.classList.remove('show-view')
    })

    imageViewFullWidth.classList.add('show-view')
    imageViewFullWidth.addEventListener('click', function(e){
        if (!imageView.contains(e.target)) {
            imageViewFullWidth.classList.remove('show-view')
        }
    })
}

