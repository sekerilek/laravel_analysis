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
                    <h1 id="header">Kas Besar</h1><br>
                    <form action="{{ url('/bukukasbesar/show') }}" method="get" style="display:inline-block;">
                        <input type="submit" value="Tampilkan Setahun" class="btn btn-default">
                    </form>
                    <form style="display:inline-block;">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#filteritem" type="button">
                            Pilih Bulan
                        </button>
                    </form>
                    <br>
                    <div id="filteritem" class="collapse">
                        <div class="row">
                            <form action="{{ url('/bukukasbesar/filter') }}" method="post">
                                @csrf
                                <div class="x_content">
                                    <div class="col-md-3 col-sm-3">
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
                </div>
                <div class="x_body">
                    @if($filter == true)
                    <!-- <form action="{{ url('/bukukasbesar/print') }}" method="post"> -->
                    @csrf
                    <div class="col-md-4">
                        <label>Total Pengeluaran</label>
                        <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($hutang+$return), 0, ',', '.') .",-"}}">
                    </div>
                    <div class="col-md-4">
                        <label>Total Pemasukan</label>
                        <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($piutang+$kasir), 0, ',', '.') .",-"}}">
                    </div>
                    <div class="col-md-4">
                        <label>Saldo Akhir</label>
                        <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($piutang+$kasir-$hutang-$return), 0, ',', '.') .",-"}}">
                    </div>
                    <br><br><br><br><br>
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode Kas</th>
                                <th>Kode Invoice</th>
                                <th>Tipe</th>
                                <th>Metode</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kas as $k)
                            @if ($k->Tipe == 'AR')
                            <tr class="success">
                                <td>{{ $no++ }}</td>
                                <td>{{ $k->Tanggal }}</td>
                                <td>{{ $k->KodeKasBank }}</td>
                                <td>{{ $k->KodeInvoice }}</td>
                                <td>Piutang</td>
                                <td>{{ $k->KodeBayar }}</td>
                                <td>Rp. {{ number_format($k->Total, 0, ',', '.') }},-</td>
                            </tr>
                            @elseif ($k->Tipe == 'AP')
                            <tr class="danger">
                                <td>{{ $no++ }}</td>
                                <td>{{ $k->Tanggal }}</td>
                                <td>{{ $k->KodeKasBank }}</td>
                                <td>{{ $k->KodeInvoice }}</td>
                                <td>Hutang</td>
                                <td>{{ $k->KodeBayar }}</td>
                                <td>Rp. {{ number_format($k->Total, 0, ',', '.') }},-</td>
                            </tr>
                            @elseif ($k->Tipe == 'KS')
                            <tr class="success">
                                <td>{{ $no++ }}</td>
                                <td>{{ $k->Tanggal }}</td>
                                <td>{{ $k->KodeKasBank }}</td>
                                <td>{{ $k->KodeInvoice }}</td>
                                <td>Kasir</td>
                                <td>{{ $k->KodeBayar }}</td>
                                <td>Rp. {{ number_format($k->Total, 0, ',', '.') }},-</td>
                            </tr>
                            @elseif ($k->Tipe == 'RKS')
                            <tr class="danger">
                                <td>{{ $no++ }}</td>
                                <td>{{ $k->Tanggal }}</td>
                                <td>{{ $k->KodeKasBank }}</td>
                                <td>{{ $k->KodeInvoice }}</td>
                                <td>Return Kasir</td>
                                <td>{{ $k->KodeBayar }}</td>
                                <td>Rp. {{ number_format($k->Total, 0, ',', '.') }},-</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    @endif
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
        "paging": false
    });
    $('#bulan').select2({
        width: '100%'
    });
</script>
@endpush