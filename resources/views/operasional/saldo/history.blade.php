@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 style="text-align:center">Histori Saldo</h1><br>
                </div>
                <div class="x_body">
                    <table class="table table-striped table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Kode Transaksi</th>
                                <th>Karyawan</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Transaksi</th>
                                <th>Saldo Cash</th>
                                <th>Saldo Rekening</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saldo as $s)
                            <tr>
                                <td>{{ $s->Tanggal}}</td>
                                @if($s->KodeTransaksi == 'DEL')
                                <td>Hapus</td>
                                @elseif($s->KodeTransaksi == 'EDT')
                                <td>Update</td>
                                @else
                                <td>Tambah</td>
                                @endif
                                <td>{{ $s->Transaksi}}</td>
                                @if($s->Tipe == 'RC' || $s->Tipe == 'CR')
                                <td>-</td>
                                @else
                                <td>{{ $s->Karyawan}}</td>
                                @endif
                                <td>{{ $s->Nama}}</td>
                                <td>Rp.{{ number_format($s->Jumlah, 0, ',', '.') }},-</td>
                                @if($s->Tipe == 'RC' || $s->Tipe == 'CR')
                                <td>-</td>
                                @else
                                <td>{{ $s->Tipe }} - {{ $s->trans}}</td>
                                @endif
                                <td>Rp.{{ number_format($s->SaldoCash, 0, ',', '.') }},-</td>
                                <td>Rp.{{ number_format($s->SaldoRekening, 0, ',', '.') }},-</td>
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
        "order": [],
        "pageLength": 25
    });
</script>
@endpush