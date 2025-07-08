@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Pelunasan Piutang</h1><br>
                </div>
                <div class="x_body">
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggans as $pelang)
                            <tr>
                                <td>{{ $pelang->NamaPelanggan}}</td>
                                <td>
                                    <a href="{{url('pelunasanpiutang/invoice/'.$pelang->KodePelanggan)}}" class="btn btn-sm btn-primary">
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
        "order": [
            [0, "asc"]
        ]
    });
</script>
@endpush