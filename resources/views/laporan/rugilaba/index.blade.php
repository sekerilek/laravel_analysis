@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Laporan Rugi Laba</h1><br>
                </div>

                <div id="filterlaporan">
                    <div class="row">
                        <div class="x_content">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Awal: </label>
                                    <div class="input-group" id="date1">
                                        <input type="text" class="form-control" id="tanggal1" value="{{date('d-m-Y')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Akhir: </label>
                                    <div class="input-group" id="date2">
                                        <input type="text" class="form-control" id="tanggal2" value="{{date('d-m-Y')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Jenis Laporan: </label>
                                    <select class="form-control" id="jenisLaporan">
                                        <option value="suratjalan">Surat Jalan</option>
                                        <option value="kasir">Kasir</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Buat Laporan</label>
                                    <div class="input-group">
                                        <input type="hidden" id="opsiFilter" value="">
                                        <button class="btn btn-md btn-block btn-success" id="buttonFilter">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="x_body">
                    <div class="x_title">
                        <h3>Laporan</h3><br>
                    </div>
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>No Nota</th>
                                <th>Tgl Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Total Profit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="x_title">
                        <h3>Detail Laporan</h3><br>
                    </div>
                    <table class="table table-light" id="table2">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Sub Total</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(function() {
    if ($('body').has('[data-function]')) {
        $('[data-function]').each(function() {
            initPage('{{Auth::user()->name}}', $(this).data('function'));
        });
    }
    else {
        initPage('{{Auth::user()->name}}');
    }
});

$('#date1').datetimepicker({
    format: 'DD-MM-YYYY'
});

$('#date2').datetimepicker({
    defaultDate: new Date(),
    format: 'DD-MM-YYYY'
});

$("#tanggal1").on("dp.change", function(e) {
    $(this).attr('value', $("#tanggal1").val());
});

$("#tanggal2").on("dp.change", function(e) {
    $(this).attr('value', $("#tanggal2").val());
});

$('#buttonFilter').on('click', function() {
    var awal = $('#tanggal1').val();
    var akhir = $('#tanggal2').val();
    var jenis = $('#jenisLaporan').val();

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            "url": "{!! route('laporan.buat') !!}",
            "data": {
                "awal": awal,
                "akhir": akhir,
                "laporan": jenis,
            }
        },
        columns: [
            {
                data: 'Nota',
                name: 'Nota'
            },
            {
                data: 'Tanggal',
                name: 'Tanggal'
            },
            {
                data: 'Pelanggan',
                name: 'Pelanggan'
            },
            {
                data: 'Total',
                name: 'Total'
            },
            {
                data: 'Profit',
                name: 'Profit'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        "pageLength": 10
    });
});

function detailLaporan(kode) {
    console.log(kode);
    var jenis = $('#jenisLaporan').val();
    $('#table2').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            "url": "{!! route('laporan.detail') !!}",
            "data": {
                "kode": kode,
                "laporan": jenis
            }
        },
        columns: [
            {
                data: 'Barang',
                name: 'Barang'
            },
            {
                data: 'Jumlah',
                name: 'Jumlah'
            },
            {
                data: 'Satuan',
                name: 'Satuan'
            },
            {
                data: 'HargaJual',
                name: 'HargaJual'
            },
            {
                data: 'HargaBeli',
                name: 'HargaBeli'
            },
            {
                data: 'Subtotal',
                name: 'Subtotal'
            },
            {
                data: 'Profit',
                name: 'Profit'
            }
        ],
        "pageLength": 10
    });
}
</script>
@endpush