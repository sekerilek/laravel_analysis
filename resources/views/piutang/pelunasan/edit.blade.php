@extends('index')
@section('content')
<style type="text/css">
    form {
        margin: 20px 0;
    }

    form input,
    button {
        padding: 5px;
    }

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
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Pelunasan Piutang</h1>
                </div>
                <div class="x_content">
                    <form action="{{ url('/pelunasanpiutang/payment/'.$invoice->KodeInvoicePiutang.'/update')}}" method="post" class="formsub">
                        @csrf

                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-4">
                                <input type="hidden" class="form-control" name="KodePelunasan" value="{{$pelunasan->KodePelunasanPiutangID}}" readonly="">
                                <div class="form-group">
                                    <label for="inputDate">Kode Invoice</label>
                                    <input type="text" class="form-control" name="kode" value="{{$invoice->KodeInvoicePiutangShow}}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Mata Uang</label>
                                    <select class="form-control" name="matauang">
                                        @foreach($matauang as $m)
                                        @if($pelunasan->KodeMataUang == $m->KodeMataUang)
                                        <option value="{{$m->KodeMataUang}}" selected>{{$m->NamaMataUang}}</option>
                                        @else
                                        <option value="{{$m->KodeMataUang}}">{{$m->NamaMataUang}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Status</label>
                                    <select readonly class="form-control" name="status">
                                        <option value="AR">Piutang (AR)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <div class="form-group">
                                    <label for="inputDate">Tanggal Pembayaran</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate" required="required" value="{{$pelunasan->Tanggal}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Metode Pembayaran</label>
                                    <select class="form-control" name="metode">
                                        @if($pelunasan->TipeBayar == 'Cash')
                                        <option value="Cash" selected>Cash</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Giro">Giro</option>
                                        @elseif($pelunasan->TipeBayar == 'Transfer')
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer" selected>Transfer</option>
                                        <option value="Giro">Giro</option>
                                        @elseif($pelunasan->TipeBayar == 'Giro')
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Giro" selected>Giro</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label for="inputDate">Jumlah</label>
                                    @if($invoice->Status == 'CLS')
                                    <input type="hidden" class="form-control jml" name="jml" placeholder="{{$sisa}}" value="{{$pelunasan->Jumlah}}" required="required" pattern="[0-9]+([\.,][0-9]+)?" step="0.01">
                                    @else
                                    <input type="number" class="form-control jml" name="jml" placeholder="{{$sisa}}" value="{{$pelunasan->Jumlah}}" required="required" pattern="[0-9]+([\.,][0-9]+)?" step="0.01">
                                    @endif
                                    <input readonly type="text" class="form-control jmlformat" value="{{$pelunasan->Jumlah}}">
                                    <input type="hidden" class="form-control jmlshow" name="jmlshow" value="{{$sisa}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" required>{{$pelunasan->Keterangan}}</textarea>
                                </div>
                            </div>
                            <input type="submit" name="" value="Simpan" class="btn btn-primary pull-right" onclick="return confirm('Simpan data ini?')">
                        </div>
                    </form>
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

    var jml = $(".jmlformat").val();
    var format = 'Rp ' + number_format(jml);
    $(".jmlformat").val(format);

    $(".jml").change(function() {
        if (parseFloat($(".jml").val()) > parseFloat($(".jmlshow").val())) {
            $(".jml").val($(".jmlshow").val());
        }
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