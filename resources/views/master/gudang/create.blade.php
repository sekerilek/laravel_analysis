@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Gudang</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('mastergudang.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Kode Gudang: </label>
                                <input readonly type="text" value="{{$newID}}" required="required" name="KodeLokasi" placeholder="Kode Gudang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Gudang: </label>
                                <input type="text" required="required" name="NamaLokasi" placeholder="Nama Gudang" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tipe: </label><br>
                                <select class="form-control" name="Tipe" id="Tipe">
                                    <option value="INV" default>INV</option>
                                </select>
                            </div>
                            <br>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </form>
                        <form action="{{ route('mastergudang.index') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#Tipe').select2();
    });
</script>
@endpush