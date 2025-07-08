@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">DATA ITEM</h1>

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

                    <a href="{{ route('masteritem.create') }}" class="btn btn-success" data-function="tambah">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Item
                    </a><br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <table class="table table-striped" id="table-item">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Jenis Item</th>
                                <th>Satuan</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Harga Grosir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
        $('#table-item').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('api.masteritem') !!}",
            columns: [{
                    data: 'KodeItem',
                    name: 'KodeItem'
                },
                {
                    data: 'NamaItem',
                    name: 'NamaItem'
                },
                {
                    data: 'jenisitem',
                    name: 'jenisitem'
                },
                {
                    data: 'KodeSatuan',
                    name: 'KodeSatuan'
                },
                {
                    data: 'HargaJual',
                    name: 'HargaJual',
                    render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')
                },
                {
                    data: 'HargaBeli',
                    name: 'HargaBeli',
                    render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')
                },
                {
                    data: 'HargaGrosir',
                    name: 'HargaGrosir',
                    render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
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