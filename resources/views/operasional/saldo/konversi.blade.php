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
                        <h1>Konversi Saldo</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ url('/saldo/storekonversi') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <label>Pilih konversi:</label>
                                    <select name="Tipe" class="form-control">
                                        <option value="RC">Tarik tunai (rekening -> cash)</option>
                                        <option value="CR">Setor tunai (cash -> rekening)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal:</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah:</label>
                                    <input type="number" step=0.01 required="required" name="Jumlah" class="form-control jml">
                                    <input readonly type="text" class="form-control jmlformat" value="Rp 0">
                                </div>
                                <br>
                                <button class="btn btn-success" style="width:120px;" onclick="return confirm('Konfirmasi konversi ini?')">Konversi</button>
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