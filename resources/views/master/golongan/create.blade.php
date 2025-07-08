@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Golongan</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('mastergolongan.store') }}" method="post" style="/*! display:inline-block; */">
                            @csrf
                            @method('POST')
                            <div class="col-md-12">
                                <!-- data nominal -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Kode Golongan: </label>
                                        <input readonly type="text" value="{{ $idgol }}" name="KodeGolongan" placeholder="Kode Golongan" class="form-control">
                                        <input type="hidden" id="numgol" value="{{ $numgol }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Golongan: </label>
                                        <input type="text" name="NamaGolongan" placeholder="Nama Golongan" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Uang Hadir: </label>
                                        <input type="text" id="uhadir" required="required" name="UangHadir" placeholder="Uang Hadir Golongan" class="form-control" value="0" onchange="formatNumber(this);">
                                        <input disabled type="text" id="uhadirformat" class="form-control" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Gaji Harian: </label>
                                        <input type="text" id="uharian" required="required" name="LemburHarian" placeholder="Lembur Harian Golongan" class="form-control" value="0" onchange="formatNumber(this);">
                                        <input disabled type="text" id="uharianformat" class="form-control" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Lembur Minggu: </label>
                                        <input type="text" id="uminggu" required="required" name="LemburMinggu" placeholder="Lembur Hari Minggu" class="form-control" value="0" onchange="formatNumber(this);">
                                        <input disabled type="text" id="umingguformat" class="form-control" value="0">
                                    </div>
                                </div>

                                <!-- pembatas -->
                                <div class="col-md-2"></div>

                                <!-- data nominal per item -->
                                <div class="col-md-5">
                                    <h4>Daftar Jenis Item</h4>
                                    
                                    <hr>

                                    <a href="javascript:;" class="btn btn-primary pull-right" onclick="addItem()">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Tambah Item
                                    </a>

                                    <input type="hidden" id="totalItem" value="1">

                                    <div id="idGolItem" style="margin-top:10px;">
                                        <div style="padding-top:10px;" class="inputItem">
                                            <label>Jenis Item 1</label>
                                            <div class="form-group">
                                                <input type="text" required="required" name="golItem[]" placeholder="Jenis Item" class="form-control">
                                                <input type="text" id="nominalItem1" required="required" name="hargaItem[]" placeholder="Harga Item" class="form-control" value="0" onchange="formatNumber(this);">
                                            </div>
                                            <div class="form-group">
                                                <input disabled type="text" id="nominalItem1format" class="form-control" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <!-- tombol simpan data -->
                            <div class="col-md-2" style="margin-top: 20px;">
                                <button class="btn btn-success" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                            </div>
                        </form>
                        <form action="{{ route('mastergolongan.index') }}" method="get">
                            <div class="col-md-2" style="margin-top: 10px;">
                                <button class="btn btn-danger" style="width:120px;">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var numgol      = +($('#numgol').val());
    });

    function formatNumber(element) {
        var idelement        = $(element).attr('id');
        var valelement       = +($(element).val());
        $('#'+idelement+'format').val(number_format(valelement));
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

    function addItem() {
        $("#totalItem").val(parseInt($("#totalItem").val()) + 1);
        var count = $("#totalItem").val();

        var markup = $(".inputItem").html();
        var res = "<div style='padding-top:10px;' class='inputItemTambah"+count+"'>" + markup + "</div>";
        res = res.replace("Jenis Item 1", "Jenis Item " + count);
        res = res.replace("nominalItem1", "nominalItem" + count);
        res = res.replace("nominalItem1format", "nominalItem" + count + "format");
        

        $("#idGolItem").append(res);

        $('#nominalItem' + count).on('change', formatNumber(this));
    }
</script>
@endpush