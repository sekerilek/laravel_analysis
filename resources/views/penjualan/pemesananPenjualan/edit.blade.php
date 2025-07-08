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
                    <h1 id="header">Pemesanan Penjualan</h1>
                    <h3 id="header">{{$id}}</h3>
                </div>
                <div class="x_content">
                    <form action="{{ url('/sopenjualan/update/' . $so->KodeSO ) }}" method="post" class="formsub">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <input type="hidden" class="form-control idp" name="KodeSO" value="{{$id}}">
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate" value="{{$so->Tanggal}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDate2">Tanggal Kirim</label>
                                    <div class="input-group date" id="inputDate2">
                                        <input type="text" class="form-control" name="TanggalKirim" id="inputDate2" value="{{$so->tgl_kirim}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputBerlaku">Masa Berlaku</label>
                                    <input type="text" class="form-control" name="Expired" id="inputBerlaku" placeholder="/hari" value="{{$so->Expired}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputTerm">Term of Payment</label>
                                    <input type="text" class="form-control" name="Term" id="inputTerm" placeholder="/hari" value="{{$so->term}}">
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <select class="form-control" name="KodeMataUang" id="inputMatauang" placeholder="Pilih mata uang">
                                        @foreach($matauang as $mu)
                                        @if($mu->KodeMataUang == $so->KodeMataUang)
                                        <option value="{{$mu->KodeMataUang}}" selected>{{$mu->NamaMataUang}}</option>
                                        @else
                                        <option value="{{$mu->KodeMataUang}}">{{$mu->NamaMataUang}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <select class="form-control" name="KodeLokasi" id="inputGudang">
                                        @foreach($lokasi as $lok)
                                        @if($lok->KodeLokasi == $so->KodeLokasi)
                                        <option value="{{$lok->KodeLokasi}}" selected>{{$lok->NamaLokasi}}</option>
                                        @else
                                        <option value="{{$lok->KodeLokasi}}">{{$lok->NamaLokasi}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Pelanggan</label>
                                    <select class="form-control" name="KodePelanggan" id="inputPelanggan">
                                        @foreach($pelanggan as $pel)
                                        @if($pel->KodePelanggan == $so->KodePelanggan)
                                        <option value="{{$pel->KodePelanggan}}" selected>{{$pel->NamaPelanggan}}</option>
                                        @else
                                        <option value="{{$pel->KodePelanggan}}">{{$pel->NamaPelanggan}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label>
                                    <input type="number" step=0.01 onchange="disc()" class="diskon form-control" name="diskon" id="inputBerlaku" placeholder="%" value="{{$so->Diskon}}">
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class=" form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputPelanggan">PPN</label>
                                    @if($so->PPN == "ya")
                                    <input type="text" class="form-control" placeholder="" value="Ya" readonly>
                                    <input type="hidden" class="form-control ppn" name="ppn" placeholder="" value="ya" readonly>
                                    @else
                                    <input type="text" class="form-control" placeholder="" value="Tidak" readonly>
                                    <input type="hidden" class="form-control ppn" name="ppn" placeholder="" value="tidak" readonly>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if($so->PPN == "ya")
                                    <label class="b">No Faktur Pajak</label>
                                    <input type="text" class="form-control" name="NoFaktur" id="inputFaktur" value="{{$so->NoFaktur}}">
                                    @endif
                                </div>
                                <label for=" inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="5">{{$so->Keterangan}}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <br><br>
                                <div class="x_title">
                                </div>
                                <br>
                                <h3 id="header">Daftar Item</h3>
                                <a href="javascript:;" class="btn btn-primary pull-right" onclick="addrow()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                                <br><br><br>
                                <input type="hidden" value="{{$itemcount}}" name="totalItem" id="totalItem">
                                <input type="hidden" value="{{$itemcount}}" name="itemcount" id="itemcount">

                                @foreach($itemlist as $item)
                                <input type="hidden" id="{{$item->KodeItem}}Ket" value="{{$item->Keterangan}}">
                                @foreach($datasatuan["$item->KodeItem"] as $dsat)
                                <input type="hidden" id="{{$item->KodeItem}}{{$dsat}}" value="{{$dsat}}">
                                @endforeach
                                @foreach($dataharga["$item->KodeItem"] as $dsatuan => $dharga)
                                <input type="hidden" id="{{$item->KodeItem}}{{$dsatuan}}Harga" value="{{$dharga}}">
                                @endforeach
                                @endforeach

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:18%;">Nama Barang</td>
                                        <td id="header" style="width:12%;">Satuan</td>
                                        <td id="header" style="width:9%;">Qty</td>
                                        <td id="header" style="width:18%;">Harga Satuan</td>
                                        <td id="header" style="width:20%;">Keterangan</td>
                                        <td id="header">Total</td>
                                        <td></td>
                                    </tr>
                                    @foreach($items as $key => $item)
                                    <tr class="rowinput">
                                        <td>
                                            <select name="item[]" onchange="barang(this,{{$key+1}});" class="form-control item{{$key+1}}" id="item{{$key+1}}">
                                                @foreach($itemlist as $itemData)
                                                @if($itemData->KodeItem == $item->KodeItem)
                                                <option selected value="{{$itemData->KodeItem}}">{{$itemData->NamaItem}}</option>
                                                @else
                                                <option value="{{$itemData->KodeItem}}">{{$itemData->NamaItem}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="satuan[]" onchange="satuan(this,{{$key+1}});" class="form-control satuan{{$key+1}}" id="satuan{{$key+1}}">
                                                @foreach($satuan as $satuanData)
                                                @if($satuanData->KodeSatuan == $item->KodeSatuan)
                                                <option selected value="{{$satuanData->KodeSatuan}}">{{$satuanData->NamaSatuan}}</option>
                                                @else
                                                <option value="{{$satuanData->KodeSatuan}}">{{$satuanData->NamaSatuan}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 onchange="qty({{$key+1}})" name="qty[]" class="form-control qty{{$key+1}}" value="{{$item->Qty}}">
                                        </td>
                                        <td>
                                            <input type="text" onchange="price({{$key+1}})" name="price[]" class="form-control price{{$key+1}}" required="" value="{{$item->Harga}}">
                                        </td>
                                        <td>
                                            <input readonly type="text" class="form-control keterangan{{$key+1}}" required="" value="{{$item->Keterangan}}">
                                        </td>
                                        <td>
                                            <input readonly="" type="hidden" name="total[]" class="form-control total{{$key+1}}" required="" value="{{$item->Subtotal}}"">
                                                <input readonly type=" text" class="form-control showtotal{{$key+1}}" value="{{$string_total = "Rp " . number_format($item->Subtotal, 0, ',', '.') .",-"}}">
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                    <!-- <button type="submit" class="btn btn-danger">Batal</button> -->
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPelanggan">Subtotal</label>
                                    <input type="hidden" readonly="" class="form-control befDis" value="0" name="bef" placeholder="">
                                    <input type="text" readonly="" class="form-control showbefDis" value="Rp 0,-">
                                    <label for="inputPelanggan">Nilai PPN</label>
                                    <input type="hidden" readonly value="0" name="ppnval" class="ppnval form-control">
                                    <input type="text" readonly="" class="form-control showppnval" value="Rp 0,-">
                                    <label for="inputPelanggan">Diskon</label>
                                    <input type="hidden" readonly value="0" name="diskonval" class="diskonval form-control">
                                    <input type="text" readonly="" class="form-control showdiskonval" value="Rp 0,-">
                                    <label for="inputPelanggan">Total</label>
                                    <input type="hidden" readonly="" class="form-control subtotal" value="0" name="subtotal" placeholder="">
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
    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#inputDate2').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
    $('#item').select2();
    var item = $(".item" + 1).val();
    var ket = $("#" + item + "Ket").val();
    $(".keterangan" + 1).val(ket);
    var count = $("#totalItem").val();
    updatePrice(count);

    function qty(int) {
        var qty = $(".qty" + int).val();
        var item = $(".item" + int).val();
        var sat = $(".satuan" + int).val();
        var price = $(".price" + int).val();
        var price = $("#" + item + sat + "Harga").val();
        if (price == null) {
            price = "Harga tidak tersedia";
            $(".price" + int).val(price);
            $(".total" + int).val(0);
            updatePrice(0);
        } else {
            $(".price" + int).val(price);
            $(".total" + int).val(price * qty);
            var formattotal = 'Rp ' + number_format(price * qty) + ',-';
            $(".showtotal" + int).val(formattotal);
        }
        var count = $("#totalItem").val();
        updatePrice(count);
    }

    function price(int) {
        var qty = $(".qty" + int).val();
        var item = $(".item" + int).val();
        var sat = $(".satuan" + int).val();
        var checkprice = $("#" + item + sat + "Harga").val();
        if (checkprice == null) {
            var price = "Satuan tidak tersedia";
            $(".price" + int).val(price);
            $(".total" + int).val(0);
            updatePrice(0);
        } else {
            var price = $(".price" + int).val();
            $(".total" + int).val(price * qty);
            var formattotal = 'Rp ' + number_format(price * qty) + ',-';
            $(".showtotal" + int).val(formattotal);
            var count = $("#totalItem").val();
            updatePrice(count);
        }
    }

    function addrow() {
        $("#totalItem").val(parseInt($("#totalItem").val()) + 1);
        var count = $("#totalItem").val();
        var markup = $(".rowinput").html();
        var res = "<tr class='tambah" + count + "'>" + markup + "</tr>";
        res = res.replace("qty1", "qty" + count);
        res = res.replace("item1", "item" + count);
        res = res.replace("price1", "price" + count);
        res = res.replace("total1", "total" + count);
        res = res.replace("showtotal1", "showtotal" + count);
        res = res.replace("qty(1)", "qty(" + count + ")");
        res = res.replace("price(1)", "price(" + count + ")");
        res = res.replace("barang(this,1", "barang(this," + count);
        res = res.replace("satuan(this,1", "satuan(this," + count);
        res = res.replace("satuan1", "satuan" + count);
        res = res.replace("keterangan1", "keterangan" + count);
        res = res.replace("<td></td>", '<td><button type="button" onclick="del(' + count + ')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>');

        $("#items tbody").append(res);
        var item = $(".item" + count).val();
        var ket = $("#" + item + "Ket").val();
        $(".keterangan" + count).val(ket);
    }

    function barang(val, int) {
        var ket = $("#" + val.value + "Ket").val();
        $(".keterangan" + int).val(ket);
        $(".price" + int).val(0);
        $(".total" + int).val(0);
        $(".qty" + int).val(0);
    }

    function satuan(val, int) {
        var sat = val.value;
        var qty = $(".qty" + int).val();
        var item = $(".item" + int).val();
        var price = $(".price" + int).val();
        var price = $("#" + item + sat + "Harga").val();
        if (price == null) {
            price = "Harga tidak tersedia";
            $(".price" + int).val(price);
            $(".total" + int).val(0);
            updatePrice(0);
        } else {
            $(".price" + int).val(price);
            $(".total" + int).val(price * qty);
        }
        var count = $("#totalItem").val();
        updatePrice(count);
    }

    function del(int) {
        $(".tambah" + int).remove();
        var count = $("#totalItem").val();
        updatePrice(count);
    }

    function disc() {
        var count = $("#totalItem").val();
        updatePrice(count);
    }

    function ppnfunc(val) {

        if (val.value == 'ya') {
            $(".a").hide();
            $(".b").show();
            $(".idp").val($(".b").text());
        } else {
            $(".a").show();
            $(".b").hide();
            $(".idp").val($(".a").text());
        }

        var count = $("#totalItem").val();
        updatePrice(count);
    }

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
        diskon = parseInt($(".subtotal").val()) * diskon / 100;
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

    $('.formsub').submit(function(event) {
        tot = $("#totalItem").val();
        for (var i = 1; i <= tot; i++) {
            if (typeof $(".qty" + i).val() === 'undefined') {} else {
                if ($(".qty" + i).val() == 0) {
                    event.preventDefault();
                    $(".qty" + i).focus();
                }
            }
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