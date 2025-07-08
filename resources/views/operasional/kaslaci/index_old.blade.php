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
                    <h1>Kas Laci</h1><br>

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
                        <a href="{{ url('/laci/create')}}" class="btn btn-primary" data-function="tambah">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Biaya
                        </a>
                        <br>
                        <table class="table table-light" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nominal</th>
                                    <th>Transaksi</th>
                                    <th>Saldo</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $x = 0;
                                    $jumlahData = count($data);
                                @endphp
                                @foreach($data as $laci)
                                @php
                                    $x = $x + 1;
                                @endphp
                                @if($x == $jumlahData && ($laci->Status == 'OPN'))
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($laci->Tanggal)) }}</td>
                                    <td>{{ $laci->Nominal }}</td>
                                    <td>{{ $laci->Transaksi }}</td>
                                    <td>{{ $laci->SaldoLaci }}</td>
                                    <td>
                                        <a href="{{ url('/laci/closing/'.$laci->id.'/'.$laci->Tanggal)}}" class="btn btn-success" onclick="confirm('Tutup kas laci hari ini?')">Tutup Kas</a>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($laci->Tanggal)) }}</td>
                                    <td>{{ $laci->Nominal }}</td>
                                    <td>{{ $laci->Transaksi }}</td>
                                    <td>{{ $laci->SaldoLaci }}</td>
                                    <td></td>
                                </tr>
                                @endif
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
        "pageLength": 25
    });
</script>
@endpush