@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Rak</h1>
                </div>
                <div class="x_content">
                    @foreach($satuan as $sat)
                    <form action="{{ route('masterrak.update',$sat->ID) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Rak: </label>
                            <input type="text" required="required" name="NamaRak" value="{{ $sat->nama_rak }}" placeholder="Nama Rak" class="form-control">
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('masterrak.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection