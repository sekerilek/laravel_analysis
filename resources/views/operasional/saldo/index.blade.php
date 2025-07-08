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
                    <h1>Saldo</h1><br>

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
                        <a href="{{ url('/saldo/showkonversi')}}" class="btn btn-success">
                            <i class="fa fa-exchange" aria-hidden="true"></i> Konversi Saldo
                        </a>
                        <a href="{{ url('/saldo/history')}}" class="btn btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> Histori Saldo
                        </a>
                        <br><br>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>Saldo Cash</label>
                                <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($saldo->SaldoCash), 0, ',', '.') .",-"}}">
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                        <div class="col-md-12">`</div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>Saldo Rekening</label>
                                <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp. " . number_format(($saldo->SaldoRekening), 0, ',', '.') .",-"}}">
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
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
</script>
@endpush