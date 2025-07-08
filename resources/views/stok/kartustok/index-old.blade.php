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
                <!-- <div class="x_title"> -->
                <h1 id="header">Kartu Stok</h1><br>
                <form action="{{ url('/kartustok/show') }}" method="get" style="display:inline-block;">
                    <button class="btn btn-default" type="submit">
                        Tampilkan Semua Stok
                    </button>
                </form>
                <form style="display:inline-block;">
                    <button class="btn btn-default" data-toggle="collapse" data-target="#filteritem" type="button">
                        Filter Item
                    </button>
                </form>
                <br>
                <div id="filteritem" class="collapse">
                    <div class="x_content">
                        <div class="row">
                            <form action="{{ url('/kartustok/filter') }}" method="post">
                                @csrf
                                <div class="col-md-3">
                                    <label for="inputDate">Mulai</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="start" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <label for="inputDate">Sampai</label>
                                    <div class="input-group date" id="inputDate2">
                                        <input type="text" class="form-control" name="finish" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Item</label>
                                    <select class="form-control" name="item" id="item">
                                        @foreach($item as $l)
                                        <option value="{{$l->KodeItem}}">{{$l->NamaItem}}</option>
                                        @endforeach
                                    </select>
                                    <label>Satuan</label>
                                    <select class="form-control" name="satuan" id="satuan">
                                        @foreach($satuan as $l)
                                        <option value="{{$l->KodeSatuan}}">{{$l->KodeSatuan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Gudang</label>
                                    <select class="form-control" name="lokasi" id="lokasi">
                                        @foreach($store as $l)
                                        <option value="{{$l->KodeLokasi}}">{{$l->NamaLokasi}}</option>
                                        @endforeach
                                    </select>
                                    <label></label>
                                    <input type="submit" class="form-control btn btn-primary" value="Filter" name="">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>

            <div class="x_panel">
                <div class="x_body">
                    @if($filter == true)
                    <!-- <form action="{{ url('/kartustok/print') }}" method="post"> -->
                    @csrf
                    <!-- <div class="row pull-left"> -->
                    @if($filter)
                    <input type="hidden" value="{{$start}}" name="start">
                    <input type="hidden" value="{{$finish}}" name="finish">
                    <input type="hidden" value="{{$itemfil}}" name="item">
                    <input type="hidden" value="{{$lokasifil}}" name="lokasi">
                    <input type="hidden" value="{{$satuanfil}}" name="satuan">
                    @endif
                    <!-- <input type="submit" name="" value="Print" class="btn btn-danger"> -->
                    <!-- </div> -->
                    <!-- </form> -->
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Item</th>
                                <th>Gudang</th>
                                <th>Jenis Transaksi</th>
                                <th>Kode Transaksi</th>
                                <th>User</th>
                                <th>QTY</th>
                                <th>Saldo</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stok as $stk)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($stk->Tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $stk->NamaItem }}</td>
                                <td>{{ $stk->NamaLokasi }}</td>
                                <td>{{ $stk->JenisTransaksi }}</td>
                                <td>{{ $stk->KodeTransaksi }}</td>
                                <td>{{ $stk->KodeUser }}</td>
                                <td>{{ $stk->Qty }}</td>
                                <td>{{ $stk->saldo }}</td>
                                <td>{{ $stk->KodeSatuan }}</td>
                            </tr>
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
        "pageLength": 25
    });
    $('#lokasi').select2({
        width: '100%'
    });
    $('#item').select2({
        width: '100%'
    });
    $('#satuan').select2({
        width: '100%'
    });

    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#inputDate2').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
</script>
@endpush