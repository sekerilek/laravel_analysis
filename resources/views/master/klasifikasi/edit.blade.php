@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Klasifikasi</h1>
                </div>
                <div class="x_content">
                    @foreach($kategori as $kat)
                    <form action="{{ route('masterklasifikasi.update',$kat->KodeKategori) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Klasifikasi: </label>
                            <input readonly type="text" name="KodeKategori" value="{{ $kat->KodeKategori }}" placeholder="Kode Klasifikasi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Klasifikasi: </label>
                            <input type="text" required="required" name="NamaKategori" value="{{ $kat->NamaKategori }}" placeholder="Nama Klasifikasi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Kode Item Awal: </label>
                            <input type="text" required="required" name="KodeItemAwal" value="{{ $kat->KodeItemAwal }}" placeholder="Kode Item" class="form-control">
                            <small>* akan digunakan untuk format kode item<br>
                                (misal: klasifikasi beras, kodenya BRS)</small>
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('masterklasifikasi.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection