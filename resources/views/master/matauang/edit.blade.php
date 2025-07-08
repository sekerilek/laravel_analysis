@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Mata Uang</h1>
                </div>
                <div class="x_content">
                    @foreach($matauang as $mu)
                    <form action="{{ route('mastermatauang.update',$mu->KodeMataUang) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Mata Uang: </label>
                            <input type="text" readonly required="required" name="KodeMataUang" value="{{ $mu->KodeMataUang }}" placeholder="Kode Mata Uang" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Mata Uang: </label>
                            <input type="text" required="required" name="NamaMataUang" value="{{ $mu->NamaMataUang }}" placeholder="Nama Mata Uang" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nilai: </label>
                            <input type="text" required="required" name="Nilai" value="{{ $mu->Nilai }}" placeholder="Nilai" class="form-control">
                            <small>* nilai konversi mata uang<br>
                                * nilai Rupiah diisi 1<br>
                                (misal: US Dollar nilainya 14000)</small>
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('mastermatauang.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection