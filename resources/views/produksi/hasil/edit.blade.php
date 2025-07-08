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
                    <form action="{{ route('produksi.update') }}" method="post" class="formsub">
                        @csrf
                        @method('put')
                        <!-- Contents -->
                        <br>
                        <div class="form-row col-md-12">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="kodeproduksi">Kode Produksi: </label>
                                    <input type="text" class="form-control bahanjadi" name="KodeProduksi" id="kodeproduksi" value="{{$produksi->KodeProduksi}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tanggalproduksi">Tanggal: </label>
                                    <input type="text" class="form-control bahanjadi" id="tanggalproduksi" value="{{$produksi->TanggalProduksi}}" readonly>
                                    {{--<label for="tanggalproduksi">Tanggal : </label>
                                    <div class="input-group inputDate">
                                        <input type="text" class="form-control bahanjadi" id="tanggalproduksi" name="TanggalProduksi" value="{{date('d-m-Y')}}" >
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>--}}
                                </div>
                                <div class="form-group">
                                    {{--<label for="resepproduksi">Resep: </label>
                                    <select class="form-control bahanjadi" name="ResepProduksi" id="resepproduksi" placeholder="Pilih resep" required>
                                        <option selected disabled hidden>-- Pilih resep --</option>
                                        @foreach($resep as $rsp)
                                        <option value="{{$rsp->KodeResep}}" nomor="{{$loop->iteration}}">{{$rsp->NamaItem}}</option>
                                        <input type="hidden" class="idsatuanresep" nomor="{{$loop->iteration}}" value="{{$rsp->KodeSatuan}}">
                                        <input type="hidden" class="namasatuanresep" nomor="{{$loop->iteration}}" value="{{$rsp->NamaSatuan}}">
                                        @endforeach
                                    </select>--}}
                                    <label for="resepproduksi">Resep: </label>
                                    <input type="text" class="form-control bahanjadi" id="resepproduksi" value="{{$produksi->NamaItem}}" readonly>
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
                                <input type="hidden" value="{{count($produksi_detail)}}" name="totalItem" id="totalItem">

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:9%;">No.</td>
                                        <td id="header" style="width:16%;">Karyawan</td>
                                        <td id="header" style="width:9%;">Jumlah</td>
                                        <td id="header" style="width:25%;">Satuan</td>
                                        <td id="header"></td>
                                    </tr>
                                    @foreach($produksi_detail as $detail)
                                    @if($loop->iteration == 1)
                                    <tr class="rowinput">
                                    @else
                                    <tr class="tambah{{$loop->iteration}}">
                                    @endif
                                        <td id="text-nomor{{$loop->iteration}}" urutan="{{$loop->iteration}}" style="vertical-align: middle; text-align: center;">{{$loop->iteration}}</td>
                                        <td>
                                            <select name="KaryawanProduksi[]" class="form-control" id="select-karyawan{{$loop->iteration}}" placeholder="Pilih karyawan" urutan="{{$loop->iteration}}" required>
                                                <option selected disabled hidden>-- Pilih karyawan --</option>
                                                @foreach($karyawan as $kar)
                                                @if($kar->KodeKaryawan == $detail->KodeKaryawan)
                                                    <option value="{{$kar->KodeKaryawan}}" selected>{{$kar->Nama}}</option>
                                                @else
                                                    <option value="{{$kar->KodeKaryawan}}">{{$kar->Nama}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=1 name="JumlahProduksi[]" class="form-control" id="input-jumlah{{$loop->iteration}}" value="0" urutan="{{$loop->iteration}}" required>
                                        </td>
                                        <td id="text-satuan{{$loop->iteration}}">{{$detail->NamaSatuan}}</td>
                                        @if($loop->iteration == 1)
                                        <td></td>
                                        @else
                                        <td><button type="button" onclick="del({{$loop->iteration}})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                        @endif
                                    </tr>
                                    @endforeach
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
</script>
@endpush