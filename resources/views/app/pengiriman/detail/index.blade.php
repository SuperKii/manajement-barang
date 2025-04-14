@extends('main.index')
@section('content')
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <h4 class="fw-bold py-3 mb-4">Detail Pengiriman</h4>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Kode Kirim</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-name" value="{{$data_pengiriman->kode_kirim}}" disabled/>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">User</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-name" value="{{$data_pengiriman->user->nama}}" disabled/>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Tujuan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-name" value="{{$data_pengiriman->tujuan}}" disabled/>
                </div>
            </div>
            <div class="row mb-3">
                <span class="btn btn-primary">{{$data_pengiriman->status}}</span>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Data Detail Pengiriman</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detail as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->kode_kirim_detail }}</td>
                            <td>{{ $d->barang->nama_barang }}</td>
                            <td>{{ $d->jumlah }} {{ $d->barang->satuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
