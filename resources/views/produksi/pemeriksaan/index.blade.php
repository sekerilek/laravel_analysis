@extends('index')
@section('content')
<style type="text/css">
    #black {
        color: black;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">PEMERIKSAAN HASIL PRODUKSI</h1>

                    <!-- Alert -->
                    @if(session()->get('created'))
                    <div class="alert alert-success alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('created') }}
                    </div>

                    @elseif(session()->get('edited'))
                    <div class="alert alert-info alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('edited') }}
                    </div>

                    @elseif(session()->get('deleted'))
                    <div class="alert alert-danger alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('deleted') }}
                    </div>

                    @elseif(session()->get('error'))
                    <div class="alert alert-warning alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b id="black">{{ session()->get('error') }}</b>
                    </div>
                    @endif

                    <a href="{{ url('/pemeriksaanproduksi/create')}}" class="btn btn-success" data-function="tambah">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Pemeriksaan
                    </a><br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <div class="x_title">
                        <h3>Data Produksi</h3><br>
                    </div>
                    <table class="table table-striped" id="table-pemeriksaan">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Produksi</th>
                                <th>Tanggal</th>
                                <th>Barang Produksi</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <br><br>

                    <small>*Tekan tombol <b>LIHAT RINCIAN</b> untuk menampilkan rincian hasil pemeriksaan</small>

                    <br><br>
                    <div class="x_title">
                        <h3>Rincian Pemeriksaan Produksi</h3><br>
                    </div>
                    <table class="table table-striped" id="table-pemeriksaan-detail">
                        <thead class="thead-light">
                            <tr>
                                <!-- <th>No.</th> -->
                                <th>Karyawan</th>
                                <th>Jumlah</th>
                                <th>Jumlah Cek</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#table-pemeriksaan').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 3
            }],
            processing: true,
            serverSide: true,
            ajax: "{!! route('produksi.pemeriksaan.data') !!}",
            columns: [{
                    data: 'KodeProduksi'
                },
                {
                    data: 'TanggalCek'
                },
                {
                    data: 'NamaItem'
                },
                {
                    data: 'Keterangan'
                },
                {
                    data: 'action'
                }
            ],
            "order": [],
            "pageLength": 10
        });
    });

    function showConfirm() {
        if (confirm("Apakah anda yakin ingin menghapus data ini?")) {

        } else {
            return false;
        }
    }

    function detailPemeriksaan(produksi) {
        $('#table-pemeriksaan-detail').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                "url": "{!! route('produksi.pemeriksaan.detail') !!}",
                "data": {
                    "kode": produksi
                }
            },
            columns: [{
                    data: 'Nama'
                },
                {
                    data: 'Qty'
                },
                {
                    data: 'QtyCek'
                },
                {
                    data: 'NamaSatuan'
                },
                {
                    data: 'Keterangan'
                }
            ],
            "order": [],
            "pageLength": 25
        });
    }
</script>
@endpush