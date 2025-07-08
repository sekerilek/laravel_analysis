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
                <div class="x_body">
                        <!-- <div class="x_title"> -->
                        <h1 id="header">Ekspedisi</h1>
                        <!-- </div> -->
                    <!-- <input type="submit" name="" value="Print" class="btn btn-danger"> -->
                    <!-- </div> -->
                    <!-- </form> --><a href="{{ route('ekspedisi-create') }}" class="btn btn-success" data-function="tambah">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Ekspedisi
                    </a><br><br>
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Ekspedisi</th>
                                <th>Nama Ekspedisi</th>
                                <th>Modal</th>
                                <th>Tarif Pelanggan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eks as $item)
                            <tr>
                                <td>{{ $item->KodeEkspedisi }}</td>
                                <td>{{ $item->NamaEkspedisi }}</td>
                                <td>{{ $item->Modal }}</td>
                                <td>{{ $item->TarifPelanggan }}</td>
                                <td>
                                    <form style="display:inline-block;" type="submit" action="/ekspedisi/edit/{{$item->ID}}" method="get">
                                        <button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                                    </form>

                                    <form style="display:inline-block;" action="/ekspedisi/delete/{{$item->ID}}" method="get" onsubmit="return showConfirm()">
                                        <button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
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
@endsection

@push('scripts')
<script type="text/javascript">
$(function() { 
    $('#table').DataTable({
        "order": [],
        "pageLength": 10
    });
});

$('#table').on('draw.dt', function() {
    initPage('{{Auth::user()->name}}');
});

$('#satuan').select2({
    width: '100%'
});
</script>
@endpush