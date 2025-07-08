@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <form action="{{ url('/batalPenjualan')}}">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#filter" type="button">
                            <h2>Filter</h2>
                        </button>
                        <button class="btn btn-default" type="submit">
                            <h2>Tampilkan semua</h2>
                        </button>
                    </form>
                </div>
                <div id="filter" class="collapse">
                    <form action="{{ url('/batalPenjualan/filter')}}" method="get">
                        <div class="x_content">
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <label for="tanggalpo">Dari :</label>
                                    <div class="input-group date" id="tanggalpo">
                                        <input type="text" class="form-control" name="start" value="{{ Request::get('start')}}" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <label for="tanggalposampai">Sampai :</label>
                                    <div class="input-group date" id="tanggalposampai">
                                        <input type="text" class="form-control" name="end" value="{{ Request::get('end')}}" />
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

            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h3>Pemesanan Penjualan Batal</h3>
                            <p>Sales Order<p>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <br><br>
                            <a href="{{ url('/sopenjualan/create')}}" class="btn btn-primary pull-right">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode SO</th>
                                <th>Tanggal</th>
                                <th>Tanggal Kirim</th>
                                <th>Expired</th>
                                <th>Mata Uang</th>
                                <th>Gudang</th>
                                <th>Pelanggan</th>
                                <th>Term</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @foreach ($pemesananpenjualan as $p)
                        <tr>
                            <td>{{ $p->KodeSO}}</td>
                            <td>{{ \Carbon\Carbon::parse($p->Tanggal)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_kirim)->format('d-m-Y') }}</td>
                            <td>{{ $p->Expired }}</td>
                            <td>{{ $p->NamaMataUang }}</td>
                            <td>{{ $p->NamaLokasi  }}</td>
                            <td>{{ $p->NamaPelanggan }}</td>
                            <td>{{ $p->term }}</td>
                            <td>
                                <a href="{{ url('/sopenjualan/lihat/'. $p->KodeSO )}}" class="btn-xs btn btn-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Lihat
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
    $('#tanggalpo').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#tanggalposampai').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#table').DataTable({
        "order": []
    });
</script>
@endpush