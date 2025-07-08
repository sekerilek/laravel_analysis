@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Ubah Data Golongan</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('mastergolongan.update',$idgol) }}" method="post" style="/*! display:inline-block; */">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <!-- data nominal -->
                                <div class="col-md-5">
                                    @foreach ($gol as $data)
                                    <div class="form-group">
                                        <label>Kode Golongan: </label>
                                        <input readonly type="text" value="{{ $data->KodeGolongan }}" name="KodeGolongan" placeholder="Kode Golongan" class="form-control">
                                        <input type="hidden" id="numgol" value="{{ $numgol }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Golongan: </label>
                                        <input type="text" name="NamaGolongan" placeholder="Nama Golongan" class="form-control" value="{{ $data->NamaGolongan }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Uang Hadir: </label>
                                        <input type="text" id="uhadir" required="required" name="UangHadir" placeholder="Uang Hadir Golongan" class="form-control" value="{{ $data->UangHadir }}" onchange="formatNumber(this);">
                                        <input disabled type="text" id="uhadirformat" class="form-control" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Gaji Harian: </label>
                                        <input type="text" id="uharian" required="required" name="LemburHarian" placeholder="Lembur Harian Golongan" class="form-control" value="{{ $data->LemburHarian }}" onchange="formatNumber(this);">
                                        <input disabled type="text" id="uharianformat" class="form-control" value="0">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Lembur Minggu: </label>
                                        <input type="text" id="uminggu" required="required" name="LemburMinggu" placeholder="Lembur Minggu Golongan" class="form-control" value="{{ $data->LemburMinggu }}" onchange="formatNumber(this);">
                                        <input disabled type="text" id="umingguformat" value="0">
                                    </div>
                                    @endforeach
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

                                    <input type="hidden" id="totalItem" value="{{$countdetail}}">

                                    <div id="idGolItem" style="margin-top:10px;">
                                        @foreach ($detailgol as $key => $value)
                                            <div style="padding-top:10px;" class="inputItem">
                                                <label>Jenis Item {{ $key+1 }}</label>
                                                <div class="form-group">
                                                    <input type="hidden" name="kodeGolItem[]" value="{{ $value->KodeGolItem }}" id="kodeItem{{$key+1}}">
                                                    <input type="text" required="required" name="golItem[]" placeholder="Jenis Item" class="form-control" value="{{ $value->NamaGolItem }}" id="namaItem{{$key+1}}">
                                                    <input type="text" required="required" name="hargaItem[]" placeholder="Harga Item" class="form-control nominalItem" value="{{ $value->HargaGolItem }}" id="nominalItem{{$key+1}}" onchange="formatNumber(this);">
                                                </div>
                                                <div class="form-group">
                                                    <input readonly type="text" id="nominalItem{{ $key+1 }}format" value="0">
                                                </div>
                                            </div>
                                        @endforeach
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
    // setting format nilai saat page terload
    $(document).ready(function() {
        var numgol      = +($('#numgol').val());

        var hadir = +($('#uhadir').val());
        $('#uhadirformat').val(number_format(hadir));

        var harian = +($('#uharian').val());
        $('#uharianformat').val(number_format(harian));

        var minggu = +($('#uminggu').val());
        $('#umingguformat').val(number_format(minggu));

        var nomor = 0;
        $('.nominalItem').each(function() {
            nomor = nomor + 1;
            var item = +($(this).val());
            $('#nominalItem' + nomor + 'format').val(number_format(item));
        });
    });

    function formatNumber(element) {
        var idelement        = $(element).attr('id');
        var valelement       = +($(element).val());
        $('#'+idelement+'format').val(number_format(valelement));
    }

    // $('.nominalItem').each(function() {
    //     $(this).on('change', function() {
    //         var id      = $(this).attr('id');
    //         var nomor   = id.substr(11);
    //         var item = +($('#nominalItem' + nomor).val());
    //         $('#nominalItem' + nomor + 'format').val(number_format(item));
    //     })
    // });

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
        /* jumlah item setelah penambahan */
        $("#totalItem").val(parseInt($("#totalItem").val()) + 1);
        var count = $("#totalItem").val();

        /* template form untuk item baru */
        var markup = $(".inputItem").html();
        var res = "<div style='padding-top:10px;' class='inputItemTambah"+count+"'>" + markup + "</div>";
        res = res.replace("kodeItem1", "kodeItem" + count);
        res = res.replace("Jenis Item 1", "Jenis Item " + count);
        res = res.replace("namaItem1", "namaItem" + count);
        res = res.replace("nominalItem1", "nominalItem" + count);
        res = res.replace("nominalItem1format", "nominalItem" + count + "format");
        
        $("#idGolItem").append(res);

        /* set value untuk nama item dan harga item menjadi 0 */
        $('#namaItem'+count).val('');
        $('#nominalItem'+count).val('0');

        /* assign kode item untuk item yang baru dengan mengambil kode item sebelumnya */
        var countprev           = +(count) - 1;
        var kodeItemprev        = $('#kodeItem' + countprev).val();
        var numprev             = kodeItemprev.split('-');
        if (count < 10) { numprev[2]            = '0' + count; }
        else { numprev[2]                       = count; }
        kodeItemprev            = numprev[0] + '-' + numprev[1] + '-' + numprev[2];
        $('#kodeItem' + count).val(kodeItemprev);

        /* fungsi onchange harga item baru */
        $('#nominalItem' + count).on('change', formatNumber(this));
    }
</script>
@endpush