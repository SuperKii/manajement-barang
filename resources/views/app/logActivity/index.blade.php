@extends('main.index')
@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4">Data Aktivitas User</h4> --}}
    <div class="card">
        <h5 class="card-header">Data Aktivitas</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataLogActivity as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $l->user->nama }}</td>
                            <td>{{ $l->aksi }}</td>
                            <td><div style="white-space: pre-wrap;">{{ $l->deskripsi }}</div></td>
                            <td>{{ $l->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="" class="btn btn-icon btn-outline-danger"
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
