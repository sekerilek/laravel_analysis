@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">HASIL PRODUKSI</h1>

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
                    @endif

                    <a href="{{ route('produksi.create') }}" class="btn btn-success" data-function="tambah">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Data Produksi
                    </a><br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <div class="x_title">
                        <h3>Data Produksi</h3><br>
                    </div>
                    <table class="table table-striped" id="table-produksi">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Produksi</th>
                                <th>Tanggal</th>
                                <th>Barang Produksi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <br><br>

                    <small>*Tekan tombol <b>LIHAT RINCIAN</b> untuk menampilkan rincian data produksi</small>

                    <br><br>
                    <div class="x_title">
                        <h3>Rincian Produksi</h3><br>
                    </div>
                    <table class="table table-striped" id="table-produksi-detail">
                        <thead class="thead-light">
                            <tr>
                                <!-- <th>No.</th> -->
                                <th>Karyawan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
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
        $('#table-produksi').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 3
            }],
            processing: true,
            serverSide: true,
            ajax: "{!! route('produksi.data') !!}",
            columns: [{
                    data: 'KodeProduksi'
                },
                {
                    data: 'TanggalProduksi'
                },
                {
                    data: 'NamaItem'
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

    // function detailProduksi(produksi) {
    //     $('#table-produksi-detail').empty();
    //     var t = $('#table-produksi-detail').DataTable({
    //         "columnDefs": [{
    //             "searchable": false,
    //             "orderable": false,
    //             "targets": 0
    //         }],
    //         "order": [
    //             [1, 'asc']
    //         ],
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             "url": "{!! route('produksi.data.detail') !!}",
    //             "data": {
    //                 "kode": produksi
    //             }
    //         },
    //         columns: [{
    //                 data: 'Nama',
    //                 name: 'Nama'
    //             },
    //             {
    //                 data: 'QtyHasil',
    //                 name: 'QtyHasil'
    //             },
    //             {
    //                 data: 'NamaSatuan',
    //                 name: 'NamaSatuan'
    //             }
    //         ],
    //         destroy: true,
    //         "pageLength": 10
    //     });

    //     t.on('order.dt search.dt', function() {
    //         t.column(0, {
    //             search: 'applied',
    //             order: 'applied'
    //         }).nodes().each(function(cell, i) {
    //             cell.innerHTML = i + 1;
    //         });
    //     }).draw();
    // }

    function detailProduksi(produksi) {
        $('#table-produksi-detail').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                "url": "{!! route('produksi.data.detail') !!}",
                "data": {
                    "kode": produksi
                }
            },
            columns: [{
                    data: 'Nama'
                },
                {
                    data: 'QtyHasil'
                },
                {
                    data: 'NamaSatuan'
                }
            ],
            "order": [],
            "pageLength": 25
        });
    }
</script>
@endpush