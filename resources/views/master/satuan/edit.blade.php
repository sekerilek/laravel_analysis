@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Satuan</h1>
                </div>
                <div class="x_content">
                    @foreach($satuan as $sat)
                    <form action="{{ route('mastersatuan.update',$sat->KodeSatuan) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Satuan: </label>
                            <input type="text" readonly required="required" name="KodeSatuan" value="{{ $sat->KodeSatuan }}" placeholder="Kode Satuan" class="form-control">
                            <small>* kode singkatan satuan<br>
                                (misal: kilogram kodenya kg)</small>
                        </div>
                        <div class="form-group">
                            <label>Nama Satuan: </label>
                            <input type="text" required="required" name="NamaSatuan" value="{{ $sat->NamaSatuan }}" placeholder="Nama Satuan" class="form-control">
                            <small>* satuan terkecil untuk item<br>
                                (misal: beras satuannya kilogram)</small>
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('mastersatuan.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection