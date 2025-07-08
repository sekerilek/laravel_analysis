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
                    <h3 id="header">Hasil Produksi</h3>
                </div>
                <div class="x_content">
                    <form action="{{ route('produksi.store') }}" method="post" class="formsub">
                        @csrf
                        @method('post')
                        <!-- Contents -->
                        <br>
                        <div class="form-row col-md-12">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="kodeproduksi">Kode Produksi: </label>
                                    <input type="text" class="form-control bahanjadi" name="KodeProduksi" id="kodeproduksi" value="{{$kode_produksi}}" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggalproduksi">Tanggal : </label>
                                    <div class="input-group inputDate">
                                        <input type="text" class="form-control bahanjadi" id="tanggalproduksi" name="TanggalProduksi" value="{{date('d-m-Y')}}" >
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="resepproduksi">Resep: </label>
                                    <select class="form-control bahanjadi" name="ResepProduksi" id="resepproduksi" placeholder="Pilih resep" required>
                                        <option selected disabled hidden>-- Pilih resep --</option>
                                        @foreach($resep as $rsp)
                                        <option value="{{$rsp->KodeResep}}" nomor="{{$loop->iteration}}">{{$rsp->NamaItem}}</option>
                                        <input type="hidden" nomor="{{$loop->iteration}}" name="NamaResepProduksi" value="{{$rsp->NamaItem}}">
                                        <input type="hidden" class="idsatuanresep" nomor="{{$loop->iteration}}" value="{{$rsp->KodeSatuan}}">
                                        <input type="hidden" class="namasatuanresep" nomor="{{$loop->iteration}}" value="{{$rsp->NamaSatuan}}">
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <br><br>
                                <div class="x_title">
                                </div>
                                <br>
                                <h3 id="header">Produksi Karyawan</h3>
                                <a href="javascript:;" class="btn btn-primary pull-right" onclick="addrow()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                                <br><br>
                                <input type="hidden" value="1" name="totalItem" id="totalItem">

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:9%;">No.</td>
                                        <td id="header" style="width:16%;">Karyawan</td>
                                        <td id="header" style="width:9%;">Jumlah</td>
                                        <td id="header" style="width:25%;">Satuan</td>
                                        <td id="header"></td>
                                    </tr>
                                    <tr class="rowinput">
                                        <td id="text-nomor1" urutan="1" style="vertical-align: middle; text-align: center;">1</td>
                                        <td>
                                            <select name="KaryawanProduksi[]" class="form-control" id="select-karyawan1" placeholder="Pilih karyawan" urutan="1" required>
                                                <option selected disabled hidden>-- Pilih karyawan --</option>
                                                @foreach($karyawan as $kar)
                                                <option value="{{$kar->KodeKaryawan}}">{{$kar->Nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=1 name="JumlahProduksi[]" class="form-control" id="input-jumlah1" value="0" urutan="1" required>
                                        </td>
                                        <td id="text-satuan1"></td>
                                        <input type="hidden" id="input-satuan1" name="SatuanProduksi[]" value="">
                                        <td></td>
                                    </tr>
                                </table>
                                <div class="col-md-12" align="center">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                    <a href="{{ route('produksi.index') }}" type="submit" class="btn btn-danger">Batal</a>
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
$(function() {
    $('select').select2();
});

$('.inputDate').datetimepicker({
    format: 'DD-MM-YYYY',
});
$(".inputDate").each(function() {
    $(this).on("dp.change", function(e) {
        var id = e.target.firstElementChild.id
        $('#'+id).attr('value', $('#'+id).val());
    });
});

function addrow() {
    $('#select-karyawan1').select2('destroy');
    $("#totalItem").val(parseInt($("#totalItem").val()) + 1);
    var count = $("#totalItem").val();
    var markup = $(".rowinput").html();
    var res = "<tr class='tambah" + count + "'>" + markup + "</tr>";
    res = res.replace("text-nomor1", "text-nomor" + count);
    res = res.replace("select-karyawan1", "select-karyawan" + count);
    res = res.replace("input-jumlah1", "input-jumlah" + count);
    res = res.replace("text-satuan1", "text-satuan" + count);
    res = res.replace("input-satuan1", "input-satuan" + count);
    res = res.replace('urutan="1"', 'urutan="'+count+'"');
    res = res.replace("<td></td>", '<td><button type="button" onclick="del(' + count + ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>');

    $("#items tbody").append(res);
    $('#select-karyawan' + count).select2({
        width: '100%'
    });
    $('#select-karyawan1').select2({
        width: '100%'
    });
}

function del(int) {
    $(".tambah" + int).remove();
    $("#totalItem").val(parseInt($("#totalItem").val()) - 1);
}

$('#resepproduksi').on('change', function() {
    var resep = $('option:selected', this).attr('nomor');
    var kodesatuan = $('.idsatuanresep[nomor="'+resep+'"]').val();
    var namasatuan = $('.namasatuanresep[nomor="'+resep+'"]').val();
    $('#text-satuan'+resep).text(namasatuan);
    $('#input-satuan'+resep).val(kodesatuan);
});
</script>
@endpush