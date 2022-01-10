@extends('layouts.admin')
@section('content')
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">Sistem Absensi</h3>
        <p class="panel-subtitle">{{ date('d F Y') }}</p>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="metric">
                    <span class="icon"><i class="fas fa-line-columns"></i></span>
                    <p>
                        <span class="number" style="margin-bottom: .5rem">{{ count($divisi) }}</span>
                        <span class="title" style="font-size: 1.4rem;">Divisi</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric">
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <p>
                        <span class="number" style="margin-bottom: .5rem">{{ count($karyawan) }}</span>
                        <span class="title" style="font-size: 1.4rem;">Karyawan</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel-heading">
                <h3 class="panel-title">Izin hari ini</h3>
            </div>
            <div class="panel-body">
                @if (count($izin) > 0)
                    @foreach ($izin as $izin)
                        <div class="riwayat-absensi">
                            <div class="absensi-img" style="background-image: url({{ $izin->foto }})"></div>
                            <div class="absensi-info">
                                <p>{{ $izin->user->name }}</p>
                                <span>{{ $izin->catatan }}</span>
                            </div>
                            <div class="absensi-status cuti">
                                <i class="fas fa-info-circle"></i>
                                <span>Izin</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="loader">
                        <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                        <h5 style="margin-top: 2.5rem">Tidak ada karyawan izin hari ini</h5>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel-heading">
                <h3 class="panel-title">Cuti hari ini</h3>
            </div>
            <div class="panel-body">
                @if (count($cuti) > 0)
                    @foreach ($cuti as $cuti)
                        <div class="riwayat-absensi">
                            <div class="absensi-img" style="background-image: url({{ $cuti->foto }})"></div>
                            <div class="absensi-info">
                                <p>{{ $cuti->user->name }}</p>
                                <span>{{ $cuti->catatan }}</span>
                            </div>
                            <div class="absensi-status cuti">
                                <i class="fas fa-info-circle"></i>
                                <span>Cuti</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="loader">
                        <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                        <h5 style="margin-top: 2.5rem">Tidak ada karyawan cuti hari ini</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <br><br>
</div>
@endsection