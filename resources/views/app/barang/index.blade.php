@extends('main.index')
@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4">Data Kategori</h4> --}}
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="{{ route('barangAdd') }}" class="btn btn-outline-primary">Add Barang</a></li>
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
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Foto Barang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori->nama_kategori }}</td>
                            <td>{{ $b->stok }}</td>
                            <td>{{ $b->satuan }}</td>
                            <td><img src="/foto_barang/{{ $b->foto_barang }}" alt="" style="width: 50px; height: 50px;"></td>
                            <td>
                                <a href="{{ route('barangEdit', $b->id_barang) }}" class="btn btn-icon btn-outline-primary">
                                    <i class='bx bx-edit-alt'></i>
                                </a>

                                <a href="{{ route('barangDelete', $b->id_barang) }}" class="btn btn-icon btn-outline-danger"
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
