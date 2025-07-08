@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Laporan Ongkir</h1><br>
                </div>

                <div id="filterlaporan">
                    <form action="{{url('/ekspedisi/filterdate')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="x_content">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal : </label>
                                    <div class="input-group" id="date1">
                                        <input type="text" class="form-control" name="start" id="tanggal" value="{{date('d-m-Y')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clo-md-2 col-sm-2">
                        <div class="form-group">
                            <label for=""></label>
                            <div class="input-group">
                            <button type="submit" class="btn btn-md btn-block btn-success">
                            <i class="fa fa-search" arial-hidden="true"></i>
                        </button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>

                <div class="x_body">
                    <div class="x_title">
                        <h3>Laporan</h3><br>
                    </div>
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Kode Transaksi</th>
                                <th>Modal</th>
                                <th>Tarif Pelanggan</th>
                                <th>Total Profit</th>
                                <th>Total</th>
                            </tr>
                            @foreach($eks as $eks)
                            <tr>
                                <th>{{$eks->ID}}</th>
                                <th>{{$eks->Kode}}</th>
                                <th>{{$eks->Modal}}</th>
                                <th>{{$eks->TarifPelanggan}}</th> 
                                <th>{{$eks->Profit}}</th>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="x_title">
                        <h3>Total Pendapatan: Rp. {{ number_format($total->tot, 0, ',', '.') }},-</h3><br>
                    </div>
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

$('#date1').datetimepicker({
    format: 'DD-MM-YYYY'
});

$('#date2').datetimepicker({
    defaultDate: new Date(),
    format: 'DD-MM-YYYY'
});

$("#tanggal1").on("dp.change", function(e) {
    $(this).attr('value', $("#tanggal1").val());
});

$("#tanggal2").on("dp.change", function(e) {
    $(this).attr('value', $("#tanggal2").val());
});
</script>
@endpush