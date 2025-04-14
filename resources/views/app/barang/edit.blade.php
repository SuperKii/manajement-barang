@extends('main.index')
@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Update Data Barang</h5>
                {{-- <small class="text-muted float-end">Tambah</small> --}}
            </div>
            {{-- @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible mx-4" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}
            <div class="card-body">
                <form action="{{ route('barangUpdate', $barangEdit->id_barang) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" name="nama_barang"
                                placeholder="Nama Barang" value="{{ $barangEdit->nama_barang }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Kategori Barang</label>
                        <select name="kategori_id" id="" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id_kategori }}"@if ($k->id_kategori == $barangEdit->kategori_id) selected @endif>
                                    {{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Stok</label>
                        <div class="col-sm-10">
                            <input type="text" disabled class="form-control" id="basic-default-name" name="stok"
                                placeholder="Stok" value="{{ $barangEdit->stok }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Satuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name"
                                value="{{ $barangEdit->satuan }}" name="satuan" placeholder="Satuan" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Foto Barang</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="basic-default-name" name="foto_barang" />
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
