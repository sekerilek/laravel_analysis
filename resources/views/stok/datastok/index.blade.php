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
                <h1 id="header">Data Stok</h1><br>
                <form style="display:inline-block;" action="{{ url('/datastok/show') }}" method="post">
                    @csrf
                    @method('post')
                    {{--<button class="btn btn-default" data-toggle="collapse" data-target="#show" type="button">
                        Tampilkan Setahun
                    </button>--}}
                    <button class="btn btn-default" type="submit">
                        Tampilkan Setahun
                    </button>
                </form>
                <form style="display:inline-block;">
                    <button class="btn btn-default" data-toggle="collapse" data-target="#filterbulan" type="button">
                        Filter Bulan
                    </button>
                </form>
                <form style="display:inline-block;">
                    <button class="btn btn-default" data-toggle="collapse" data-target="#filtertanggal" type="button">
                        Filter Tanggal
                    </button>
                </form>
                <br>
                {{--<div id="show" class="collapse">
                    <div class="row">
                        <form action="{{ url('/datastok/show') }}" method="post">
                            @csrf
                            <div class="x_content">
                                <div class="col-md-3 col-sm-3">
                                    <label>Satuan</label>
                                    <select class="form-control" name="satuan" id="satuan">
                                        <option value="kg">Kg</option>
                                        <option value="sak">Sak</option>
                                        <option value="semua">Terkecil</option>
                                    </select>
                                    <label></label>
                                    <input type="submit" class="form-control btn btn-primary" value="Filter">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>--}}
                <div id="filterbulan" class="collapse">
                    <div class="row">
                        <form action="{{ url('/datastok/filter') }}" method="post">
                            @csrf
                            @method('post')
                            <input type="hidden" name="type" value="month">
                            <div class="x_content">
                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Bulan:</label>
                                        <select class="form-control" name="month" id="bulan">
                                            <option value="" selected disabled hidden>Pilih Bulan</option>
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
                                            <input type="text" class="form-control" name="year" value="{{session()->get('year')}}" pattern="[0-9]{4}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="filtertanggal" class="collapse">
                    <div class="x_content">
                        <div class="row">
                            <form action="{{ url('/datastok/filter') }}" method="post">
                                @csrf
                                @method('post')
                                <input type="hidden" name="type" value="date">
                                <div class="col-md-3">
                                    <label for="inputDate">Mulai</label>
                                    <div class="input-group inputDate">
                                        <input type="text" class="form-control inputDate" name="start" value="{{session()->get('date_start')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <label for="inputDate">Sampai</label>
                                    <div class="input-group inputDate">
                                        <input type="text" class="form-control inputDate" name="finish" value="{{session()->get('date_finish')}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <input type="submit" class="form-control btn btn-primary" value="Filter" name="">
                                </div>
                                {{--<div class="col-md-3">
                                    <label>Satuan</label>
                                    <select class="form-control" name="satuan" id="satuan">
                                        <option value="kg">Kg</option>
                                        <option value="sak">Sak</option>
                                        <option value="semua">Terkecil</option>
                                    </select>
                                    <label></label>
                                    <input type="submit" class="form-control btn btn-primary" value="Filter" name="">
                                </div>
                                <div class="col-md-3">
                                </div>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="x_panel">
                <div class="x_body">
                    @if($filter == true)
                    <table class="table table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Item</th>
                                <th>Satuan</th>
                                <th>Stok Awal</th>
                                <th>Stok Masuk</th>
                                <th>Stok Keluar</th>
                                <th>Stok Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stok as $s)
                            <tr>
                                <td>{{$s->NamaItem}}</td>
                                <td>{{$s->NamaSatuan}}</td>
                                <td>{{$s->StokAwal}}</td>
                                <td>{{$s->StokMasuk - $s->StokAwal}}</td>
                                <td>{{$s->StokKeluar * -1}}</td>
                                <td>{{$s->StokAkhir}}</td>
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

    $('#bulan').select2({
        width: '100%'
    });

    $('.inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
</script>
@endpush