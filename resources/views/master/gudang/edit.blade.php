@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Gudang</h1>
                </div>
                <div class="x_content">
                    @foreach($lokasi as $lok)
                    <form action="{{ route('mastergudang.update',$lok->KodeLokasi) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Gudang: </label>
                            <input readonly type="text" name="KodeLokasi" value="{{ $lok->KodeLokasi }}" placeholder="Kode Gudang" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Gudang: </label>
                            <input type="text" required="required" name="NamaLokasi" value="{{ $lok->NamaLokasi }}" placeholder="Nama Gudang" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tipe: </label><br>
                            <select class="form-control" name="Tipe" id="Tipe">
                                <option value="INV">INV</option>
                            </select>
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('mastergudang.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
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