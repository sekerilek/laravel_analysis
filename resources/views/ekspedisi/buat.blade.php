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
                    <h1 id="header">Ekspedisi</h1>
                </div>
                <div class="x_content">
                    <form action="{{ url('/ekspedisi/store') }}" method="post" class="formsub">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            
                                <div class="form-group">
                                    <label for="inputKodeEkspedisi">Kode Ekspedisi</label>
                                    <input type="text" class="form-control" name="KodeEkspedisi" id="inputKodeEkspedisi">
                                </div>
                                <div class="form-group">
                                    <label for="inputNamaEkspedisi">Nama Ekspedisi</label>
                                    <input type="text" class="form-control" name="NamaEkspedisi" id="inputNamaEkspedisi">
                                </div>
                                <div class="form-group">
                                    <label for="inputModal">Modal</label>
                                    <input type="text" class="form-control" name="Modal" id="inputModal">
                                </div>
                                <div class="form-group">
                                    <label for="inputTarifPelanggan">Tarif Pelanggan</label>
                                    <input type="text" class="form-control" name="TarifPelanggan" id="inputTarifPelanggan">
                                </div>
                            </div>
                          
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                    <!-- <button type="submit" class="btn btn-danger">Batal</button> -->
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
{{-- <script type="text/javascript"> --}}
    $('#item-select1').select2();
    $('#satuan-select1').select2();
    $("#inputSupplier").select2();
    var item = $(".item" + 1).val();
    var ket = $("#" + item + "Ket").val();
    $(".keterangan" + 1).val(ket);
    
        $("#items tbody").append(res);
        $('#item-select' + count).select2({
            width: '100%'
        });
        $('#item-select1').select2({
            width: '100%'
        });
        $('#satuan-select' + count).select2({
            width: '100%'
        });
        $('#satuan-select1').select2({
            width: '100%'
        });
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