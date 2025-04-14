@extends('main.index')
@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4">Data Kategori</h4> --}}
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="{{ route('userAdd') }}" class="btn btn-outline-primary">Add User</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Data Barang</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->nama }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role }}</td>
                            <td><img src="/foto_profile/{{ $u->foto_profile }}" alt="" style="width: 50px; height: 50px;"></td>
                            <td>
                                <a href="{{ route('userEdit', $u->id_user) }}" class="btn btn-icon btn-outline-primary">
                                    <i class='bx bx-edit-alt'></i>
                                </a>

                                <a href="{{ route('userDelete', $u->id_user) }}" class="btn btn-icon btn-outline-danger"
                                    onclick="return confirm('apakah anda yakin?')">
                                    <i class='bx bx-trash'></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
