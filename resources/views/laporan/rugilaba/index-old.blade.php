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
                                    <div class="input-group inputDate">
                                        <input type="text" class="form-control inputDate" id="tanggal1" value="{{date('d-m-Y')}}" name="tanggalLaporan">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Jenis Laporan: </label>
                                    <select class="form-control" id="jenisLaporan" name="laporan">
                                        <option value="suratjalan">Surat Jalan</option>
                                        <option value="kasir">Kasir</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Buat Laporan</label>
                                    <div class="input-group">
                                        <button class="btn btn-md btn-block btn-success" id="buttonFilter">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 id="jumlahProfit">
                    <label>Jumlah profit:</label>
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" class="form-control" id="showJumlahProfit" readonly>
                    </div>
                </h4>

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
                        <tbody>
                        </tbody>
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
    $('.table').DataTable({
        "order": [],
        "pageLength": 10
    });
});


$('#table1').on('draw.dt', function() {
    initPage('{{Auth::user()->name}}');
});

$('.inputDate').datetimepicker({
    format: 'DD-MM-YYYY'
});

$('#buttonFilter').on('click', function() {
    var tanggal = $('#tanggal1').val();
    var jenis = $('#jenisLaporan').val();

    $('#table').DataTable({
        processing: true,
        destroy: true,
        ajax: {
            "url": "{{ route('laporan.buat') }}",
            "data": {
                "tanggal": tanggal,
                "laporan": jenis
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
        initComplete: function(settings, json) {
            jumlahProfit();
        },
        "pageLength": 5
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

function jumlahProfit() {
    let table = $('#table').DataTable();
    let total = table
        .column(4)
        .data()
        .reduce(function(a, b) {
            return a + b;
        });

    $('#showJumlahProfit').val(number_format(total));
}

function number_format(number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
    var n = !isFinite(+number) ? 0 : +number
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
    var sep = (typeof thousandsSep === 'undefined') ? '.' : thousandsSep
    var dec = (typeof decPoint === 'undefined') ? ',' : decPoint
    var s = ''

    var toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k) / k)
            .toFixed(prec)
    }

    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
    }

    return s.join(dec)
}
</script>
@endpush