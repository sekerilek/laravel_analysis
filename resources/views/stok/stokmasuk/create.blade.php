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
                    <h1 id="header">Buat Stok Masuk</h1>
                    <h3 id="header">{{$newID}}</h3>
                </div>
                <div class="x_content">
                    <form action="{{ url('/stokmasuk/store') }}" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                @csrf
                                <!-- Contents -->
                                <br>
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="KodeStokMasuk" value="{{$newID}}">
                                        <label for="">Gudang</label>
                                        <select name="KodeLokasi" id="gudang" class="form-control">
                                            @foreach ($lokasi as $l)
                                            <option value="{{ $l->KodeLokasi}}">{{ $l->NamaLokasi}}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        <label>Keterangan</label>
                                        <textarea id="Keterangan" name="Keterangan" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
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
                                <br><br>
                                <input type="hidden" value="1" name="totalItem" id="totalItem">

                                @foreach($item as $itemData)
                                <input type="hidden" id="{{$itemData->KodeItem}}Ket" value="{{$itemData->Keterangan}}">
                                @endforeach

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:25%;">Nama Barang</td>
                                        <td id="header" style="width:25%;">Qty</td>
                                        <td id="header" style="width:25%;">Satuan</td>
                                        <td id="header" style="width:25%;">Keterangan</td>
                                        <td></td>
                                    </tr>
                                    <tr class="rowinput">
                                        <td>
                                            <select name="item[]" onchange="barang(this,1);" class="form-control item1" id="item-select1">
                                                @foreach($item as $itemData)
                                                <option value="{{$itemData->KodeItem}}">{{$itemData->NamaItem}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 onchange="qty(1)" name="qty[]" class="form-control qty1" id="qty1">
                                        </td>
                                        <td>
                                            <select name="satuan[]" onchange="satuan(this,1);" class="form-control satuan1" id="satuan-select1">
                                                @foreach($satuan as $satuanData)
                                                <option value="{{$satuanData->KodeSatuan}}">{{$satuanData->NamaSatuan}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="keterangan[]" readonly type="text" class="form-control keterangan1" required="">
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                    <!-- <button type="submit" class="btn btn-danger">Batal</button> -->
                                </div>
                                <div class="col-md-3">
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
    $('#gudang').select2();
    $('#item-select1').select2();
    $('#satuan-select1').select2();

    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    var item = $(".item" + 1).val();
    var ket = $("#" + item + "Ket").val();
    $(".keterangan" + 1).val(ket);

    function qty(int) {
        var qty = $(".qty" + int).val();
        var item = $(".item" + int).val();
        $(".total" + int).val(price * qty);
        var count = $("#totalItem").val();
    }

    function addrow() {
        $('#item-select1').select2('destroy');
        $('#satuan-select1').select2('destroy');
        $("#totalItem").val(parseInt($("#totalItem").val()) + 1);
        var count = $("#totalItem").val();
        var markup = $(".rowinput").html();
        var res = "<tr class='tambah" + count + "'>" + markup + "</tr>";
        res = res.replace("qty1", "qty" + count);
        res = res.replace("item1", "item" + count);
        res = res.replace("item-select1", "item-select" + count);
        res = res.replace("total1", "total" + count);
        res = res.replace("qty(1)", "qty(" + count + ")");
        res = res.replace("barang(this,1", "barang(this," + count);
        res = res.replace("satuan1", "satuan" + count);
        res = res.replace("satuan-select1", "satuan-select" + count);
        res = res.replace("keterangan1", "keterangan" + count);
        res = res.replace("<td></td>", '<td><button type="button" onclick="del(' + count + ')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>');

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
    }

    function satuan(val, int) {
        var sat = val.value;
        var qty = $(".qty" + int).val();
        var item = $(".item" + int).val();
        var count = $("#totalItem").val();
    }

    function del(int) {
        $(".tambah" + int).remove();
        var count = $("#totalItem").val();
    }
</script>
@endpush