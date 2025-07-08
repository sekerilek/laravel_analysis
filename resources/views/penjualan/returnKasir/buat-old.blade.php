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

    #header {
        text-align: center;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 id="header">Return Kasir</h1>
                </div>
                <div class="x_content">
                    <form action="{{ url('/returnKasir/store/'.$id)}}" method="post" class="formsub">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label>Kode Kasir</label>
                                    <input type="text" class="form-control" name="KodeKasir" id="KodeKasir" value="{{$id}}" readonly="" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Pelanggan</label>
                                    <input type="text" class="form-control" value="{{$pelanggan->NamaPelanggan}}" readonly="" required="required">
                                    <input type="hidden" class="form-control" name="KodePelanggan" id="KodePelanggan" value="{{$kasir->KodePelanggan}}" readonly="" required="required">
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Metode Pembayaran</label>
                                    <select class="form-control" name="metode">
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Giro">Giro</option>
                                    </select>
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <div>
                                    <label for="inputKeterangan">Keterangan</label>
                                    <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="3" required></textarea>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <input type="text" class="form-control" value="{{$lokasi->NamaLokasi}}" readonly="" required="required"> -->
                                <input type="hidden" class="form-control" name="KodeLokasi" id="NamaLokasi" value="{{$kasir->KodeLokasi}}" readonly="" required="required">
                                <!-- </div> -->
                                <!-- <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label> -->
                                <input type="hidden" class="form-control" name="KodeMataUang" id="KodeMataUang" value="{{$kasir->KodeMataUang}}" readonly="" required="required">
                                <!-- </div> -->
                                <!-- <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label> -->
                                <input type="hidden" step=0.01 readonly="readonly" class="diskon form-control diskon" name="diskon" value="{{$kasir->Diskon}}">
                                <!-- </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPn</label> -->
                                <input type="hidden" readonly="readonly" class="diskon form-control ppn" name="ppn" value="{{$kasir->PPN}}">
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="x_title">
                                </div>
                                <br>
                                <h3 id="header">Daftar Item</h3>
                                <br>
                                <table id="items">
                                    <tr>
                                        <td id="header">Nama Barang</td>
                                        <td id="header">Qty</td>
                                        <td id="header">Satuan</td>
                                        <td id="header">Harga Satuan</td>
                                        <td id="header">Keterangan</td>
                                        <td id="header">Total</td>
                                    </tr>
                                    @foreach($items as $key => $data)
                                    <tr class="rowinput">
                                        <td>
                                            <input type="text" class="form-control" readonly="readonly" value="{{$data->NamaItem}}">
                                            <input type="hidden" readonly="readonly" name="item[]" value="{{$data->KodeItem}}">
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 onchange="qty({{$key+1}})" name="qty[]" class="form-control qty{{$key+1}} qtyj" required="" placeholder="{{$data->jml}}">
                                            <input type="hidden" step=0.01 class="max{{$key+1}}" value="{{$data->jml}}">
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" readonly name="satuan[]" value="{{$data->KodeSatuan}}">
                                            <input type="text" class="form-control" readonly value="{{$data->NamaSatuan}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="hidden" name="price[]" class="form-control price{{$key+1}}" required="" value="{{$data->Harga}}">
                                            <input readonly type="text" class="form-control" value="Rp. {{number_format($data->Harga)}},-">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" readonly name="keterangan[]" value="{{$data->Keterangan}}" />
                                        </td>
                                        <td>
                                            <input readonly type="hidden" name="total[]" class="form-control total{{$key+1}}" required="" value="{{$data->Harga * $data->jml}}">
                                            <input readonly type="text" class="form-control showtotal{{$key+1}}" value="Rp. {{number_format($data->Harga * $data->jml)}},-">
                                        </td>
                                    </tr>
                                    @endforeach

                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                </div>
                                <div class="col-md-3">
                                    <input type="hidden" value="{{sizeof($items)}}" class="tot">
                                    <label for="subtotal">Subtotal</label>
                                    <input type="hidden" name="total" readonly class="form-control befDis">
                                    <input type="text" readonly="" class="form-control showbefDis" value="Rp 0,-">
                                    <label for="ppn">Nilai PPN</label>
                                    <input type="hidden" readonly name="ppnval" class="ppnval form-control">
                                    <input type="text" readonly="" class="form-control showppnval" value="Rp 0,-">
                                    <label for="diskon">Nilai Diskon</label>
                                    <input type="hidden" readonly name="diskonval" class="diskonval form-control">
                                    <input type="text" readonly="" class="form-control showdiskonval" value="Rp 0,-">
                                    <label for="total">Total</label>
                                    <input type="hidden" readonly class="form-control subtotal" name="subtotal">
                                    <input type="text" readonly="" class="form-control showsubtotal" value="Rp 0,-">
                                </div>
                            </div>
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
    $('#KodeKasir').select2();

    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    updatePrice($(".tot").val());

    function updatePrice(tot) {

        $(".subtotal").val(0);
        var diskon = 0;
        if ($(".diskon").val() != "") {
            diskon = parseInt($(".diskon").val());
        }
        for (var i = 1; i <= tot; i++) {
            if ($(".total" + i).val() != undefined) {
                $(".subtotal").val(parseInt($(".subtotal").val()) + parseInt($(".total" + i).val()));
            }
        }
        var befDis = $(".subtotal").val();
        diskon = diskon ;
        $(".subtotal").val(parseInt($(".subtotal").val()));
        var ppn = $(".ppn").val();
        if (ppn == "ya") {
            ppn = parseInt(befDis) * 10 / 100;
        } else {
            ppn = parseInt(0);
        }
        $(".ppnval").val(ppn);
        $(".diskonval").val(diskon);
        $(".befDis").val(parseInt($(".subtotal").val()));
        $(".subtotal").val(parseInt($(".subtotal").val()) + ppn - diskon);

        hasiltotal = parseInt(befDis) + ppn - diskon;
        formatppn = 'Rp ' + number_format(ppn);
        formatbef = 'Rp ' + number_format(befDis);
        formatdisc = 'Rp ' + number_format(diskon);
        formattotal = 'Rp ' + number_format(hasiltotal);
        $(".showppnval").val(formatppn);
        $(".showdiskonval").val(formatdisc);
        $(".showbefDis").val(formatbef);
        $(".showsubtotal").val(formattotal);
    }

    function qty(int) {
        var qty = $(".qty" + int).val();
        var max = $(".max" + int).val();
        if (parseInt(qty) > parseInt(max)) {
            $(".qty" + int).val(max);
        }
        var qty = $(".qty" + int).val();
        var price = $(".price" + int).val();
        $(".total" + int).val(price * qty);
        var formattotal = 'Rp ' + number_format(price * qty) + ',-';
        $(".showtotal" + int).val(formattotal);
        var count = $(".tot").val();
        updatePrice(count);
    }

    $('.formsub').submit(function(event) {
        tot = $(".tot").val();
        for (var i = 1; i <= tot; i++) {
            if (typeof $(".qty" + i).val() === 'undefined') {}
            // else {
            //   if ($(".qty" + i).val() == 0) {
            //     event.preventDefault();
            //     $(".qty" + i).focus();
            //   }
            // }
        }
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