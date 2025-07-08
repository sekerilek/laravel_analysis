@extends('index')
@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Laporan Rugi Laba</h1><br>
                   
                </div>
                
                <div id="filterlaporan">
                    <div class="row">
                        <form action="{{ url('/laporanrugilabacostumer/buat') }}" method="get" >
                         <div class="x_content">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Nama Pelanggan </label>
                                    <select class="form-control" name="namapelanggan" id="namapelanggan">
                                    @foreach($pelanggan as $pel)    
                                    <option value="{{$pel->KodePelanggan}}">{{$pel->NamaPelanggan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Jenis Laporan: </label>
                                    <select class="form-control" name='jenislaporan' id="jenisLaporan">
                                        <option value="suratjalan">Surat Jalan</option>
                                        <option value="kasir">Kasir</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Transaksi: </label>
                                    <input type="date" class="form-control" name="start" id="tanggal" value="{{date('d-m-y')}}"></input>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label>Buat Laporan</label>
                                    <div class="input-group">
                                        <input type="hidden" id="opsiFilter" value="">
                                        <button class="btn btn-md btn-block btn-success" id="buttonFilter">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
</form>
                    </div>
                </div>
                <div class="x_body">
                    <div class="x_title">
                        <h3>Laporan</h3><br>
                    </div>
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>No Nota</th>
                                <th>Tgl Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Total Profit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lapor as $lapor)
                            <tr>
                                <td>{{$lapor->Nota}}</td>
                                <td>{{$lapor->Tanggal}}</td>
                                <td>{{$lapor->NamaPelanggan}}</td>
                                <td>{{$lapor->Total}}</td>
                                <td>{{$lapor->Profit}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="x_title">
                        <h3>Total Pendapatan : {{$profit->tot}}<br>
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
function detailLaporan(kode) {
    console.log(kode);
    var jenis = $('#jenisLaporan').val();
    $('#table2').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            "url": "{!! route('laporan.detail') !!}",
            "data": {
                "kode": kode,
                "laporan": jenis
            }
        },
        columns: [
            {
                data: 'Barang',
                name: 'Barang'
            },
            {
                data: 'Jumlah',
                name: 'Jumlah'
            },
            {
                data: 'Satuan',
                name: 'Satuan'
            },
            {
                data: 'HargaJual',
                name: 'HargaJual'
            },
            {
                data: 'HargaBeli',
                name: 'HargaBeli'
            },
            {
                data: 'Subtotal',
                name: 'Subtotal'
            },
            {
                data: 'Profit',
                name: 'Profit'
            }
        ],
        "pageLength": 10
    });
}
</script>
@endpush