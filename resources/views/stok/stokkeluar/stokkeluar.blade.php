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

    table th,
    table td {
        padding: 10px;
        text-align: left;
    }

    #header {
        text-align: center;
    }

    #black {
        color: black;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 id="header">Stok Keluar</h1><br>
                    <form action="{{ url('/stokkeluar') }}" method="get" style="display:inline-block;">
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
                    <a href="{{ url('/stokkeluar/create')}}" class="btn btn-primary pull-right" data-function="tambah">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                    <br>
                    <div id="filteritem" class="collapse">
                        <div class="row">
                            <form action="{{ url('/stokkeluar/filter') }}" method="post">
                                @csrf
                                <div class="x_content">
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label>Pilihan Filter:</label>
                                            <select class="form-control" name="jenis">
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
                        <form action="{{ url('/stokkeluar/filterdate')}}" method="post">
                            @csrf
                            <div class="x_content">
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label>Pilihan Filter:</label>
                                        <select class="form-control" name="jenis">
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

                <!-- Alert -->
                @if(session()->get('created'))
                <div class="alert alert-success alert-dismissible fade-show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <b>{{ session()->get('created') }}</b>
                </div>

                @elseif(session()->get('edited'))
                <div class="alert alert-info alert-dismissible fade-show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <b>{{ session()->get('edited') }}</b>
                </div>

                @elseif(session()->get('deleted'))
                <div class="alert alert-danger alert-dismissible fade-show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <b>{{ session()->get('deleted') }}</b>
                </div>

                @elseif(session()->get('error'))
                <div class="alert alert-warning alert-dismissible fade-show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <b id="black">{{ session()->get('error') }}</b>
                </div>
                @endif

                <div class="x_body">
                    <table class="table table-light table-striped" id="table">
                        @if($filter == false)
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Stok Keluar</th>
                                <th>Gudang</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Total Item</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokkeluars as $stokkeluar)
                            <tr>
                                <td>{{ $stokkeluar->KodeStokKeluar}}</td>
                                <td>{{ $stokkeluar->NamaLokasi}}</td>
                                <td>{{ \Carbon\Carbon::parse($stokkeluar->Tanggal)->format('d-m-Y')}}</td>
                                <td>{{ $stokkeluar->Keterangan}}</td>
                                <td>{{ $stokkeluar->TotalItem}}</td>
                                <td>
                                    <a href="{{ url('/stokkeluar/view/'.$stokkeluar->KodeStokKeluar) }}" class="btn-xs btn btn-primary">
                                        <i class="fa fa-eye" aria-hidden="true"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($filter == true)
                        @if($jenis == "kode")
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Nama Item</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokkeluars as $stokkeluar)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($stokkeluar->Tanggal)->format('d-m-Y')}}</td>
                                <td>{{ $stokkeluar->KodeStokKeluar}}</td>
                                <td>{{ $stokkeluar->NamaItem}}</td>
                                <td>{{ $stokkeluar->total}}</td>
                                <td>{{ $stokkeluar->KodeSatuan}}</td>
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
                            @foreach ($stokkeluars as $stokkeluar)
                            <tr>
                                <td>{{ $stokkeluar->NamaItem }}</td>
                                <td>{{ $stokkeluar->total }}</td>
                                <td>{{ $stokkeluar->KodeSatuan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
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
    $(function() {
        if ($('body').has('[data-function]')) {
            $('[data-function]').each(function() {
                initPage('{{Auth::user()->name}}', $(this).data('function'));
            });
        }
        else {
            initPage('{{Auth::user()->name}}');
        }
    });
    
    $('#table').DataTable({
        "order": [],
        "pageLength": 25
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