@extends('index')
@section('content')
<style type="text/css">
    #black {
        color: black;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <form action="{{ url('/kasir')}}">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#filter" type="button">
                            <h2>Filter</h2>
                        </button>
                        <button class="btn btn-default" type="submit">
                            <h2>Tampilkan semua</h2>
                        </button>
                    </form>
                </div>
                <div id="filter" class="collapse">
                    <form action="{{ url('/kasir/cari')}}" method="get">
                        <div class="x_content">
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <label>Cari:</label>
                                    <input type="text" class="form-control" name="name" value="{{Request::get('name')}}" placeholder="Kode Kasir" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label for="tanggal">Dari :</label>
                                    <div class="input-group date" id="tanggal">
                                        <input type="text" class="form-control" name="mulai" value="{{ Request::get('mulai')}}" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label for="tanggalsampai">Sampai :</label>
                                    <div class="input-group date" id="tanggalsampai">
                                        <input type="text" class="form-control" name="sampai" value="{{ Request::get('mulai')}}" />
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
                                        <!-- <input type="submit" class="btn btn-md btn-block btn-success" value="Cari"> -->
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

            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h3>Kasir</h3>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <h3>
                                <a href="{{ url('/kasir/create')}}" class="btn btn-primary pull-right" data-function="tambah">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Kasir</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Gudang</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @foreach ($kasir as $kas)
                        <tr>
                            <td>{{ $kas->KodeKasir}}</td>
                            <td>{{ \Carbon\Carbon::parse($kas->Tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $kas->NamaPelanggan }}</td>
                            <td>{{ $kas->NamaLokasi  }}</td>
                            <td>Rp. {{ number_format($kas->Total, 0, ',', '.') }},-</td>
                            <td>
                                <a href="{{ url('/kasir/show/'. $kas->KodeKasir )}}" class="btn-xs btn btn-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> <b>Lihat</b>
                                </a>
                                <a href="{{ url('/returnKasir/return/'. $kas->KodeKasir )}}" class="btn-xs btn btn-warning" data-function="return">
                                    <i class="fa fa-undo" aria-hidden="true"></i> <b>Return</b>
                                </a>
                                <a href="{{ url('/kasir/print/'. $kas->KodeKasir )}}" class="btn-xs btn btn-info" data-funtion="cetak">
                                    <i class="fa fa-print" aria-hidden="true"></i> <b>Print</b>
                                </a>
                            </td>
                        </tr>
                        @endforeach
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
    
    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#tanggalsampai').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#table').DataTable({
        "order": [],
        "pageLength": 25
    });
</script>
@endpush