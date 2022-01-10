@extends('layouts.user')
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-10">
        <!-- RECENT PURCHASES -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Pengajuan izin & cuti</h3>
                <div class="right">
                    <button type="button" data-toggle="modal" data-target="#modalInput"><i class="far fa-plus"></i>&nbsp; Buat pengajuan</button>
                </div>
            </div>
            <div class="panel-body" id="pengajuan">
                <div class="loader">
                    <div class="loader4"></div>
                    <h5 style="margin-top: 2.5rem">Loading data</h5>
                </div>
            </div>
        </div>
        <!-- END RECENT PURCHASES -->
    </div>
</div>

<div class="modal fade" id="modalInput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Buat Pengajuan</h4>
            </div>
            <div class="modal-body">
                <p>Tanggal</p>
                <input type="text" id="tanggal" class="form-control date-picker" readonly>
                <br>
                <p>Pengajuan</p>
                <select class="form-control" id="status">
                    <option></option>
                    <option value="cuti">Cuti</option>
                    <option value="izin">Izin</option>
                </select>
                <br>
                <p>Catatan</p>
                <input type="text" id="catatan" class="form-control">
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-add-pengajuan">Buat</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem" id="delete-warning-message"></h4>
                <input type="hidden" id="deleteId">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-pengajuan">Ya</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection