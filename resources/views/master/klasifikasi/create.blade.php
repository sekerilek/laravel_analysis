@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Klasifikasi</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('masterklasifikasi.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Kode Klasifikasi: </label>
                                <input readonly type="text" value="{{$newID}}" required="required" name="KodeKategori" placeholder="Kode Klasifikasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Klasifikasi: </label>
                                <input type="text" required="required" name="NamaKategori" placeholder="Nama Klasifikasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Kode Item Awal: </label>
                                <input type="text" required="required" name="KodeItemAwal" placeholder="Kode Item" class="form-control">
                                <small>* akan digunakan untuk format kode item<br>
                                    (misal: klasifikasi beras, kodenya BRS)</small>
                            </div>
                            <br>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </form>
                        <form action="{{ route('masterklasifikasi.index') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection