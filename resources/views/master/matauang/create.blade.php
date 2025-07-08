@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Mata Uang</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('mastermatauang.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Kode Mata Uang: </label>
                                <input type="text" required="required" name="KodeMataUang" placeholder="Kode Mata Uang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Mata Uang: </label>
                                <input type="text" required="required" name="NamaMataUang" placeholder="Nama Mata Uang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nilai: </label>
                                <input type="text" required="required" name="Nilai" placeholder="Nilai" value=1 class="form-control">
                                <small>* nilai konversi mata uang<br>
                                    * nilai Rupiah diisi 1<br>
                                    (misal: US Dollar nilainya 14000)</small>
                            </div>
                            <br>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </form>
                        <form action="{{ route('mastermatauang.index') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection