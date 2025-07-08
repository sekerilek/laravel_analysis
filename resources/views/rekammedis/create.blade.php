@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <form action="{{ route('rekammedis.store') }}" method="post">
                        @csrf
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h1>Tambah Data Pelanggan</h1>
                                </div>
                                <div class="x_content">
                                    <form action="{{ route('rekammedis.store') }}" method="post" style="display:inline-block;">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <label>Kode Rekam Medis: </label>
                                            <input type="text" readonly name="KodeRekamMedis" value="{{ $newID }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Pelanggan: </label>
                                                @foreach($pelanggans as $pel)
                                                    <input type="hidden" name="KodePelanggan" class="form-control" required="required" readonly value="{{$pel->KodePelanggan}}">
                                                    <input type="text" class="form-control" readonly value="{{$pel->NamaPelanggan}}">
                                                @endforeach
                                        <div class="form-group">
                                            <label for="inputDate">Tanggal</label>
                                            <div class="input-group date" id="inputDate">
                                                <input type="text" class="form-control" name="Tanggal" id="inputDate">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>Catatan Medis: </label>
                                            <textarea style="resize: none; height:180px;" type="text" required="required" name="CatatanMedis" placeholder="Catatan Medis" class="form-control" maxlength="191"></textarea>
                                        </div>
                                </div>
                            </div>
                            <div align="center">
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    <form action="{{ url('/rekammedis/detail/'.$pel->KodePelanggan) }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
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
    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
    </script>
@endpush
