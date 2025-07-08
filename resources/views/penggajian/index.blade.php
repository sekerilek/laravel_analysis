+@extends('index')
@section('content')
<style type="text/css">
    #header {
        text-align: center;
    }

    table {
        table-layout: fixed;
    }

    table .headerTabel {
        word-wrap: break-word;
        background-color: #eeeeee;
        vertical-align: middle;
    }

    .x_body {
        border-bottom: 2px solid #E6E9ED;
        padding: 1px 5px 6px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 id="header">Sistem Penggajian</h1><br>
                    <!-- Alert -->
                    @if(session()->get('created'))
                    <div class="alert alert-success alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('created') }}
                    </div>

                    @elseif(session()->get('edited'))
                    <div class="alert alert-info alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('edited') }}
                    </div>

                    @elseif(session()->get('deleted'))
                    <div class="alert alert-danger alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('deleted') }}
                    </div>

                    @elseif(session()->get('warning'))
                    <div class="alert alert-warning alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('warning') }}
                    </div>
                    @endif
                    
                    <a href="/penggajian/absen" class="btn btn-warning" style="display: inline-block;"> ABSEN Karyawan </a>

                    <!-- <button class="btn btn-info btnHistori" name="btnHistori" data-toggle="collapse" data-target="#filteritem" type="button"> Histori ABSEN Karyawan </button> -->

                    <a href="/penggajian/gaji" class="btn btn-success" style="display: inline-block;"> GAJI Karyawan </a>

                    <button class="btn btn-default btnKoreksi" name="btnKoreksi" data-toggle="collapse" data-target="#filterlaporan" type="button"> Laporan GAJI Karyawan </button>
                    
                    <br>

                    <!-- ID filteritem -->
                    <div id="filterlaporan" class="collapse">
                        <div class="row">
                            <div class="x_content">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Tanggal Awal:</label>
                                        <div class="input-group inputDate">
                                            <input type="text" class="form-control inputDate" id="tanggal1" value="{{date('d-m-Y')}}">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Tanggal Akhir:</label>
                                        <div class="input-group inputDate">
                                            <input type="text" class="form-control inputDate" id="tanggal2" value="{{date('d-m-Y')}}">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-3 col-md-3 col-sm-3 opsiGolongan">
                                    <div class="form-group">
                                        <label>Golongan:</label>
                                        <select class="form-control golongan" name="kodeGolongan" id="golongan">
                                            <option selected disabled>-- Pilih nama golongan --</option>
                                            @foreach($list_golongan as $data)
                                            <option value="{{ $data->KodeGolongan }}">
                                                {{ $data->NamaGolongan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Cari</label>
                                        <div class="input-group">
                                            <input type="hidden" id="opsiFilter" value="">
                                            <button class="btn btn-md btn-block btn-success" id="buttonFilter">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="x_body col-md-12" id="resultfilterlaporan"></div>
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
        var id = e.target.firstElementChild.id;
        $('#'+id).attr('value', $('#'+id).val());
    });
});

$('#buttonFilter').on('click', function() {
    $('#resultfilterlaporan').empty();
    var tanggal1 = $('#tanggal1').val();
    var tanggal2 = $('#tanggal2').val();
    var date1       = +(tanggal1.substr(0,2));
    var date2       = +(tanggal2.substr(0,2));
    var month1      = +(tanggal1.substr(3,2));
    var month2      = +(tanggal2.substr(3,2));
    if (month2 < month1) {
        alert("'Tanggal Awal' harus lebih kecil atau sama dengan 'Tanggal Akhir'");
    }
    else {
        if (date2 > date1) {
            if (date2 - date1 > 7) {
                alert("'Tanggal Awal' harus berjarak 7 hari dengan 'Tanggal Akhir'");
            }
            else {
                laporanGaji(tanggal1, tanggal2);
            }
        }
        else if (date2 == date1) {
            laporanGaji(tanggal1, tanggal2);
        }
        else {
            alert("'Tanggal Awal' harus lebih kecil atau sama dengan 'Tanggal Akhir'");
        }
    }
});

function laporanGaji(tanggal1, tanggal2) {
    var url = "/penggajian/api/laporan/" + tanggal1 + "/" + tanggal2;
    console.log(url);
    $.get(url, function(data, status) {
        $('#resultfilterlaporan').html(data);
    });
}
</script>
@endpush@extends('index')
@section('content')
<style type="text/css">
    #header {
        text-align: center;
    }

    table {
        table-layout: fixed;
    }

    table .headerTabel {
        word-wrap: break-word;
        background-color: #eeeeee;
        vertical-align: middle;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 id="header">Sistem Penggajian</h1><br>
                    <!-- Alert -->
                    @if(session()->get('created'))
                    <div class="alert alert-success alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('created') }}
                    </div>

                    @elseif(session()->get('edited'))
                    <div class="alert alert-info alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('edited') }}
                    </div>

                    @elseif(session()->get('deleted'))
                    <div class="alert alert-danger alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('deleted') }}
                    </div>

                    @elseif(session()->get('warning'))
                    <div class="alert alert-warning alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('warning') }}
                    </div>
                    @endif
                    
                    <a href="/penggajian/absen" class="btn btn-warning" style="display: inline-block;"> ABSEN Karyawan </a>

                    <a href="/penggajian/gaji" class="btn btn-success" style="display: inline-block;"> GAJI Karyawan </a>
                    
                    <!-- <a href="/penggajian/gaji" class="btn btn-success" style="display: inline-block;"> GAJI Karyawan </a> -->

                    <button class="btn btn-default" data-toggle="collapse" data-target="#filteritem" type="button"> Koreksi Gaji </button>
                    
                    <br>

                    <!-- ID filteritem -->
                    <div id="filteritem" class="collapse">
                        <div class="row">
                            <div class="x_content">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Golongan:</label>
                                        <select class="form-control" name="kodeGolongan" id="golongan">
                                            <option selected disabled>-- Pilih nama golongan --</option>
                                            @foreach($list_golongan as $data)
                                            <option value="{{ $data->KodeGolongan }}">
                                                {{ $data->NamaGolongan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Bulan:</label>
                                        <select class="form-control" name="kodeBulan" id="bulan">
                                            <option selected disabled>-- Pilih bulan --</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label>Tanggal: </label>
                                        <select class="form-control" name="kodeTanggal" id="tanggal">
                                            
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="x_body" id="bodyDataRiwayat">
                    
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('#bulan').select2({
    width: '100%'
});
$('#tanggal').select2({
    width: '100%'
});
$('#golongan').select2({
    width: '100%'
});

$('#bulan').on('change', function() {
    $('#tanggal').empty();
    var bulan   = +($(this).val());
    var tanggal = '<option selected disabled>-- Pilih tanggal --</option>';
    var tahun   = +($('#tahun').val());
    if (bulan == 2) {
        for (var i = 1; i <= 28; i++) {
            tanggal = tanggal + '<option value="'+i+'">'+i+'</option>';
        }
        if (tahun % 4 == 0) {
            tanggal = tanggal + '<option value="29">29</option>';
        }
    }
    else if ((bulan % 2 == 0) && (bulan != 8) && (bulan != 2)) {
        for (var i = 1; i <= 30; i++) {
            tanggal = tanggal + '<option value="'+i+'">'+i+'</option>';
        }
    }
    else {
        for (var i = 1; i <= 31; i++) {
            tanggal = tanggal + '<option value="'+i+'">'+i+'</option>';
        }
    }

    $('#tanggal').append(tanggal);
});

$('#buttonFilter').on('click', function() {
    $.post(
        "{{ url('/penggajian/gaji/riwayat') }}",
        {
            _token: "{{ csrf_token() }}",
            golongan: $('#golongan').val(),
            bulan: $('#bulan').val(),
            tanggal: $('#tanggal').val(),
            tahun: $('#tahun').val(), 
        }
    );
});

// $('#buttonFilter').on('click', function() {
//     var karyawan     = $('#karyawan').val();
//     var bulan        = $('#bulan').val();
//     var tahun        = $('#tahun').val();

//     $('#bodyDataRiwayat').empty();
//     var tabelDataRiwayat = '';

//     $.post(
//         "{{ url('/penggajian/gaji/riwayat') }}",
//         {
//             _token: "{{ csrf_token() }}",
//             karyawan: karyawan,
//             bulan: bulan,
//             tahun: tahun, 
//         },
//         function(data) {
//             if ($.isEmptyObject(data)) { alert("Tidak terdapat data yang dicari"); }
//             else {
//                 tabelDataRiwayat    = tabelDataRiwayat
//                                     +'<table class="table table-hover" id="dataRiwayat">'
//                                     +'<thead>'
//                                     +'<tr>'
//                                     +'<th class="headerTabel">Nama</th>'
//                                     +'<th class="headerTabel">Tanggal Gajian</th>'
//                                     +'<th class="headerTabel">Total Gaji</th>'
//                                     +'<th class="headerTabel"></th>'
//                                     +'</tr>'
//                                     +'</thead>'
//                                     +'<tbody>';

//                 $.each(data, function(i, val) {
//                     tabelDataRiwayat    = tabelDataRiwayat
//                                         +'<tr>'
//                                         +'<td>'+val.Nama+'</td>'
//                                         +'<td>'+val.TanggalGaji+'</td>'
//                                         +'<td>'+val.TotalGaji+'</td>'
//                                         +'<td>'
//                                             +'<form style="display:inline-block;" type="submit" action="/penggajian/gaji/ubah/'+val.EnkripsiKodeGaji+'/'+val.KodeKaryawan+'" method="get"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>'
//                                             +'<form style="display:inline-block;" action="/penggajian/gaji/hapus/'+val.EnkripsiKodeGaji+'/'+val.KodeKaryawan+'" method="get" onsubmit="return showConfirm()"><button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>'
//                                         +'</td>'
//                                         +'</tr>';
//                 });
//                 tabelDataRiwayat    = tabelDataRiwayat + '</tbody>';


//                 tabelDataRiwayat    = tabelDataRiwayat + '</table>';

//                 $('#bodyDataRiwayat').append(tabelDataRiwayat);
//                 $('#dataRiwayat').DataTable();
//             }
//         }
//     );
// });

// function showConfirm() {
//     if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
//         return true;
//     } else {
//         return false;
//     }
// }
</script>
@endpush