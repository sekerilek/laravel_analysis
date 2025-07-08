@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Item</h1>
                </div>
                <div class="x_content">
                    @foreach($item as $itm)
                    <form action="{{ route('masteritem.update',$itm->KodeItem) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="KodeItem" value="{{ $itm->KodeItem }}">
                        <div class="form-group">
                            <label>Klasifikasi: </label>
                            <input type="text" readonly required="required" name="KodeKategori" value="{{ $itm->KodeKategori }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Item:</label>
                            <input type="text" required="required" name="NamaItem" value="{{ $itm->NamaItem }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Jenis Item:</label>
                            <input type="text" readonly required="required" name="jenisitem" value="{{ $itm->jenisitem }}" class="form-control">
                        </div>
                        @endforeach
                        @foreach($itemk as $itk)
                        <div class="form-group">
                            <label>Satuan: </label>
                            <input type="text" readonly required="required" name="KodeSatuan" value="{{ $itk->KodeSatuan }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Konversi:</label>
                            <input type="number" step=0.01 required="required" name="Konversi" value="{{ $itk->Konversi }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Harga Jual:</label>
                            <input type="number" step=0.01 required="required" name="HargaJual" value="{{ $itk->HargaJual }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Harga Beli:</label>
                            <input type="number" step=0.01 required="required" name="HargaBeli" value="{{ $itk->HargaBeli }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Harga Grosir:</label>
                            <input type="number" step=0.01 required="required" name="HargaGrosir" value="{{ $itk->HargaGrosir }}" class="form-control">
                        </div>
                        @endforeach
                        @foreach($item as $itm)
                        <div class="form-group">
                            <label>Alias:</label>
                            <input id="Alias" type="text" name="Alias" value="{{ $itm->Alias }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Keterangan:</label>
                            <textarea id="Keterangan" class="form-control" name="Keterangan">{{ $itm->Keterangan }}</textarea>
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('masteritem.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection