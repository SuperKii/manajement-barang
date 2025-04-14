@extends('main.index')
@section('content')
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="{{ route('penerimaanNota') }}" class="btn btn-outline-primary">Nota Penerimaan</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Data Penerimaan</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Terima</th>
                        <th>Nama User</th>
                        <th>Asal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penerimaan as $p)
                        <tr onclick="window.location='{{ route('penerimaanDetail', $p->id_terima) }}'">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->kode_terima }}</td>
                            <td>{{ $p->user->nama }}</td>
                            <td>{{ $p->asal }}</td>
                            <td><span class="btn btn-outline-warning">{{ $p->status }}</span></td>
                        </tr>
                    @endforeach
                    </a>
                </tbody>
            </table>
        </div>
    </div>
@endsection
