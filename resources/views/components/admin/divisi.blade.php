@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-8">
        <!-- RECENT PURCHASES -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Divisi</h3>
                <div class="right">
                    <button type="button" data-toggle="modal" data-target="#modalInput"><i class="far fa-plus"></i>&nbsp; Tambah Divisi</button>
                </div>
            </div>
            <div class="panel-body">
                <table class="table" id="table-penjualan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Divisi</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="divisi-data">
                        <tr>
                            <td><span class="loading">1</span></td>
                            <td><span class="loading">January 2020</span></td>
                            <td><span class="loading">977</span></td>
                            <td><span class="loading">292</span></td>
                            <td><span class="loading">685</span></td>
                        </tr>
                        <tr>
                            <td><span class="loading">1</span></td>
                            <td><span class="loading">January 2020</span></td>
                            <td><span class="loading">977</span></td>
                            <td><span class="loading">292</span></td>
                            <td><span class="loading">685</span></td>
                        </tr>
                    </tbody>
                </table>
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
                <h4 class="modal-title" id="myModalLabel">Tambah Divisi</h4>
            </div>
            <div class="modal-body">
                <p>Nama Divisi</p>
                <input type="text" id="addNama" class="form-control">
                <br>
                <p>Jam Masuk</p>
                <input type="text" id="addJm" class="form-control time-picker" readonly>
                <br>
                <p>Jam Keluar</p>
                <input type="text" id="addJk" class="form-control time-picker" readonly>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-add-divisi">Tambah</button>
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
                <h4 class="modal-title" id="myModalLabel">Edit Divisi</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId" class="form-control">
                <p>Nama Divisi</p>
                <input type="text" id="editNama" class="form-control">
                <br>
                <p>Jam Masuk</p>
                <input type="text" id="editJm" class="form-control time-picker" readonly>
                <br>
                <p>Jam Keluar</p>
                <input type="text" id="editJk" class="form-control time-picker" readonly>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-edit-divisi">Simpan</button>
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
                    <button type="button" class="btn btn-danger" id="btn-delete-divisi">Hapus</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection