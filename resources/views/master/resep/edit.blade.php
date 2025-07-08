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
                    <h3 id="header">Ubah Data Resep</h3>
                </div>
                <div class="x_content">
                    <form action="{{ route('masterresep.update', $resep->IDResep) }}" method="post" class="formsub">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="koderesep">Kode Resep: </label>
                                    <input type="text" class="form-control bahanjadi" name="KodeResep" id="koderesep" value="{{$resep->KodeResep}}" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="namaresep">Resep untuk: </label>
                                    {{--<select class="form-control bahanjadi" name="NamaResep" id="namaresep" placeholder="Pilih nama barang" required>
                                        <option selected disabled>-- Pilih nama barang --</option>
                                        @foreach($bahanjadi as $barang)
                                        <option value="{{$barang->KodeItem}}">{{$barang->NamaItem}}</option>
                                        @endforeach
                                    </select>--}}

                                    <input type="hidden" class="form-control bahanjadi" name="NamaResep" id="namaresep" value="{{$resep->KodeItem}}">
                                    <input type="text" class="form-control bahanjadi" value="{{$resep->NamaItem}}" readonly>
                                </div>
                                <label for="keteranganresep">Keterangan: </label>
                                <textarea class="form-control bahanjadi" name="KeteranganResep" id="keteranganresep" rows="5" required>{{$resep->Keterangan}}</textarea>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="satuanresep">Satuan: </label>
                                    <select class="form-control bahanjadi" name="SatuanResep" id="satuanresep" placeholder="Pilih satuan barang" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="qtyresep">Jumlah: </label>
                                    <input type="number" required step=1 class="form-control bahanjadi" name="JumlahResep" id="jumlahresep" placeholder="1" value="{{$resep->Qty}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <br><br>
                                <div class="x_title">
                                </div>
                                <br>
                                <h3 id="header">Daftar Bahan Baku/Setengah Jadi</h3>
                                <a href="javascript:;" class="btn btn-primary pull-right" onclick="addrow()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                                <br><br><br>

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:25%;">Nama Bahan</td>
                                        <td id="header" style="width:16%;">Satuan</td>
                                        <td id="header" style="width:9%;">Jumlah</td>
                                        <td id="header" style="width:25%;">Keterangan</td>
                                        <td id="header" style="width:3%;"></td>
                                    </tr>
                                    @php
                                        $x = 1
                                    @endphp
                                    @foreach($bahanbakuresep as $baku)
                                        @if($x == 1)
                                        <tr class="rowinput">
                                        @else
                                        <tr class="tambah{{$x}}">
                                        @endif
                                        <td>
                                            <select name="BahanBaku[]" class="form-control" id="select-bahanbaku{{$x}}" placeholder="Pilih bahan baku" onchange="satuanbaku(this)" urutan="{{$x}}" required>
                                                @foreach($bahanbaku as $bahan)
                                                    @if($bahan->KodeItem == $baku->KodeItem)
                                                    <option value="{{$bahan->KodeItem}}" selected>{{$bahan->NamaItem}}</option>
                                                    @else
                                                    <option value="{{$bahan->KodeItem}}">{{$bahan->NamaItem}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="SatuanBahanBaku[]" class="form-control" id="select-satuan{{$x}}" urutan="{{$x}}" required>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=1 name="JumlahBahanBaku[]" class="form-control" id="input-jumlah{{$x}}" value="{{$baku->Qty}}" urutan="{{$x}}" required>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="KeteranganBahanBaku[]" id="textarea-keterangan{{$x}}" rows="2" urutan="{{$x}}" required>{{$baku->Keterangan}}</textarea>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @php
                                        $x = $x + 1
                                    @endphp
                                    @endforeach
                                </table>
                                <input type="hidden" value="{{$x}}" name="totalItem" id="totalItem">
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
<script type="text/javascript">
$(function() {
    $('select').select2();

    var resep = $('#namaresep').val();
    $('#satuanresep').empty();
    $.ajax({
        url: "{!! route('api.masterresep.satuan') !!}",
        data: {
            kode: resep
        }
    }).done(function(result) {
        $('#satuanresep').append(result);
    }).fail(function(status) {
        console.log(status);
    });
});
function addrow() {
    $('#select-bahanbaku1').select2('destroy');
    $('#select-satuan1').select2('destroy');
    $("#totalItem").val(parseInt($("#totalItem").val()) + 1);
    var count = $("#totalItem").val();
    var markup = $(".rowinput").html();
    var res = "<tr class='tambah" + count + "'>" + markup + "</tr>";
    res = res.replace("bahanbaku1", "bahanbaku" + count);
    res = res.replace("select-bahanbaku1", "select-bahanbaku" + count);
    res = res.replace("select-satuan1", "select-satuan" + count);
    res = res.replace("input-jumlah1", "input-jumlah" + count);
    res = res.replace("textarea-keterangan1", "textarea-keterangan" + count);
    res = res.replace('urutan="1"', 'urutan="'+count+'"');
    res = res.replace("<td></td>", '<td><button type="button" onclick="del(' + count + ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>');

    $("#items tbody").append(res);
    $('#select-bahanbaku' + count).select2({
        width: '100%'
    });
    $('#select-satuan' + count).select2({
        width: '100%'
    });
    $('#select-satuan' + count).empty();
    $('#select-bahanbaku1').select2({
        width: '100%'
    });
    $('#select-satuan1').select2({
        width: '100%'
    });
}

function del(int) {
    $(".tambah" + int).remove();
    $("#totalItem").val(parseInt($("#totalItem").val()) - 1);
}

function satuanbaku(element) {
    var bahan   = $(element).val();
    var urutan  = $(element).attr('urutan');
    $('#select-satuan'+urutan).empty();

    $.ajax({
        url: "{!! route('api.masterresep.satuan') !!}",
        data: {
            kode: bahan
        }
    }).done(function(result) {
        $('#select-satuan'+urutan).append(result);
    });
}
</script>
@endpush