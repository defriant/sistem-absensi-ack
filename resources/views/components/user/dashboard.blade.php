@extends('layouts.user')
@section('content')
<div class="panel panel-profile">
    <div class="clearfix">
        <div class="profile-left">
            <div class="profile-header">
                <div class="overlay"></div>
                <div class="profile-main">
                    <div style="background-image: url({{ Auth::user()->karyawan->foto }})" id="user-picture"></div>
                    <h3 class="name" id="user-name">{{ Auth::user()->name }}</h3>
                </div>
            </div>

            <div class="profile-detail">
                <div class="profile-info">
                    <h4 class="heading">Informasi Pengguna</h4>
                    <ul class="list-unstyled list-justify">
                        <li>NIK <span>{{ Auth::user()->karyawan->nik }}</span></li>
                        <li>Telepon <span id="user-telepon">{{ Auth::user()->karyawan->telepon }}</span></li>
                        <li>Divisi <span>{{ (Auth::user()->karyawan->divisi_id == null) ? "Tidak ada divisi" : Auth::user()->karyawan->divisi->nama}}</span></li>
                    </ul>
                </div>
                <div class="text-center"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalEditProfil">Edit Profile</a></div>
            </div>
        </div>
        
        <div class="profile-right">
            <h4 class="heading">Absensi</h4>
            <div class="awards">
                <div class="row">
                    <div class="col-md-12" id="status-absen-today">
                        @if ($status_absen != null)
                            @if ($status_absen->status == "cuti")
                                <div class="alert alert-info absen-status" role="alert">
                                    <i class="fas fa-info-circle"></i>
                                    <div class="message">
                                        <p>Cuti</p>
                                        <span>{{ date('d F Y') }}</span><br>
                                        <span>{{ $status_absen->catatan }}</span>
                                    </div>
                                </div>
                            @elseif ($status_absen->status == "izin")
                                <div class="alert alert-info absen-status" role="alert">
                                    <i class="fas fa-info-circle"></i>
                                    <div class="message">
                                        <p>Izin</p>
                                        <span>{{ date('d F Y') }}</span><br>
                                        <span>{{ $status_absen->catatan }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success absen-status" role="alert">
                                    <i class="fas fa-check-circle"></i>
                                    <div class="message">
                                        <p>Anda sudah melakukan absen hari ini</p>
                                        <span>{{ date('d F Y') }}</span><br>
                                        <span>{{ $status_absen->catatan }}</span>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if (Auth::user()->karyawan->divisi_id == null)
                                <div class="alert alert-danger absen-status" role="alert">
                                    <i class="fas fa-times-circle"></i>
                                    <div class="message">
                                        <p>Tidak dapat melakukan absen, divisi anda belum ditentukan !</p>
                                        <span>{{ date('d F Y') }}</span><br>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info absen-status" role="alert">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <div class="message">
                                        <p>Anda belum melakukan absen hari ini</p>
                                        <span>{{ date('d F Y') }}</span><br>
                                        <span>Absen sebelum pukul {{ Auth::user()->karyawan->divisi->jam_masuk }}</span>
                                    </div>
                                    <button class="btn-absen" data-toggle="modal" data-target="#modalAbsen">Absen sekarang</button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                {{-- <div class="text-center"><a href="#" class="btn btn-default">See all awards</a></div> --}}
            </div>
            <!-- END AWARDS -->
            <!-- TABBED CONTENT -->
            <h4 class="heading">Riwayat Absensi</h4>
            <div id="riwayat-absensi">
                <div class="loader">
                    <div class="loader4"></div>
                    <h5 style="margin-top: 2.5rem">Loading data</h5>
                </div>
            </div>
            <!-- END TABBED CONTENT -->
        </div>
        <!-- END RIGHT COLUMN -->
    </div>
</div>

<div class="modal fade" id="modalAbsen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-absen">
            <div class="modal-body text-center">
                <video id="video"></video>
                <canvas id="picture" style="display: none"></canvas>
                <br>
                <div id="absen-action">
                    <button class="btn-camera" id="btn-take"><i class="far fa-camera"></i></button>
                    <button class="btn-camera" id="btn-retake" style="display: none"><i class="far fa-undo"></i></button>
                    <br><br>
                    <p>Absen {{ date('d F Y') }}</p>
                    <br>
                    <button type="button" class="btn-submit-absen"><i class="fas fa-fingerprint"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Profil</h4>
            </div>
            <div class="modal-body">
                <div class="edit-img">
                    {{-- <img src="{{ Auth::user()->karyawan->foto }}" id="editImgView"> --}}
                    <div style="background-image: url({{ Auth::user()->karyawan->foto }})" data-image="{{ Auth::user()->karyawan->foto }}" id="editImgView"></div>
                    <input type="file" id="editImgInput">
                    <br>
                    <button class="btn btn-primary" id="btn-choose-img">Choose file</button>
                </div>
                <hr>
                <p>Nama lengkap</p>
                <input type="text" id="nama" class="form-control" value="{{ Auth::user()->name }}">
                <br>
                <p>Telepon</p>
                <input type="text" id="telepon" class="form-control" value="{{ Auth::user()->karyawan->telepon }}">
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save-profile">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection