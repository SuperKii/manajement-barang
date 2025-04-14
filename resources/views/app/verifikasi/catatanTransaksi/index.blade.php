@extends('main.index')
@section('content')
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <h4 class="fw-bold py-3 mb-4">Catatan Transaksi</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Data Catatan Transaksi</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Type</th>
                        <th>Kode</th>
                        <th>Nama User</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($catatan_transaksi as $ct)
                        <tr
                            @if ($ct->tipe == 'PENERIMAAN') 
                                @foreach ($ct->penerimaan as $cTerima)
                                    onclick="window.location='{{ route('penerimaanDetail', $cTerima->id_terima) }}'"
                                @endforeach
                            @else 
                                @foreach ($ct->pengiriman as $cKirim)
                                    onclick="window.location='{{ route('pengirimanDetail', $cKirim->id_kirim) }}'"
                                @endforeach
                            @endif style="cursor:pointer;">
                            <td>{{ $loop->iteration }}</td>
                            @if ($ct->tipe == 'PENERIMAAN')
                                <td>{{ $ct->tipe }}</td>
                                @foreach ($ct->penerimaan as $cTerima)
                                    <td>{{ $cTerima->kode_terima }}</td>
                                    <td>{{ $cTerima->user->nama }}</td>
                                    <td>{{ $cTerima->asal }}</td>
                                    <td><span class="btn btn-primary">{{ $cTerima->status }}</span></td>
                                @endforeach
                            @else
                                <td>{{ $ct->tipe }}</td>
                                @foreach ($ct->pengiriman as $cKirim)
                                    <td>{{ $cKirim->kode_kirim }}</td>
                                    <td>{{ $cKirim->user->nama }}</td>
                                    <td>{{ $cKirim->tujuan }}</td>
                                    <td><span class="btn btn-primary">{{ $cKirim->status }}</span></td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
