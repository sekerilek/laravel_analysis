@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">DATA KARYAWAN</h1>

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

                    <a href="{{ route('masterkaryawan.create') }}" class="btn btn-success" data-function="tambah">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Karyawan
                    </a><br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <!-- <table class="table table-striped" id="table-karyawan">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Karyawan</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table> -->
                    <table class="table table-striped" id="table-karyawan">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Karyawan</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th>Alamat</th>
                                <th data-orderable="false">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($karyawan as $kar)
                            <tr>
                                <td>{{$kar->KodeKaryawan}}</td>
                                <td>{{$kar->Nama}}</td>
                                <td>{{$kar->KodeJabatan}}</td>
                                <td>{{$kar->GajiPokok}}</td>
                                <td>{{$kar->Alamat}}</td>
                                <td>
                                    <form style="display:inline-block;" type="submit" action="/masterkaryawan/{{$kar->KodeKaryawan}}/edit" method="get">
                                        <button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                                    </form>

                                    <form style="display:inline-block;" action="/masterkaryawan/delete/{{$kar->KodeKaryawan}}" method="get" onsubmit="return showConfirm()">
                                        <button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                    </form>
                                    
                                    <form style="display:inline-block;" action="/masterkaryawan/print/{{$kar->KodeKaryawan}}" method="get">
                                        <button class="btn btn-info btn-xs" data-function="cetak"><i class="fa fa-print"></i>&nbsp;Cetak</button>
                                    </form>
                                </td>
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
    $(function() {
        $('#table-karyawan').DataTable();

        $('[data-function]').each(function() {
            initPage('{{Auth::user()->name}}', $(this).data('function'));
        });
    });

    function showConfirm() {
        if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endpush