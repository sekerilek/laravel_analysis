@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Supplier</h1>
                </div>
                <div class="x_content">
                    @foreach($supplier as $sup)
                    <form action="{{ route('mastersupplier.update',$sup->KodeSupplier) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Supplier: </label>
                            <input type="text" readonly name="KodeSupplier" value="{{ $sup->KodeSupplier }}" placeholder="Kode Supplier" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Supplier: </label>
                            <input type="text" required="required" name="NamaSupplier" value="{{ $sup->NamaSupplier }}" placeholder="Nama Supplier" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Kontak: </label>
                            <input type="text" required="required" name="Kontak" value="{{ $sup->Kontak }}" placeholder="Kontak" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Alamat: </label>
                            <textarea class="form-control" name="Alamat" placeholder="Alamat" required>{{ $sup->Alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Kota: </label>
                            <input type="text" name="Kota" value="{{ $sup->Kota }}" placeholder="Kota" class="form-control">
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('mastersupplier.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection