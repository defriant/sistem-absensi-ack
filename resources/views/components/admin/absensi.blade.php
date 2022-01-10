@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- RECENT PURCHASES -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Absensi</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-lg-6">
                        <p>Tanggal</p>
                        <input type="text" id="tanggal" class="form-control date-picker" value="{{ date('Y-m-d') }}" readonly>
                        <br>
                        <p>Divisi</p>
                        <select class="form-control" id="divisi">
                                <option value="all">Semua divisi</option>
                            @foreach ($divisi as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                        <br>
                        <button class="btn btn-primary" id="btn-search-absensi">Search</button>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12" id="absensi-table">
                        <div class="loader">
                            <div class="loader4"></div>
                            <h5 style="margin-top: 2.5rem">Loading data</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END RECENT PURCHASES -->
    </div>
</div>
@endsection