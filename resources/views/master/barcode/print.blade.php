@extends('index1')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">Data Barcode Item</h1>
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
                </div>
            </div>
            <script>window.print();</script>
            <div class="x_panel">
            <div class="container">
                <div class="row">
                @foreach($item as $i)    
                <div class="col-sm-3">
                        
                        <div class="panel panel-primary">
                        <div class="panel-heading">{{$i->NamaItem}}</div>
                        <div class="panel-body" align="center">{!!DNS1D::getBarcodeSVG($i->KodeItem,"C39",2,45,'#2A3239')!!}</div>
                        </div>
                        
                    </div>
                    @endforeach
                </div>
            </div>
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