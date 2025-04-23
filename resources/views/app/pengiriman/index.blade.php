@extends('main.index')
@section('content')
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb text-right"> 
                    <li><a href="{{ route('pengirimanNota') }}" class="btn btn-outline-primary">Nota Pengiriman</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Data Pengiriman</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Kirim</th>
                        <th>Nama User</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengiriman as $p)
                        <tr onclick="window.location='{{ route('pengirimanDetail', $p->id_kirim) }}'">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->kode_kirim }}</td>
                            <td>{{ $p->user->nama }}</td>
                            <td>{{ $p->tujuan }}</td>
                            <td><span class="btn btn-outline-warning">{{$p->status}}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
