@extends('main.index')
@section('content')
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb text-right"> 
                    <li><li><span class="btn btn-outline-primary">Verifikasi Penerimaan</span></li></li>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataPenerimaan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->kode_terima }}</td>
                            <td>{{ $p->user->nama }}</td>
                            <td>{{ $p->asal }}</td>
                            <td><span class="btn btn-outline-warning">{{$p->status}}</span></td>
                            <td>
                                <form action="{{route('updatePenerimaan',$p->id_terima)}}" method="POST">
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
