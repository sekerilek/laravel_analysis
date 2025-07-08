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
                    <!-- <h1>Invoice Hutang</h1>
                    <span>Keterangan warna</span><br>
                    <span>*hijau : sudah lunas</span><br>
                    <span>*kuning : belum lunas</span><br>
                    <span>*merah : belum lunas dan lewat jatuh tempo</span><br> -->

                    <h1 id="header">Invoice Hutang</h1><br>
                    <form action="{{ url('/invoicehutang') }}" method="get" style="display:inline-block;">
                        <input type="submit" value="Tampilkan Semua" class="btn btn-default">
                    </form>
                    <form style="display:inline-block;">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#filterbulan" type="button">
                            Pilih Bulan
                        </button>
                    </form>

                    <br>
                    <div id="filterbulan" class="collapse">
                        <div class="row">
                            <form action="{{ url('/invoicehutang/filter') }}" method="post">
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
                    <div class="col-md-4">
                        <label>Total Tagihan</label>
                        <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($total-$return), 0, ',', '.') .",-"}}">
                    </div>
                    <div class="col-md-4">
                        <label>Lunas</label>
                        <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($bayar), 0, ',', '.') .",-"}}">
                    </div>
                    <div class="col-md-4">
                        <label>Belum Lunas</label>
                        <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($total-($bayar+$return)), 0, ',', '.') .",-"}}">
                    </div>
                    <br><br><br><br><br>
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>No Invoice</th>
                                <th>No PB</th>
                                <th>Supplier</th>
                                <th>Tanggal</th>
                                <!-- <th>Jatuh Tempo</th> -->
                                <th>No Faktur</th>
                                <th>Total</th>
                                <th>Total Bayar</th>
                                <th>Total Return</th>
                                <th>Selisih</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice as $inv)

                            @if ($inv->Subtotal <= $inv->bayar + $inv->TotalReturn)
                                <tr class="success">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $inv->KodeInvoiceHutangShow}}</td>
                                    <td>{{ $inv->KodeLPB}}</td>
                                    <td>{{ $inv->NamaSupplier}}</td>
                                    <td>{{ \Carbon\Carbon::parse($inv->Tanggal)->format('d-m-Y') }}</td>
                                    <!-- <td>{{ \Carbon\Carbon::parse($inv->Tanggal)->addDays($inv->Term)->format('d-m-Y') }}</td> -->
                                    <td>{{ $inv->NoFaktur}}</td>
                                    <td>Rp. {{ number_format($inv->Subtotal, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->bayar, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->TotalReturn, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->Subtotal - $inv->bayar - $inv->TotalReturn, 0, ',', '.')}},-</td>
                                    <td>
                                        <a href="{{url('invoicehutang/print/'.$inv->KodeInvoiceHutangShow)}}" class="btn btn-xs btn-primary" onclick="return confirm('Print invoice ini?')" data-function="cetak">Print</a>
                                        @if($inv->PPN == "ya")
                                        <a href="{{url('invoicehutang/edit/'.$inv->KodeInvoiceHutangShow)}}" class="btn btn-xs btn-success" data-function="ubah">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @elseif(\Carbon\Carbon::parse($inv->Tanggal)->addDays($inv->Term) > \Carbon\Carbon::now())
                                <tr class="warning">
                                    <td>{{ $no++}}</td>
                                    <td>{{ $inv->KodeInvoiceHutangShow}}</td>
                                    <td>{{ $inv->KodeLPB}}</td>
                                    <td>{{ $inv->NamaSupplier}}</td>
                                    <td>{{ \Carbon\Carbon::parse($inv->Tanggal)->format('d-m-Y') }}</td>
                                    <!-- <td>{{ \Carbon\Carbon::parse($inv->Tanggal)->addDays($inv->Term)->format('d-m-Y') }}</td> -->
                                    <td>{{ $inv->NoFaktur}}</td>
                                    <td>Rp. {{ number_format($inv->Subtotal, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->bayar, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->TotalReturn, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->Subtotal - $inv->bayar - $inv->TotalReturn, 0, ',', '.')}},-</td>
                                    <td>
                                        <a href="{{url('invoicehutang/print/'.$inv->KodeInvoiceHutangShow)}}" class="btn btn-xs btn-primary" onclick="return confirm('Print invoice ini?')" data-function="cetak">Print</a>
                                        @if($inv->PPN == "ya")
                                        <a href="{{url('invoicehutang/edit/'.$inv->KodeInvoiceHutangShow)}}" class="btn btn-xs btn-success" data-function="ubah">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @else
                                <tr class="danger">
                                    <td>{{ $no++}}</td>
                                    <td>{{ $inv->KodeInvoiceHutangShow}}</td>
                                    <td>{{ $inv->KodeLPB}}</td>
                                    <td>{{ $inv->NamaSupplier}}</td>
                                    <td>{{ \Carbon\Carbon::parse($inv->Tanggal)->format('d-m-Y') }}</td>
                                    <!-- <td>{{ \Carbon\Carbon::parse($inv->Tanggal)->addDays($inv->Term)->format('d-m-Y') }}</td> -->
                                    <td>{{ $inv->NoFaktur}}</td>
                                    <td>Rp. {{ number_format($inv->Subtotal, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->bayar, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->TotalReturn, 0, ',', '.') }},-</td>
                                    <td>Rp. {{ number_format($inv->Subtotal - $inv->bayar - $inv->TotalReturn, 0, ',', '.')}},-</td>
                                    <td>
                                        <a href="{{url('invoicehutang/print/'.$inv->KodeInvoiceHutangShow)}}" class="btn btn-xs btn-primary" onclick="return confirm('Print invoice ini?')" data-function="cetak">Print</a>
                                        @if($inv->PPN == "ya")
                                        <a href="{{url('invoicehutang/edit/'.$inv->KodeInvoiceHutangShow)}}" class="btn btn-xs btn-success" data-function="ubah">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                        </tbody>
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
        "order": [
            [0, "desc"]
        ],
        "pageLength": 25
    });
    $('#bulan').select2({
        width: '100%'
    });
</script>
@endpush