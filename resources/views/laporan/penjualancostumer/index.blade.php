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
                <div class="x_title">
                    <h1 id="header">Penjualan Costumer</h1><br>
                    <br>
                    
                </div>
                <div class="x_body">
                    <!-- <form action="{{ url('/bukukasbesar/print') }}" method="post"> -->
                    @csrf
                    <br><br><br><br><br>
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>NamaPelanggan</th>
                                <th>Kontak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelanggan as $p)
                            <tr class="success">
                                <td>{{$p->NamaPelanggan}}</td>
                                <td>{{$p->Kontak}}</td>
                                
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
            "paging": false
        });
    });
    
    $('#table').on('draw.dt', function() {
        initPage('{{Auth::user()->name}}');
    });
    $('#bulan').select2({
        width: '100%'
    });
    $('#tanggalmulai').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#tanggalsampai').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
</script>
@endpush