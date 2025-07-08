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
                </div>
                <div class="x_content">
                    <form action="{{ url('/sopenjualan/store') }}" method="post" class="formsub">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputPelanggan">Pelanggan</label>
                                    <select class="form-control" name="KodePelanggan" id="pelanggan">
                                        @foreach($pelanggan as $pel)
                                        <option value="{{$pel->KodePelanggan}}">{{$pel->NamaPelanggan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputDate2">Tanggal Kirim</label>
                                    <div class="input-group date" id="inputDate2">
                                        <input type="text" class="form-control" name="TanggalKirim" id="inputDate2">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <br><br>
                                <h3 id="header">Daftar Item</h3>
                                <button type="button" class="btn btn-primary" onclick="addrow()">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <br><br><br>

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:25%;">Nama Barang</td>
                                        <td id="header" style="width:25%;">Qty</td>
                                        <td id="header" style="width:25%;">Harga</td>
                                        <td id="header">SubTotal</td>
                                        <td></td>
                                    </tr>
                                    <tr class="rowinput">
                                        <td>
                                            <select name="item[]" class="form-control input-item" onchange="barang(this)" required>
                                                @foreach($item as $itemData)
                                                <option value="{{$itemData->kode}}" data-harga="{{$itemData->harga}}">{{$itemData->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="1" onchange="qty(this)" name="qty[]" class="form-control input-qty" value="1" required>
                                        </td>
                                        <td>
                                            <input type="text" name="price[]" class="form-control input-harga" readonly>
                                        </td>
                                        <td>
                                            <input readonly type="hidden" name="subtotal[]" class="form-control input-subtotal">
                                            <input readonly type="text" class="form-control input-subtotal-show" value="0">
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                    <!-- <button type="submit" class="btn btn-danger">Batal</button> -->
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPelanggan">Total</label>
                                    <input type="hidden" readonly="" class="form-control input-total" value="0" name="total" placeholder="">
                                    <input type="text" readonly="" class="form-control input-total-show" value="Rp 0,-">
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
    $('select').select2();

    function addrow() {
        $('.rowinput select').select2('destroy');
        let row = $('.rowinput').html();
        $('#items').append(`<tr>${row}</tr>`);
        $('#items tr:last td:last').append(`<button type="button" class="btn btn-sm btn-danger" onclick="del(this)"><i class="fa fa-trash"></i></button>`);
        $('.rowinput select, tr:last select').select2();
    }

    function barang(el) {
        let tr = $(el).parents('tr');
        let hrg = $('.input-item option:selected', tr).data('harga');
        $('.input-harga', tr).val(hrg);

        let qty = Number($('.input-qty', tr).val());
        let harga = Number($('.input-harga', tr).val());
        $('.input-subtotal').val(qty * harga);
        $('.input-subtotal-show').val(number_format(qty * harga));
        updatePrice();
    }

    function qty(el) {
        let tr = $(el).parents('tr');
        let qty = Number($('.input-qty', tr).val());
        let harga = Number($('.input-harga', tr).val());
        $('.input-subtotal').val(qty * harga);
        $('.input-subtotal-show').val(number_format(qty * harga));

        updatePrice();
    }

    function del(el) {
        $(el).parents('tr').remove();
        updatePrice();
    }

    function updatePrice() {
        let total = 0;
        $('.input-subtotal').each(function () {
            total = total + Number($(this).val());
        });

        $('.input-total').val(total);
        $('.input-total-show').val(number_format(total));
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