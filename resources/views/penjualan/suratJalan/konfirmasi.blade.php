@extends('index')
@section('content')
<div class="container">
    <div class="x_panel">
        <div class="x_title">
            <form action="{{ url('/konfirmasiSuratJalan')}}">
                <button class="btn btn-default" data-toggle="collapse" data-target="#filter" type="button">
                    <h2>Filter</h2>
                </button>
                <button class="btn btn-default" type="submit">
                    <h2>Tampilkan semua</h2>
                </button>
            </form>
        </div>
        <div id="filter" class="collapse">
            <form action="{{ url('/konfirmasiSuratJalan/cari')}}" method="get">
                <div class="x_content">
                    <div class="col-md-5 col-sm-5">
                        <div class="form-group">
                            <label for="tanggalpo">Cari:</label>
                            <input type="text" class="form-control" name="name" value="{{Request::get('name')}}" placeholder="Nomor SO / Nomor SJ / Nama Pelanggan" />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="tanggalpo">Dari:</label>
                            <div class="input-group date" id="start">
                                <input type="text" class="form-control" name="start" value="{{ Request::get('start')}}" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="tanggalpo">Sampai:</label>
                            <div class="input-group date" id="end">
                                <input type="text" class="form-control" name="end" value="{{ Request::get('end') }}" />
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

    <!-- Alert -->
    @if(session()->get('created'))
    <div class="alert alert-success alert-dismissible fade-show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <b>{{ session()->get('created') }}</b>
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

    @elseif(session()->get('error'))
    <div class="alert alert-warning alert-dismissible fade-show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
    </div>
    @endif

    <div class="x_panel">
        <div class="x_title">
            <h3>Konfirmasi Surat Jalan</h3>
        </div>
        <div class="x_content">
            <table class="table table-light table-striped" id="table">
                <thead>
                    <tr>
                        <th scope="col">Nomor SJ</th>
                        <th scope="col">Nomor SO</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Gudang</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suratjalans as $suratjalan)
                    <tr>
                        <td>{{ $suratjalan->KodeSuratJalan }}</td>
                        <td>{{ $suratjalan->KodeSO}}</td>
                        <td>{{ $suratjalan->NamaPelanggan}}</td>
                        <td>{{ \Carbon\Carbon::parse($suratjalan->Tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $suratjalan->NamaLokasi}}</td>
                        <td>Rp. {{ number_format($suratjalan->Subtotal, 0, ',', '.') }},-</td>
                        <td>
                            <a href="{{ url('/suratJalan/view/'.$suratjalan->KodeSuratJalanID ) }}" class="btn-xs btn btn-primary">
                                <i class="fa fa-eye" aria-hidden="true"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#start').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#end').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#table').DataTable({
        "order": [],
        "pageLength": 25
    });
</script>
@endpush