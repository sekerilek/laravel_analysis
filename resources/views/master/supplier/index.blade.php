@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">DATA SUPPLIER</h1>

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

                    <a href="{{ route('mastersupplier.create') }}" class="btn btn-success" data-function="tambah">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Supplier
                    </a><br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <table class="table table-striped" id="table-supplier">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Supplier</th>
                                <th>Nama Supplier</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th>Kota</th>
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
        $('#table-supplier').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('api.mastersupplier') !!}",
            columns: [{
                    data: 'KodeSupplier',
                    name: 'KodeSupplier'
                },
                {
                    data: 'NamaSupplier',
                    name: 'NamaSupplier'
                },
                {
                    data: 'Kontak',
                    name: 'Kontak'
                },
                {
                    data: 'Alamat',
                    name: 'Alamat'
                },
                {
                    data: 'Kota',
                    name: 'Kota'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#table-supplier').on('draw.dt', function() {
            $('[data-function]').each(function() {
                initPage('{{Auth::user()->name}}', $(this).data('function'));
            });
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