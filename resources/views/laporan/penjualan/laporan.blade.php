@extends('index')
@section('content')
<style type="text/css">
    #header {
        text-align: center;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 id="header">Penjualan</h1>
                    <h3 id="header">{{$nama}}</h3><br><br>
                    <form action="{{ url('/laporanpenjualan/'.$pelanggan) }}" method="get" style="display:inline-block;">
                        <input type="submit" value="Tampilkan Semua" class="btn btn-default">
                    </form>
                    <form style="display:inline-block;">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#filteritem" type="button">
                            Filter Bulan
                        </button>
                    </form>
                    <form style="display:inline-block;">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#filtertanggal" type="button">
                            Filter Tanggal
                        </button>
                    </form>
                    <a href="{{ url('/laporanpenjualan')}}" class="btn btn-primary pull-right">
                        <b>Pilih Pelanggan</b>
                    </a>
                    <br>
                    <div id="filteritem" class="collapse">
                        <div class="row">
                            <form action="{{ url('/laporanpenjualan/filter') }}" method="post">
                                @csrf
                                <input type="hidden" name="pelanggan" value="{{ $pelanggan }}">
                                <input type="hidden" name="nama" value="{{ $nama }}">
                                <div class="x_content">
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label>Pilihan Filter:</label>
                                            <select class="form-control" name="filter">
                                                <option value="kode">Per Kode</option>
                                                <option value="item">Per Item</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label>Bulan:</label>
                                            <select class="form-control" name="month" id="bulan">
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
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label>Tahun:</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="year" value="{{$year_now}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label></label>
                                            <div class="input-group">
                                                <button type="submit" class="btn btn-md btn-block btn-success">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="filtertanggal" class="collapse">
                        <form action="{{ url('/laporanpenjualan/filterdate')}}" method="post">
                            @csrf
                            <input type="hidden" name="pelanggan" value="{{ $pelanggan }}">
                            <input type="hidden" name="nama" value="{{ $nama }}">
                            <div class="x_content">
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label>Pilihan Filter:</label>
                                        <select class="form-control" name="filter">
                                            <option value="kode">Per Kode</option>
                                            <option value="item">Per Item</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label for="tanggalpo">Dari:</label>
                                        <div class="input-group date" id="tanggalmulai">
                                            <input type="text" class="form-control" name="start" value="{{ Request::get('start')}}" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label for="tanggalpo">Sampai:</label>
                                        <div class="input-group date" id="tanggalsampai">
                                            <input type="text" class="form-control" name="end" value="{{ Request::get('end') }}" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for=""> </label>
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-md btn-block btn-success">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="x_body">
                    @csrf
                    <table class="table table-light table-striped" id="table">
                        @if($jenis == "kode")
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode SO</th>
                                <th>Kode SJ</th>
                                <th>Nama Item</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($penjualan->Tanggal)->format('d-m-Y')}}</td>
                                <td>{{ $penjualan->KodeSO }}</td>
                                <td>{{ $penjualan->KodeSuratJalan }}</td>
                                <td>{{ $penjualan->NamaItem }}</td>
                                <td>{{ $penjualan->total }}</td>
                                <td>{{ $penjualan->KodeSatuan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($jenis == "item")
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Item</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ $penjualan->NamaItem }}</td>
                                <td>{{ $penjualan->total }}</td>
                                <td>{{ $penjualan->KodeSatuan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#table').DataTable({
        "order": [],
        "paging": false
    });
    $('#bulan').select2({
        width: '100%'
    });
    $('#tanggalmulai').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#tanggalsampai').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
</script>
@endpush