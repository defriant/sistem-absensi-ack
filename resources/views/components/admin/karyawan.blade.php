@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- RECENT PURCHASES -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Karyawan</h3>
                <div class="right">
                    <button type="button" data-toggle="modal" data-target="#modalInput"><i class="far fa-plus"></i>&nbsp; Tambah Karyawan</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" id="karyawan-table">
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

<div class="modal fade" id="modalInput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah Karyawan</h4>
            </div>
            <div class="modal-body">
                <p>NIK</p>
                <input type="text" id="addNik" class="form-control">
                <br>
                <p>Nama</p>
                <input type="text" id="addNama" class="form-control">
                <br>
                <p>Telepon</p>
                <input type="text" id="addTelepon" class="form-control">
                <br>
                <p>Divisi</p>
                <select class="form-control" id="addDivisi">
                        <option></option>
                    @foreach ($divisi as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-add-user">Tambah</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Karyawan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId">
                <p>NIK</p>
                <input type="text" id="editNik" class="form-control" readonly>
                <br>
                <p>Nama</p>
                <input type="text" id="editNama" class="form-control">
                <br>
                <p>Telepon</p>
                <input type="text" id="editTelepon" class="form-control">
                <br>
                <p>Divisi</p>
                <select class="form-control" id="editDivisi">
                    <option></option>
                    @foreach ($divisi as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-edit-karyawan">Simpan</button>
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
                <input type="hidden" id="deleteNik">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-karyawan">Hapus</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection