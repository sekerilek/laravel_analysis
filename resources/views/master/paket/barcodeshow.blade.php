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
                            {!!DNS1D::getBarcodeSVG($barcode->KodeItem,"C39",2,30,'#2A3239')!!}
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <div class="modal-body">
                       
                    {!!DNS1D::getBarcodeSVG($barcode->KodeItem,"C39",2,30,'#2A3239')!!}
                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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

        $('#table-item').on('draw.dt', function() {
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
<!-- {!!DNS1D::getBarcodeSVG($barcode->KodeItem,"C39",2,30,'#2A3239')!!}

<input type="text" /> -->