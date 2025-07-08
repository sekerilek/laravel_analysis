@extends('index')
@section('content')
<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }

    table {
        table-layout: fixed;
    }

    .headerTabel {
        word-wrap: break-word;
        text-align: center;
        background-color: #eeeeee;
        vertical-align: middle;
    }
</style>
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 id="header">Gaji Karyawan</h3>
            </div>

            <div class="x_content" style="padding-left: 0; padding-right: 0;">
                <div class="form-row">
                    <form action="{{ url('/penggajian/gaji/simpan') }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('POST')

                        <div class="form-group col-xs-4 col-sm-4 col-md-4">
                            <label>Tanggal:</label>
                            <div class="input-group inputDate">
                                <input type="text" class="form-control inputDate" name="tanggalGaji" id="date" value="{{date('d-m-Y')}}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4"></div>

                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label>Golongan: </label>
                            <select class="form-control namaGolongan">
                                <option selected disabled hidden>-- Pilih Golongan --</option>
                                @foreach($daftarGolongan as $golongan)
                                    <option value="{{ $golongan->KodeGolongan }}">{{ $golongan->NamaGolongan }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="idGolongan">
                        </div>

                        <br><br><br>

                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" style="margin-bottom: 25px;" id="tabelKaryawan">

                            </table>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                            <a href="/penggajian" class="btn btn-danger" style="width:120px;">Batal</a>
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
    $('body').attr('class', 'nav-sm');
});

$('.inputDate').datetimepicker({
    format: 'DD-MM-YYYY',
});

$(".inputDate").on("dp.change", function(e) {
    $('#date').attr('value', $('#date').val());
    
});

$('.namaGolongan').select2();

$('.namaGolongan').on('change', function() {
    $('#tabelKaryawan').empty();
    var tanggal             = $('#date').val();
    var golongan            = $(this).val();
    var namaGolongan        = $('option[value="'+golongan+'"]').html();
    var dataKaryawanUrl     = '/penggajian/api/karyawan/' + golongan;
    var dataBarangUrl       = '/penggajian/api/barang/' + golongan;
    
    var tabelKaryawan       = '';
    var bodyTabelKaryawan   = '';

    var jumlahBarang        = 0;
    var jumlahKaryawan      = 0;
    
    $.get(dataBarangUrl, function(data, status) {
        if ($.isEmptyObject(data)) {
            alert('Data Golongan tidak ditemukan');
        }
        else {
            jumlahBarang    = data.length;

            /*baris 1*/
            tabelKaryawan           = '<thead>'
                                        +'<tr>'
                                        +'<th class="headerTabel" width="3%">No</th>'
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02') ? 'width="6%"' : '')+'>Nama</th>'
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02') ? 'width="8%"' : '')+'>Gaji Borongan</th>'
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02') ? 'width="5%"' : '')+'></th>'
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02') ? 'width="8%"' : '')+'>Gaji Harian</th>'
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02') ? 'width="5%"' : '')+'></th>'
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02') ? 'width="7%"' : '')+'>Lembur Minggu</th>';

            tabelKaryawan           = tabelKaryawan
                                        +'<th class="headerTabel lemburJam" '+(golongan == 'GOL-01' ? 'style="display: none;"' : '')+'>Lembur Jam</th>'
                                        +'<th class="headerTabel lemburJam" '+(golongan == 'GOL-01' ? 'style="display: none;"' : '')+'></th>';

            $.each(data, function(i, val) {
                tabelKaryawan       = tabelKaryawan
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02') ? 'width="6%"' : '')+'>'+ val.NamaGolItem +'</th>'
                                        +'<input type="hidden" name="kodeBarang[]" value="'+val.KodeGolItem+'">';
            });

            tabelKaryawan           = tabelKaryawan
                                        +'<th class="headerTabel" width="6%" '+(golongan != 'GOL-01' ? 'style="display: none;"' : '')+'>Jumlah</th>'
                                        +'<th class="headerTabel" width="8%" '+((golongan == 'GOL-02' || golongan == 'GOL-03') ? 'style="display: none;"' : '')+'>Bonus</th>'
                                        +'<th class="headerTabel" '+((golongan == 'GOL-01' || golongan == 'GOL-02' || golongan == 'GOL-03' || golongan == 'GOL-08') ? 'style="display: none;"' : '')+'>Jumlah (Hari)</th>';

            tabelKaryawan           = tabelKaryawan
                                        +'<th class="headerTabel" width="6%">Subtotal</th>'
                                        +'</tr>'
                                        +'</thead>';
            /*baris 2*/
            tabelKaryawan           = tabelKaryawan
                                        +'<tbody>'
                                        +'<tr>'
                                        +'<td class="headerTabel" height="50%"></td>'
                                        +'<td class="headerTabel" height="50%"></td>'
                                        +'<td class="headerTabel" height="50%">Besaran</td>'
                                        +'<td class="headerTabel" height="50%">Hari</td>'
                                        +'<td class="headerTabel" height="50%">Besaran</td>'
                                        +'<td class="headerTabel" height="50%">Hari</td>'
                                        +'<td class="headerTabel" height="50%"></td>';

            tabelKaryawan           = tabelKaryawan
                                        +'<td class="headerTabel" height="50%" '+(golongan == 'GOL-01' ? 'style="display: none;"' : '')+'>Besaran</td>' //untuk kolom lembur jam
                                        +'<td class="headerTabel" height="50%" '+(golongan == 'GOL-01' ? 'style="display: none;"' : '')+'>Jam</td>'; //untuk kolom lembur jam

            var nomor = 0;
            $.each(data, function(i, val) {
                nomor = nomor + 1;
                tabelKaryawan     = tabelKaryawan
                                            +'<td class="headerTabel" height="50%">'+ val.HargaGolItem +'</td>'
                                            +'<input type="hidden" class="hargaBarang'+nomor+'" name="hargaBarang[]" value="'+val.HargaGolItem+'">';
            });

            tabelKaryawan           = tabelKaryawan
                                        +'<td class="headerTabel" height="50%" '+(golongan != 'GOL-01' ? 'style="display: none;"' : '')+'></td>' //untuk kolom konversi
                                        +'<td class="headerTabel" height="50%" '+((golongan == 'GOL-02' || golongan == 'GOL-03') ? 'style="display: none;"' : '')+'>Besaran</td>' //untuk kolom bonus
                                        +'<td class="headerTabel" height="50%" '+((golongan == 'GOL-01' || golongan == 'GOL-02' || golongan == 'GOL-03' || golongan == 'GOL-08') ? 'style="display: none;"' : '')+'>Hari</td>'; //untuk kolom jumlah bonus

            tabelKaryawan         = tabelKaryawan
                                            +'<td class="headerTabel" height="50%"></td>'
                                            +'</tr>';

            /*baris 3 dst untuk data usernya*/

            $.get(dataKaryawanUrl, function(dt, st) {
                var jumlahAbsen = 0;
                if ($.isEmptyObject(dt)) {
                    alert('Data karyawan Golongan ' + namaGolongan + ' tidak ditemukan');
                }
                else {
                    $.each(dt, function(x, value) {
                        var absenGajiUrl = '/penggajian/api/gaji/'+value.KodeKaryawan+'/'+$('#date').val();
                        $.get(absenGajiUrl, function(datas, statuses) {
                          jumlahAbsen = datas;
                        });
                        
                        jumlahKaryawan      = jumlahKaryawan + 1;

                        bodyTabelKaryawan   = bodyTabelKaryawan
                                            +'<tr>'
                                            +'<td>'+jumlahKaryawan+'</td>'
                                            +'<th class="headerTabel" style="background-color: #ffee00; text-align: left; vertical-align: middle;">'+value.Nama+'</th>'
                                            +'<input type="hidden" value="'+value.Nama+'" name="namaKaryawan[]">'
                                            +'<input type="hidden" value="'+value.KodeKaryawan+'" name="kodeKaryawan[]">'
                                            +'<td><input type="number" min="0" class="form-control '+jumlahKaryawan+' gajiKaryawan'+jumlahKaryawan+'" value="'+(value.GajiPokok == "0" ? value.UangHadir : value.GajiPokok)+'" name="gajiKaryawan[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')"></td>'
                                            +'<td><input type="number" min="0" class="form-control '+jumlahKaryawan+' jumlahHariKerja'+jumlahKaryawan+' hariKerja" value="'+jumlahAbsen+'" name="jumlahHariKerja[]" id="'+jumlahKaryawan+'" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')"></td>'
                                            +'<input type="hidden" class="subtotalGaji'+jumlahKaryawan+'" value="0" name="subtotalGaji[]">'
                                            +'<td><input type="number" min="0" class="form-control '+jumlahKaryawan+' lemburHarian'+jumlahKaryawan+'" value="'+value.LemburHarian+'" name="lemburHarian[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')"></td>'
                                            +'<td><input type="number" min="0" class="form-control '+jumlahKaryawan+' jumlahLemburHarian'+jumlahKaryawan+'" value="0" name="jumlahLemburHarian[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')"></td>'
                                            +'<input type="hidden" class="subtotalLemburHarian'+jumlahKaryawan+'" value="0" name="subtotalLemburHarian[]">'
                                            +'<td style="vertical-align: middle;"><input type="number" min="0" class="form-control '+jumlahKaryawan+' subtotalLemburMinggu'+jumlahKaryawan+'" value="0" name="subtotalLemburMinggu[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')" readonly></td>'
                                            +'<input type="hidden" class="lemburMinggu'+jumlahKaryawan+'" value="'+value.LemburMinggu+'">';
                                            // +'<td><input type="number" min="0" class="form-control '+jumlahKaryawan+' subtotalLemburMinggu'+jumlahKaryawan+'" value="'+value.LemburMinggu+'" name="subtotalLemburMinggu[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')"></td>';

                        bodyTabelKaryawan   = bodyTabelKaryawan
                                            +(golongan == 'GOL-01' ? '' : '<td>')+'<input type="'+(golongan == 'GOL-01' ? 'hidden' : 'number')+'" min="0" class="form-control '+jumlahKaryawan+' lemburJam'+jumlahKaryawan+'" value="'+(+(value.LemburHarian) / 7)+'" name="lemburJam[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')">'
                                            +(golongan == 'GOL-01' ? '' : '<td>')+'<input type="'+(golongan == 'GOL-01' ? 'hidden' : 'number')+'" min="0" class="form-control '+jumlahKaryawan+' jumlahLemburJam'+jumlahKaryawan+'" value="0" name="jumlahLemburJam[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')">'
                                            +'<input type="hidden" class="subtotalLemburJam'+jumlahKaryawan+'" value="0" name="subtotalLemburJam[]">';

                        for (var i = 1; i <= jumlahBarang; i++) {
                            bodyTabelKaryawan   = bodyTabelKaryawan
                                                +'<td><input type="number" min="0" class="form-control '+jumlahKaryawan+' jumlahBarang'+jumlahKaryawan+' barangKaryawan'+i+jumlahKaryawan+'" value="0" name="barangKaryawan['+i+'][]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')"></td>';
                        }

                        bodyTabelKaryawan       = bodyTabelKaryawan
                                                    +'<input type="hidden" class="subtotalHargaBarang'+jumlahKaryawan+'" value="0" name="subtotalHargaBarang[]">';

                        bodyTabelKaryawan       = bodyTabelKaryawan
                                                +'<td class="konversiBarang'+jumlahKaryawan+'" style="text-align: right; vertical-align: middle; '+(golongan != 'GOL-01' ? 'display: none;' : '')+'">0</td>'
                                                +((golongan == 'GOL-02' || golongan == 'GOL-03') ? '' : '<td>')+'<input type="'+((golongan == 'GOL-02' || golongan == 'GOL-03') ? 'hidden' : 'number')+'" min="0" class="form-control '+jumlahKaryawan+' bonus'+jumlahKaryawan+'" value="0" name="bonus[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')" '+(golongan == 'GOL-01' ? 'readonly' : '')+'>'
                                                +((golongan == 'GOL-01' || golongan == 'GOL-02' || golongan == 'GOL-03') ? '' : '<td>')+'<input type="'+((golongan == 'GOL-01' || golongan == 'GOL-02' || golongan == 'GOL-03') ? 'hidden' : 'number')+'" min="0" class="form-control '+jumlahKaryawan+' jumlahBonus'+jumlahKaryawan+'" value="0" name="jumlahBonus[]" onchange="perubahanTotalGaji(this, '+jumlahKaryawan+')">'
                                                +'<input type="hidden" class="subtotalBonus'+jumlahKaryawan+'" value="0" name="subtotalBonus[]">';

                        bodyTabelKaryawan   = bodyTabelKaryawan
                                                +'<td class="totalGajiKaryawan'+jumlahKaryawan+'" style="text-align: right; vertical-align: middle; background-color: #eeffcc;">0</td>'
                                                +'<input type="hidden" class="totalGaji'+jumlahKaryawan+'" value="0" name="totalGaji[]">';

                        bodyTabelKaryawan   = bodyTabelKaryawan + '</tr>' + '</tbody>';

                        bodyTabelKaryawan   = bodyTabelKaryawan
                                            +'<input type="hidden" class="golonganKaryawan" value="'+golongan+'" name="golonganKaryawan">'
                                            +'<input type="hidden" value="'+jumlahBarang+'" name="jumlahBarang">';
                    });

                    tabelKaryawan           = tabelKaryawan + bodyTabelKaryawan;

                    $('#tabelKaryawan').append(tabelKaryawan);
                    
                    $('.hariKerja').each(function() {
                        $(this).on('change', function() {
                            var id      = $(this).attr('id');
                            var hariKerja   = +($('#'+id).val());
                            var minggu  = $('.lemburMinggu'+id).val();
                            console.log(id + ', ' + hariKerja + ', ' + minggu);
                            if (hariKerja < 7) {
                                $('.subtotalLemburMinggu'+id).attr('value', '0');
                                $('.subtotalLemburMinggu'+id).attr('readonly', 'readonly');
                                perubahanTotalGaji($(this), id);
                            }
                            else {
                                $('.subtotalLemburMinggu'+id).removeAttr('readonly');
                                $('.subtotalLemburMinggu'+id).attr('value', minggu);
                                perubahanTotalGaji($(this), id);
                            }
                        });
                    });
                }
            });
        }
    });
});

function perubahanTotalGaji(selector, id) {
    var subtotalGaji                =   +($('.gajiKaryawan'+id).val()) * +($('.jumlahHariKerja'+id).val());
    $('.subtotalGaji'+id).val(subtotalGaji);

    var subtotalLemburHarian        =   +($('.lemburHarian'+id).val()) * +($('.jumlahLemburHarian'+id).val());
    $('.subtotalLemburHarian'+id).val(subtotalLemburHarian);

    var subtotalLemburMinggu        = +($('.subtotalLemburMinggu'+id).val());

    var subtotalLemburJam           =   +($('.lemburJam'+id).val()) * +($('.jumlahLemburJam'+id).val());
    $('.subtotalLemburJam'+id).val(subtotalLemburJam);

    var nomor = 0;
    var subtotalHargaBarang         = 0;
    $('.jumlahBarang'+id).each(function() {
        nomor = nomor + 1;
        var harga   =   (+($(this).val())) * (+($('.hargaBarang'+nomor).val()));
        subtotalHargaBarang         = subtotalHargaBarang + harga;
    });
    $('.subtotalHargaBarang'+id).val(subtotalHargaBarang);

    var subtotalBonus = 0;
    if ($('.golonganKaryawan').val() == 'GOL-01') {
        var bonus   = 0;
        var jumlah  = 0;
        for (var i = 1; i <= 4; i++) {
            var jumlahBarang = +($('.barangKaryawan'+i+id).val());

            if (i == 3 || i == 4) {
                jumlahBarang = Math.round(jumlahBarang * 36 / 30);
            }

            jumlah = jumlah + jumlahBarang;
        }
        $('.konversiBarang'+id).html(jumlah);

        if (jumlah>=20 && jumlah<25) { bonus = jumlah * 1000; }
        else if (jumlah == 25) { bonus = 30000; }
        else if (jumlah == 26) { bonus = 31000; }
        else if (jumlah == 27) { bonus = 32000; }
        else if (jumlah == 28) { bonus = 33000; }
        else if (jumlah == 29) { bonus = 34000; }
        else if (jumlah >= 30) { bonus = 40000; }
        else { bonus = 0; }
        $('.bonus'+id).val(bonus);

        var jumlahBonus = 1;

        subtotalBonus = bonus * jumlahBonus;

        $('.jumlahBonus'+id).val(jumlahBonus);
        $('.subtotalBonus').val(subtotalBonus);
    }
    else {
        subtotalBonus       =   (+($('.bonus'+id).val())) * (+($('.jumlahBonus'+id).val()));
    }
    $('.subtotalBonus'+id).val(subtotalBonus);

    var totalGajiKaryawan           = subtotalGaji + subtotalLemburHarian + subtotalLemburMinggu + subtotalLemburJam + subtotalHargaBarang + subtotalBonus;
    $('.totalGajiKaryawan'+id).html(number_format(number_roundup(totalGajiKaryawan), 0, '.', ','));
    $('.totalGaji'+id).val(number_roundup(totalGajiKaryawan));
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

function number_roundup(number) {
    number = Math.round(number);
    number = number.toString();
    var number_length = number.length;
    var hundreds = +(number.substr(-3));
    var after_hundreds = +(number.substr(0, number_length-3));
    var roundup = '';
    if (hundreds >= 100) {
        hundreds = '000';
        after_hundreds = after_hundreds + 1;
        after_hundreds = after_hundreds.toString();
        roundup = after_hundreds + hundreds;
    }
    else {
        hundreds = '000';
        after_hundreds = after_hundreds.toString();
        roundup = after_hundreds + hundreds;
    }
    return roundup;
}
</script>
@endpush
