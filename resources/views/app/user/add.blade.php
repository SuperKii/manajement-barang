@extends('main.index')
@section('content')
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Data User</h5>
                {{-- <small class="text-muted float-end">Tambah</small> --}}
            </div>
            {{-- @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible mx-4" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}
            <div class="card-body">
                <form action="{{ route('userStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" name="nama"
                                placeholder="Nama" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="basic-default-name" name="email"
                                placeholder="Email" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" name="password"
                                placeholder="Password" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Role</label>
                        <div class="col-sm-10">
                            <select name="role" id="" class="form-control">
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">No Hp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" name="no_hp"
                                placeholder="No Hp" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" name="alamat"
                                placeholder="alamat" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="basic-default-name" name="foto_profile"/>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection