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
                        <h1>Tambah Data Item</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('masteritem.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Kategori:</label>
                                <br>
                                <select name="KodeKategori" id="KodeKategori" class="form-control">
                                    @foreach ($kategori as $kat)
                                    <option value="{{ $kat->KodeKategori}}">{{ $kat->NamaKategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Item:</label>
                                <input type="text" required="required" name="NamaItem" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jenis Item:</label>
                                <!-- <input type="hidden" name="jenisitem" value="BahanJadi">
                                <input type="text" class="form-control" value="Bahan Jadi" readonly> -->
                                <br>
                                <select name="jenisitem" id="JenisItem" class="form-control">
                                    <option value="bahanjadi">Bahan Jadi</option>
                                    <option value="bahanbaku">Bahan Baku</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alias:</label>
                                <input id="Alias" type="text" name="Alias" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Keterangan:</label>
                                <textarea id="Keterangan" name="Keterangan" class="form-control"></textarea>
                            </div>
                            <br>

                            <!-- input satuan Konversi -->
                            <div class="x_title">
                                <h3>Tambah Data Satuan (Konversi)</h3>
                            </div>
                            <div class="form-row">
                                <a href="#" class="btn btn-success" onclick="addrow()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    Tambah Satuan
                                </a>
                                <br><br>
                                <input type="hidden" value="1" id="jumlahsatuan">
                                <table id="konversis">
                                    <tr>
                                        <td id="header"><b>Nama Satuan</b></td>
                                        <td id="header"><b>Konversi</b></td>
                                        <td id="header"><b>Harga Beli</b></td>
                                        <td id="header"><b>Harga Jual</b></td>
                                        <td id="header"><b>Harga Grosir</b></td>
                                        <td id="header"><b>Hapus</b></td>
                                    </tr>
                                    <tr class="rowinput">
                                        <td>
                                            <select name="satuan[]" class="form-control satuan1 KodeSatuan">
                                                @foreach($satuan as $sat)
                                                <option value="{{$sat->KodeSatuan}}">{{$sat->NamaSatuan}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 onchange="konversi(1)" name="konversi[]" class="form-control konv1" id="setreadonly" required value="1">
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 class="form-control hargabeli1" name="hargabeli[]" required value="0">
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 class="form-control hargajual1" name="hargajual[]" required value="0">
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 class="form-control hargagrosir1" name="hargagrosir[]" required value="0">
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </form>
                        <form action="{{ route('masteritem.index') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#KodeKategori').select2();
        $('.KodeSatuan').select2();
        // $('.satuan1').select2();
    });

    // document.getElementById("setreadonly").setAttribute("readOnly", "true");

    function konversi(int) {
        if (int > 1) {
            var konversi = $(".konv" + int).val();
            var hjual = $(".hargajual" + 1).val();
            var hbeli = $(".hargabeli" + 1).val();
            var hgrosir = $(".hargagrosir" + 1).val();
            $(".hargabeli" + int).val(konversi * hbeli);
            $(".hargajual" + int).val(konversi * hjual);
            $(".hargagrosir" + int).val(konversi * hgrosir);
        }
    }

    function addrow() {
        $("#jumlahsatuan").val(parseInt($("#jumlahsatuan").val()) + 1);
        var count = $("#jumlahsatuan").val();
        var markup = $(".rowinput").html();
        var res = "<tr class='tambah" + count + "'>" + markup + "</tr>";
        res = res.replace("satuan1", "satuan" + count);
        res = res.replace("konv1", "konv" + count);
        res = res.replace("konversi(1)", "konversi(" + count + ")");
        res = res.replace("hargabeli1", "hargabeli" + count);
        res = res.replace("hargajual1", "hargajual" + count);
        res = res.replace("hargagrosir1", "hargagrosir" + count);
        res = res.replace("<td></td>", '<td><button type="button" onclick="del(' + count + ')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>');

        $("#konversis tbody").append(res);
        // $('.satuan' + count).select2();
    }

    function del(int) {
        $(".tambah" + int).remove();
    }
</script>
@endpush