
getAbsenHistory()

function getAbsenHistory() {
    ajaxRequest.get({
        "url": "/user/absensi/get"
    }).then(function(result){
        $('#riwayat-absensi').empty()
        if (result.length == 0) {
            $('#riwayat-absensi').html(`<div class="loader">
                                            <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                            <h5 style="margin-top: 2.5rem">Belum ada riwayat absen</h5>
                                        </div>`)
        }else{
            $.each(result, function(i, v){
                let absenStatus = ``
                if (v.status == "absen") {
                    absenStatus = absenStatus + `<div class="absensi-status tepat-waktu">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Tepat Waktu</span>
                                                </div>`
                }else if(v.status == "terlambat"){
                    absenStatus = absenStatus + `<div class="absensi-status terlambat">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <span>Terlambat</span>
                                                </div>`
                }else if(v.status == "cuti"){
                    absenStatus = absenStatus + `<div class="absensi-status cuti">
                                                    <i class="fas fa-info-circle"></i>
                                                    <span>Cuti</span>
                                                </div>`
                }else if(v.status == "izin"){
                    absenStatus = absenStatus + `<div class="absensi-status cuti">
                                                    <i class="fas fa-info-circle"></i>
                                                    <span>Izin</span>
                                                </div>`
                }
    
                $('#riwayat-absensi').append(`<div class="riwayat-absensi">
                                                <div class="absensi-img" style="background-image: url(${v.foto}); cursor: pointer" onclick="viewImageFullWidth('${v.foto}')"></div>
                                                <div class="absensi-info">
                                                    <p>${v.tanggal}</p>
                                                    <span>${v.catatan}</span>
                                                </div>
                                                ${absenStatus}
                                            </div>`)
            })
        }
    })
}

let camera = document.querySelector('#video')
let picture = document.querySelector('#picture')
let context = picture.getContext('2d')
let localStream

$('.btn-absen').on('click', function(){
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia

    if (navigator.getUserMedia) {
        navigator.getUserMedia({
            video: true
        }, streamWebCam, throwError)
    }
})

function streamWebCam(stream) {
    localStream = stream
    camera.srcObject = stream
    camera.play()
}

function throwError(e) {
    $('#modalAbsen').modal('hide')
}

$('#modalAbsen').on('hidden.bs.modal', function(){
    camera.pause()
    camera.src = ""
    localStream.getTracks()[0].stop()
})

$('#btn-take').on('click', function(){
    picture.width = camera.clientWidth
    picture.height = camera.clientHeight
    context.drawImage(camera, 0, 0)

    camera.pause()
    camera.src = ""
    localStream.getTracks()[0].stop()

    $('#video').hide()
    $('#btn-take').hide()

    $('#picture').show()
    $('#btn-retake').show()
    $('.btn-submit-absen').show()
})

$('#btn-retake').on('click', function(){
    navigator.getUserMedia({
        video: true
    }, streamWebCam, throwError)

    $('#picture').hide()
    $('#btn-retake').hide()
    $('.btn-submit-absen').hide()

    $('#video').show()
    $('#btn-take').show()
})

$('.btn-submit-absen').on('click', function(){
    $('#absen-action').html(`<div class="loader">
                                <div class="loader4"></div>
                                <h5 style="margin-top: 2.5rem">Submitting</h5>
                            </div>`)

    let picUrl = picture.toDataURL()
    ajaxRequest.post({
        "url": "/user/absensi/submit",
        "data": {
            "img": picUrl
        }
    }).then(function(result){
        $('#absen-action').empty()
        toastr.option = {
            "timeout": "5000"
        }
        toastr["success"](result.message)
        $('#modalAbsen').modal('hide')
        getAbsenHistory()
        $('#status-absen-today').html(`<div class="alert alert-success absen-status" role="alert">
                                            <i class="fas fa-check-circle"></i>
                                            <div class="message">
                                                <p>Anda sudah melakukan absen hari ini</p>
                                                <span>${result.tanggal}</span><br>
                                                <span>${result.catatan}</span>
                                            </div>
                                        </div>`)
    })
})

let oldImg = ''
let oldName = ''
let oldTelp = ''

$('#modalEditProfil').on('show.bs.modal', function(){
    oldImg = $('#editImgView').data('image')
    oldName = $('#nama').val()
    oldTelp = $('#telepon').val()
})

$('#modalEditProfil').on('hide.bs.modal', function(){
    $('#editImgView').css('background-image', `url(${oldImg})`)
    $('#nama').val(oldName)
    $('#telepon').val(oldTelp)
})

$('#btn-choose-img').on('click', function(){
    $('#editImgInput').click()
})

$('#editImgInput').on('change', function(){
    let fileObj = this.files[0]
    let fileReader = new FileReader()
    fileReader.readAsDataURL(fileObj)
    fileReader.onload = function(){
        let result = fileReader.result
        $('#editImgView').css('background-image', `url(${result})`)
    }
})

$('#btn-save-profile').on('click', function(){
    if ($('#nama').val().length == 0) {
        alert('Nama tidak boleh kosong')
    }else if($('#telepon').val().length == 0){
        alert('Telepon tidak boleh kosong')
    }else{
        $('#btn-save-profile').attr('disabled', true)

        let foto = null
        if (document.querySelector('#editImgInput').files.length != 0) {
            let file = document.querySelector('#editImgInput').files[0]
            let reader = new FileReader()
            reader.readAsDataURL(file)
            reader.onload = function(){
                foto = reader.result
                let params = {
                    "foto": foto,
                    "nama": $('#nama').val(),
                    "telepon": $('#telepon').val()
                }
                updateProfile(params)
            }
        }else{
            let params = {
                "foto": foto,
                "nama": $('#nama').val(),
                "telepon": $('#telepon').val()
            }
            updateProfile(params)
        }
    }
})

function updateProfile(params) {
    ajaxRequest.post({
        "url": "/user/profile/update",
        "data": params
    }).then(function(result){
        $('#btn-save-profile').removeAttr('disabled')
        $('#user-picture').css('background-image', `url(${result.img})`)
        $('#user-name').val(result.name)
        $('#user-telepon').val(result.telepon)

        oldImg = result.img
        oldName = result.name
        oldTelp = result.telepon

        toastr.option = {
            "timeout": "5000"
        }
        toastr["success"]("Profil berhasil di update")
        
        $('#modalEditProfil').modal('hide')
    })
}