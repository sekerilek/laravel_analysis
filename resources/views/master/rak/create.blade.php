@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Rak</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('masterrak.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Kode Rak: </label>
                                <input type="text" readonly name="KodeRak" value={{ $newID }} class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Rak: </label>
                                <input type="text" required="required" name="NamaRak" placeholder="Nama Rak" class="form-control">
                            </div>
                            <br>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </form>
                        <form action="{{ route('masterrak.index') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection