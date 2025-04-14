@extends('main.index')
@section('content')
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb text-right"> 
                    <li><span class="btn btn-outline-primary">Verifikasi Pengiriman</span></li>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataPengiriman as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->kode_kirim }}</td>
                            <td>{{ $p->user->nama }}</td>
                            <td>{{ $p->tujuan }}</td>
                            <td><span class="btn btn-outline-warning">{{$p->status}}</span></td>
                            <td>
                                <form action="{{route('updatePengiriman',$p->id_kirim)}}" method="POST">
                                    @csrf
                                    <button type="submit" value="VERIFIED" onclick="return confirm('apakah anda yakin??')" name="status" class="btn btn-icon btn-outline-success">
                                        <i class='bx bx-check'></i>
                                    </button>
                                    <button type="submit" value="REJECTED" onclick="return confirm('apakah anda yakin??')" name="status" class="btn btn-icon btn-outline-danger">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
