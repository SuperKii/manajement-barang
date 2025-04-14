@extends('main.index')
@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4">Data Kategori</h4> --}}
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb text-right"> 
                    <li><a href="{{ route('kategoriAdd') }}" class="btn btn-outline-primary">Add Kategori</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Data Kategori</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kategori }}</td>
                            <td>
                                <a href="{{ route('kategoriEdit', $k->id_kategori) }}" class="btn btn-icon btn-outline-primary">
                                    <i class='bx bx-edit-alt'></i>
                                </a>

                                <a href="{{ route('kategoriDelete', $k->id_kategori) }}" class="btn btn-icon btn-outline-danger"
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
