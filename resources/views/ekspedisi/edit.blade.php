@extends('index')
@section('content')
<style type="text/css">
    form {
        margin: 20px 0;
    }

    form input,
    button {
        padding: 5px;
    }

    table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #cdcdcd;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
    }

    #header {
        text-align: center;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 id="header">Ekspedisi</h1>
                </div>
                <div class="x_content">
                    @foreach ($eks as $item)
                        
                    <form action="{{ route('ekspedisi-update',$item->ID) }}" method="post" class="formsub">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            
                            <div class="form-group">
                                <label for="inputKodeEkspedisi">Kode Ekspedisi</label>
                                <input type="text" class="form-control" name="KodeEkspedisi" value="{{ $item->KodeEkspedisi }}" id="inputKodeEkspedisi">
                            </div>
                            <div class="form-group">
                                <label for="inputNamaEkspedisi">Nama Ekspedisi</label>
                                <input type="text" class="form-control" name="NamaEkspedisi" value="{{ $item->NamaEkspedisi }}" id="inputNamaEkspedisi">
                            </div>
                                <div class="form-group">
                                    <label for="inputModal">Modal</label>
                                    <input type="text" class="form-control" name="Modal" value="{{ $item->Modal }}" id="inputModal">
                                </div>
                                <div class="form-group">
                                    <label for="inputTarifPelanggan">Tarif Pelanggan</label>
                                    <input type="text" class="form-control" name="TarifPelanggan" value="{{ $item->TarifPelanggan }}" id="inputTarifPelanggan">
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                <!-- <button type="submit" class="btn btn-danger">Batal</button> -->
                            </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
