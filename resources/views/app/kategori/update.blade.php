@extends('main.index')
@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Data Kategori</h5>
                {{-- <small class="text-muted float-end">Tambah</small> --}}
            </div>
            {{-- @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible mx-4" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
            <div class="card-body">
                <form action="{{ route('kategoriUpdate',$kategoriEdit->id_kategori) }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" name="nama_kategori"
                                placeholder="Nama Kategori" value="{{$kategoriEdit->nama_kategori}}"/>
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
