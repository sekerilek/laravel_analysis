@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">DATA PAKET</h1>

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

                    <a href="{{ route('masterpaket.create') }}" class="btn btn-success">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Paket
                    </a><br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <table class="table table-striped" id="table-item">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all as $paket)
                            <tr>
                                <td>{{ $paket->kode }}</td>
                                <td>{{ $paket->nama }}</td>
                                <td class="text-right">{{ number_format($paket->harga, 0, ',', '.') }}</td>
                                <td>
                                    <form style="display:inline-block;" action="/masterpaket/delete/' . $paket->kode . '" method="get" onsubmit="return showConfirm()">
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
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
        $('#table-item').DataTable();
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