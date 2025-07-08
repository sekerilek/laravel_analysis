@extends('index')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 id="header">Absen Karyawan</h3>
            </div>


            <div class="x_content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label>Tanggal Awal : </label>
                            <div class="input-group inputDate">
                                <input type="text" class="form-control" id="tanggal1" value="{{date('d-m-Y')}}" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label>Tanggal Akhir : </label>
                            <div class="input-group inputDate">
                                <input type="text" class="form-control" id="tanggal2" value="{{date('d-m-Y')}}" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label>Golongan : </label>
                            <select class="form-control namaGolongan">
                                <option selected disabled hidden>-- Pilih Golongan --</option>
                                @foreach($daftarGolongan as $golongan)
                                    <option value="{{ $golongan->KodeGolongan }}">{{ $golongan->NamaGolongan }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="idGolongan" value="">
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label>&nbsp;</label>
                            <div class="input-group">
                                <button class="btn btn-md btn-block btn-success" id="buttonFilter">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ url('/penggajian/absen/simpan') }}" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="namaGolongan" name="namaGolongan" value="">
                        <input type="hidden" class="form-control tanggal1" name="tanggalAbsen1" value="{{date('d-m-Y')}}" >
                        <input type="hidden" class="form-control tanggal2" name="tanggalAbsen2" value="{{date('d-m-Y')}}" >
                        <table class="table" id="tabelAbsensi">
                            
                        </table>

                        <button type="submit" class="btn btn-success" id="buttonSimpanAbsen" style="width:120px;" onclick="return confirm('Simpan data absen ini?')" disabled>Simpan</button>
                        <a href="/penggajian" class="btn btn-danger" style="width:120px;">Batal</a>
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

$('.inputDate').datetimepicker({
    format: 'DD-MM-YYYY',
});


$(".inputDate").each(function() {
    $(this).on("dp.change", function(e) {
        var id = e.target.firstElementChild.id
        $('.'+id).attr('value', $('#'+id).val());
    });
});

$(".namaGolongan").on('change', function() {
    var kode = $(this).val();
    $('#idGolongan').attr('value', kode);

    var nama = $('.namaGolongan option:selected').html();
    console.log(nama);
    $('#namaGolongan').attr('value', nama);
});

$('#buttonFilter').on('click', function() {
    var cekGolongan = $('#idGolongan').attr('value');
    if (cekGolongan == '') {
        alert('Mohon untuk pilih golongan terlebih dahulu');
    } else {
        var tanggal1 = $('.tanggal1').val();
        var tanggal2 = $('.tanggal2').val();
        var golongan = $('#idGolongan').val();

        var url = '/penggajian/api/absen/'+tanggal1+'/'+tanggal2+'/'+golongan;
        console.log(url);
        $('#tabelAbsensi').empty();
        $.get(url, function(data) {
            $('#tabelAbsensi').html(data);

            $('#semuaMasuk').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.absenSemua:checkbox').prop('checked', true);
                    $('.absenSemua').attr('value', '1');
                }
                else {
                    $('.absenSemua:checkbox').prop('checked', false);
                    $('.absenSemua').attr('value', '0');
                }

                var val = $('.absenSemua').val();
                $('.statusAbsen').attr('value', val);
                if (val == "1") {
                    $('.statusAbsen:checkbox').prop('checked', true);
                } else {
                    $('.statusAbsen:checkbox').prop('checked', false);
                }
            });

            $('.absenSemua:checkbox').each(function() {
                $(this).on('change', function() {
                    var id  = $(this).attr('id');
                    if ($(this).is(':checked')) {
                        $('.'+id+':checkbox').prop('checked', true);
                        $('.'+id).attr('value', '1');
                    }
                    else {
                        $('.'+id+':checkbox').prop('checked', false);
                        $('.'+id).attr('value', '0');
                    }

                    if ($('.absenSemua:checked').length == $('.absenSemua:checkbox').length) {
                        $('#semuaMasuk:checkbox').prop('checked', true);
                    }
                    else {
                        $('#semuaMasuk:checkbox').prop('checked', false);
                    }
                });
            });

            $('.statusAbsen:checkbox').each(function() {
                $(this).on('change', function() {
                    var id  = $(this).attr('id');
                    var nomor = id.split('_');
                    if ($(this).is(':checked')) {
                        $('#'+id+':checkbox').prop('checked', true);
                        $('.'+nomor[0]).attr('value', '1');
                    }
                    else {
                        $('#'+id+':checkbox').prop('checked', false);
                        $('.'+nomor[0]).attr('value', '0');
                    }

                    if ($('.statusAbsen.'+nomor[0]+':checked').length == $('.statusAbsen.'+nomor[0]+':checkbox').length) {
                        $('.absenSemua.'+nomor[0]+':checkbox').prop('checked', true);
                    }
                    else {
                        $('.absenSemua.'+nomor[0]+':checkbox').prop('checked', false);
                    }

                    if ($('.absenSemua:checked').length == $('.absenSemua:checkbox').length) {
                        $('#semuaMasuk:checkbox').prop('checked', true);
                    }
                    else {
                        $('#semuaMasuk:checkbox').prop('checked', false);
                    }
                });
            });
        });

        $('#buttonSimpanAbsen').removeAttr('disabled');
    }
});

</script>
@endpush