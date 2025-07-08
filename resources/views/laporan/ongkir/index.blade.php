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
                    <form action="{{url('/ongkir/filterdate')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="x_content">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>Tanggal : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control date" name="start" value="{{date('d-m-Y')}}">
                                        <span class="input-group-addon">
                                            {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                                            <button type="submit" class="btn btn-md btn-block btn-success">
                                                <i class="fa fa-search" arial-hidden="true"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div></div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>Bulan : </label>
                                    <div class="input-group">
                                        <select class="form-control" name="bulan">
                                            <option value="" selected disabled hidden></option>
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
                                        <span class="input-group-addon">
                                            {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                                            <button type="submit" class="btn btn-md btn-block btn-success">
                                                <i class="fa fa-search" arial-hidden="true"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                {{--<div class="x_body">
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
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="x_title">
                        <h3>Total Pendapatan: Rp.</h3><br>
                    </div>
                </div>--}}
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

$('.date').datetimepicker({
    format: 'DD-MM-YYYY'
});
</script>
@endpush