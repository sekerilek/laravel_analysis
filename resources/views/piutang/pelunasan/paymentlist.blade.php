@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Pelunasan Piutang</h1>
                    <a href="{{ url('/pelunasanpiutang/invoice/'.$pelanggan->KodePelanggan.'')}}" class="btn btn-success pull-right">
                        <b>Pilih Invoice</b>
                    </a>
                    <br><br>
                </div>
                <div class="x_body">
                    @if(($invoice->Status == 'OPN') || ($sisa > 0))
                    <a class="btn btn-primary " href="{{url('/pelunasanpiutang/payment/'.$invoice->KodeInvoicePiutang.'/add')}}">
                        <i class="fa fa-plus" aria-hidden="true"></i> Pembayaran
                    </a>
                    @endif
                    <br><br>
                    <table class="table table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Pelunasan</th>
                                <th>Tanggal Bayar</th>
                                <th>Total Bayar</th>
                                <th>Metode</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->KodePelunasanPiutang }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->Tanggal)->format('d-m-Y') }}</td>
                                <td>Rp. {{ number_format($payment->Jumlah, 0, ',', '.') }},-</td>
                                <td>{{ $payment->TipeBayar }}</td>
                                <td>{{ $payment->Keterangan}}</td>
                                <td>
                                    <a href="{{ url('/pelunasanpiutang/payment/'.$payment->KodePelunasanPiutangID.'/edit')}}" class="btn-xs btn btn-success">
                                        <i class="fa fa-pencil" aria-hidden="true"></i> Ubah
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
    $('#table').DataTable({
        "pageLength": 25
    });
</script>
@endpush