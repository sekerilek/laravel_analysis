@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    @foreach($pelanggans as $pel)
                    <form action="{{ url('/rekammedis/detail/'.$pel->KodePelanggan)}}">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#filter" type="button">
                            <h2>Filter</h2>
                        </button>
                        <button class="btn btn-default" type="submit">
                            <h2>Tampilkan semua</h2>
                        </button>
                    </form>
                    @endforeach
                </div>
                <div id="filter" class="collapse">
                    @foreach($pelanggans as $pel)
                    <form action="{{ url('/rekammedis/detail/'.$pel->KodePelanggan.'/cari')}}" method="get">
                        <div class="x_content">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="name" value="{{Request::get('name')}}" placeholder="Kode" />
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
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">REKAM MEDIS</h1>
                    <h2 style="text-align:center;">Nama Pelanggan : {{$pel->NamaPelanggan}}</h2>

                    <!-- Alert -->
                    @if(session()->get('created'))
                    <div class="alert alert-success alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('created') }}
                    </div>

                    @elseif(session()->get('edited'))
                    <div class="alert alert-info alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('edited') }}
                    </div>

                    @elseif(session()->get('deleted'))
                    <div class="alert alert-danger alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('deleted') }}
                    </div>
                    @endif
                    @foreach($pelanggans as $pel)
                    <a href="{{ url('/rekammedis/detail/'.$pel->KodePelanggan.'/create') }}" class="btn btn-success">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Rekam Medis
                    </a>
                    @endforeach
                    <br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    
                    <table class="table table-striped" id="table-item">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:2%;">No.</th>
                                <th>Tanggal</th>
                                <th>Kode Rekam Medis</th>
                                <th>Catatan Medis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekammedis as $rm)
                                <tr>
                                <td>{{$rm->id}}</td>
                                <td>{{$rm->Tanggal}}</td>
                                <td>{{$rm->KodeRekamMedis}}</td>
                                <td>{{$rm->CatatanMedis}}</td>
                                <td>
                                    <a href="{{ url('/rekammedis/detail/'.$pel->KodePelanggan.'/edit/'.$rm->KodeRekamMedis)}}" class="btn-xs btn btn-warning">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Ubah
                                    </a>
                                    <a href="{{ url('/rekammedis/detail/'.$pel->KodePelanggan.'/destroy/'.$rm->KodeRekamMedis)}}" class="btn-xs btn btn-danger" onclick="return showConfirm()">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Ubah
                                    </a>  
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">RIWAYAT PEMBELIAN</h1>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <table class="table table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:2%;">No.</th>
                                <th>Tanggal</th>
                                <th>Kode Kasir</th>
                                <th>Nama Item</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatpembelians as $rp)
                                <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$rp->Tanggal}}</td>
                                <td>{{$rp->KodeKasir}}</td>
                                <td>{{$rp->NamaItem}}</td>
                                <td>{{$rp->Qty}}</td>
                                <td>{{$rp->NamaSatuan}}</td>
                                <td>Rp. {{ number_format($rp->Subtotal, 0, ',', '.') }},-</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
    
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@endsection

@push('scripts')
<script>
    $('#tanggal').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#tanggalsampai').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
    function showConfirm() {
        if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
            return true;
        } else {
            return false;
        }
    }

    $('#table-item').DataTable({
        "order": [
            [0, "asc"]
        ]
    });

    

   
</script>
@endpush