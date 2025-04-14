@extends('main.index')
@section('content')
    <h4 class="fw-bold py-3 mb-4">Nota Penerimaan</h4>
    <div class="col-sm-12 mb-4">
        <div class="page-header">
            <div class="page-title">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addBarang">
                    Add Barang
                </button>
            </div>
        </div>
    </div>
    <form action="{{ route('penerimaanStore') }}" method="POST">
        @csrf
        <div class="card">
            <h5 class="card-header">Data Barang</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nota as $n)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $n->barang->nama_barang }}</td>
                                <td><input type="number" value="{{ $n->jumlah }}" class="form-control" style="width: 120px"></td>
                                <td>{{ $n->barang->satuan }}</td>
                                <td>
                                    <a href="{{ route('notaDestroy', $n->id_nota) }}" class="btn btn-icon btn-outline-danger"
                                        onclick="return confirm('apakah anda yakin?')">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </td>
                            </tr>

                            <input type="hidden" name="barang_id[]" value="{{ $n->barang->id_barang }}">
                            <input type="hidden" name="jumlah[]" value="{{ $n->jumlah }}">
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-4">
            {{-- @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible mx-4" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Asal Pengirim</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name" name="asal"
                            placeholder="Asal Pengirim" />
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>






    <div class="modal fade" id="addBarang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('notaStore') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Barang</label>
                                <select name="barang_id" id="barang">
                                    @foreach ($barang as $b)
                                        <option value="{{ $b->id_barang }}">{{ $b->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Jumlah</label>
                                <input type="number" id="nameWithTitle" name="jumlah" class="form-control"
                                    placeholder="Enter Jumlah" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#barang", {
                create: false, // Nonaktifkan fitur tagging
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Pilih Barang",
                allowEmptyOption: true
            });
        });
    </script>
@endsection
