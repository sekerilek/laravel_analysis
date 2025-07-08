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
                                <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <label>Mulai</label>
                                            <div class="input-group inputDate">
                                                <input type="text" class="form-control inputDate" name="start" value="{{ session()->get('date_start') }}">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <label>Sampai</label>
                                            <div class="input-group inputDate">
                                                <input type="text" class="form-control inputDate" name="finish" value="{{ session()->get('date_finish') }}">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </td>
                                        <td width="50%">
                                            <label>Item</label>
                                            <select class="form-control" name="item" id="item">
                                                <option value="all">Semua Item</option>
                                                @foreach(session()->get('item_list') as $l)
                                                <option value="{{$l->KodeItem}}">{{$l->NamaItem}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Cari
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>

            <div class="x_panel">
                <div class="x_body">
                    @if($filter)
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Item</th>
                                <th>Jenis Transaksi</th>
                                <th>Kode Transaksi</th>
                                <th>QTY</th>
                                <th>Saldo</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stok as $stk)
                            <tr>
                                <td>{{ date_format(date_create($stk->Tanggal), 'd F Y') }}</td>
                                <td>{{ $stk->NamaItem }}</td>
                                <td>{{ $stk->JenisTransaksi }}</td>
                                <td>{{ $stk->KodeTransaksi }}</td>
                                <td>{{ $stk->Qty }}</td>
                                <td>{{ $stk->saldo }}</td>
                                <td>{{ $stk->NamaSatuan }}</td>
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
    
    $('#item').select2({
        width: '100%'
    }).val("{{ session()->get('item') }}").trigger('change');

    $('.inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
</script>
@endpush