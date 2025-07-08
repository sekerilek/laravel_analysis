@extends('index')
@section('content')
<style type="text/css">
    #black {
        color: black;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Biaya Operasional</h1><br>

                    <!-- Alert -->
                    @if(session()->get('created'))
                    <div class="alert alert-success alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b>{{ session()->get('created') }}</b>
                    </div>

                    @elseif(session()->get('edited'))
                    <div class="alert alert-info alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b>{{ session()->get('edited') }}</b>
                    </div>

                    @elseif(session()->get('deleted'))
                    <div class="alert alert-danger alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b>{{ session()->get('deleted') }}</b>
                    </div>

                    @elseif(session()->get('error'))
                    <div class="alert alert-warning alert-dismissible fade-show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b id="black">{{ session()->get('error') }}</b>
                    </div>
                    @endif

                    <div class="x_content">
                        <br>
                        <a href="{{ url('/pengeluarantambahan/create')}}" class="btn btn-primary" data-function="tambah">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Biaya
                        </a>
                        <br><br>
                        <table class="table table-light" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <!-- <th>Gudang</th> -->
                                    <th>Karyawan</th>
                                    <th>Nama Biaya</th>
                                    <th>Keterangan</th>
                                    <th>Metode</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($pengeluarantambahan as $p)
                            <tr>
                                <td>{{ $p->KodePengeluaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->Tanggal)->format('d-m-Y') }}</td>
                                <!-- <td>{{ $p->NamaLokasi }}</td> -->
                                <td>{{ $p->Karyawan}}</td>
                                <td>{{ $p->Nama}}</td>
                                <td>{{ $p->Keterangan }}</td>
                                <td>{{ $p->Metode}}</td>
                                <td>Rp.{{ number_format($p->Total, 0, ',', '.') }},-</td>
                                <td>
                                    <a href="{{ url('/pengeluarantambahan/edit/'.$p->KodePengeluaran)}}" class="btn-xs btn btn-primary" data-function="ubah">
                                        <i class="fa fa-pencil" aria-hidden="true"></i> Ubah
                                    </a>
                                    <a href="{{ url('/pengeluarantambahan/destroy/'.$p->id)}}" class="btn-xs btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" data-function="hapus">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
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
    
    $('#table').DataTable({
        "order": [0, "desc"],
        "pageLength": 25
    });
</script>
@endpush