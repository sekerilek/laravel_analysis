@extends('index')
@section('content')
<style type="text/css">
    table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #cdcdcd;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
    }

    #header {
        text-align: center;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Biaya Operasional</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ url('/pengeluarantambahan/update/' . $id ) }}" method="post" class="formsub">
                            @csrf
                            @method('POST')
                            <div class="form-group col-md-4">
                                <input type="hidden" class="form-control" name="KodePengeluaran" value="{{$id}}">
                                <div class="form-group">
                                    <label>Nama Biaya:</label>
                                    <input type="text" required="required" name="Nama" class="form-control" value="{{$pt->Nama}}">
                                    <small>* diisi nama biaya operasional<br>
                                        (misal: Gajian, Beli barang, dll)</small>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan:</label>
                                    <textarea id="Keterangan" name="Keterangan" class="form-control">{{$pt->Keterangan}}</textarea>
                                    <small>* diisi keterangan untuk biaya diatas<br>
                                        (misal: diisi keterangan dari gaji, atau jumlah barang yang dibeli)</small>
                                </div>
                                <div class="form-group">
                                    <label>Karyawan:</label>
                                    <input type="text" required="required" name="Karyawan" class="form-control" value="{{$pt->Karyawan}}">
                                    <small>* diisi nama karyawan yang ditujukan atau nama orang yang bersangkutan dengan biaya tersebut.<br>
                                        (misal: diisi nama karyawan yang menerima gaji, atau nama supplier barang yang dibeli)</small>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal:</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate" value="{{$pt->Tanggal}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Gudang:</label>
                                    <select name="KodeLokasi" class="form-control">
                                        @foreach($lokasi as $lok)
                                        @if($lok->KodeLokasi == $pt->KodeLokasi)
                                        <option value="{{$lok->KodeLokasi}}" selected>{{$lok->NamaLokasi}}</option>
                                        @else
                                        <option value="{{$lok->KodeLokasi}}">{{$lok->NamaLokasi}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Mata Uang:</label>
                                    <select name="KodeMataUang" class="form-control">
                                        @foreach($matauang as $mu)
                                        @if($mu->KodeMataUang == $pt->KodeMataUang)
                                        <option value="{{$mu->KodeMataUang}}" selected>{{$mu->NamaMataUang}}</option>
                                        @else
                                        <option value="{{$mu->KodeMataUang}}">{{$mu->NamaMataUang}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Metode Pembayaran:</label>
                                    <select name="Metode" class="form-control">
                                        @if($pt->Metode == "Cash")
                                        <option value="Cash" selected>Cash</option>
                                        <option value="Transfer">Transfer</option>
                                        @elseif($pt->Metode == "Transfer")
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer" selected>Transfer</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="Transaksi" class="form-control" readonly>
                                        @if($pt->Transaksi == "Keluar")
                                        <option value="Keluar" selected>Keluar</option>
                                        <!-- <option value="Masuk">Masuk</option> -->
                                        @elseif($pt->Transaksi == "Masuk")
                                        <!-- <option value="Keluar">Keluar</option> -->
                                        <option value="Masuk" selected>Masuk</option>
                                        @endif
                                    </select>
                                    <small>* "Keluar" berarti mengurangi saldo, "Masuk" menambah saldo<br>
                                        (misal: Jika yang dipilih "Cash" dan "Keluar" artinya akan mengurangi jumlah saldo dari saldo cash yang tersisa)</small>
                                </div>
                                <div class="form-group">
                                    <label>Total:</label>
                                    <input type="number" step=0.01 required="required" name="Total" class="form-control jml" value="{{$pt->Total}}">
                                    <input readonly type="text" class="form-control jmlformat" value="Rp 0">
                                    <small>* diisi total biaya yang dikeluarkan atau total biaya diterima<br>
                                    </small>
                                </div>
                                <br>
                                <button class="btn btn-success" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $(".jml").change(function() {
        var jml = $(".jml").val();
        var format = 'Rp ' + number_format(jml);
        $(".jmlformat").val(format);
    });

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