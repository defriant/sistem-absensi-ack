getAbsensi()

function getAbsensi() {
    let params = {
        "tanggal": $('#tanggal').val(),
        "divisi": $('#divisi').val()
    }

    ajaxRequest.post({
        "url": "/admin/divisi/get",
        "data": params
    }).then(function(result){
        $('#absensi-table').html(`<table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Divisi</th>
                                                <th>Jam Masuk</th>
                                                <th>Status Absen</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody id="absensi-data">
                                            
                                        </tbody>
                                    </table>`)

        let absensiData = ``
        $.each(result, function(i, v){
            if (v.absen == true) {
                let absenStatus = ``
                if (v.status == "absen") {
                    absenStatus = absenStatus + `<div class="absensi-status-table tepat-waktu">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Tepat Waktu</span>
                                                </div>`
                }else if(v.status == "terlambat"){
                    absenStatus = absenStatus + `<div class="absensi-status-table terlambat">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <span>Terlambat</span>
                                                </div>`
                }else if(v.status == "cuti"){
                    absenStatus = absenStatus + `<div class="absensi-status-table cuti">
                                                    <i class="fas fa-info-circle"></i>
                                                    <span>Cuti</span>
                                                </div>`
                }else if(v.status == "izin"){
                    absenStatus = absenStatus + `<div class="absensi-status-table cuti">
                                                    <i class="fas fa-info-circle"></i>
                                                    <span>Izin</span>
                                                </div>`
                }

                absensiData = absensiData + `<tr>
                                            <td class="user-data-img" style="width: 130px">
                                                <div style="background-image: url(${v.foto}); cursor: pointer" onclick="viewImageFullWidth('${v.foto}')"></div>
                                            </td>
                                            <td class="user-data">${v.nik}</td>
                                            <td class="user-data">${v.nama}</td>
                                            <td class="user-data">${v.divisi}</td>
                                            <td class="user-data">${v.jam_masuk}</td>
                                            <td class="user-data">
                                                ${absenStatus}
                                            </td>
                                            <td class="user-data">${v.catatan}</td>
                                        </tr>`
            }else if (v.absen == false) {
                absensiData = absensiData + `<tr>
                                                <td class="user-data-img" style="width: 130px">
                                                    <div style="background: #fff"></div>
                                                </td>
                                                <td class="user-data">${v.nik}</td>
                                                <td class="user-data">${v.nama}</td>
                                                <td class="user-data">${v.divisi}</td>
                                                <td class="user-data">${v.jam_masuk}</td>
                                                <td class="user-data">
                                                    <div class="absensi-status-table belum-absen">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>Belum Absen</span>
                                                    </div>
                                                </td>
                                                <td class="user-data">-</td>
                                            </tr>`
            }
        })

        $('#absensi-data').html(absensiData)
        $('#btn-search-absensi').removeAttr('disabled')
    })
}

$('#btn-search-absensi').on('click', function(){
    $('#btn-search-absensi').attr('disabled', true)
    getAbsensi()
})