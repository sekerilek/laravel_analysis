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
                    <h1 id="header">Stok Masuk</h1>
                    @foreach($stokmasuks as $stok)
                    <h3 id="header">{{$stok->KodeStokMasuk}}</h3>
                    @endforeach
                </div>
                <div class="x_content">
                    <form action="{{ url('/stokmasuk/store') }}" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                @csrf
                                <!-- Contents -->
                                <br>
                                <div class="form-row">
                                    @foreach($stokmasuks as $stok)
                                    <div class="form-group">
                                        <label for="">Gudang</label>
                                        <input type="text" readonly name="Gudang" class="form-control" value="{{$stok->NamaLokasi}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal</label>
                                        <input type="text" readonly name="Tanggal" class="form-control" value="{{\Carbon\Carbon::parse($stok->Tanggal)->format('d-m-Y')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Keterangan</label>
                                        <textarea id="Keterangan" readonly name="Keterangan" class="form-control">{{$stok->Keterangan}}</textarea>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <br><br>
                                <div class="x_title">
                                </div>
                                <br>
                                <h3 id="header">Daftar Item</h3>
                                <br><br>
                                <input type="hidden" value="1" name="totalItem" id="totalItem">

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:25%;">Nama Barang</td>
                                        <td id="header" style="width:25%;">Qty</td>
                                        <td id="header" style="width:25%;">Satuan</td>
                                        <td id="header" style="width:25%;">Keterangan</td>
                                    </tr>
                                    @foreach($items as $item)
                                    <tr class="rowinput">
                                        <td>
                                            <input type="text" readonly class="form-control" value="{{ $item->NamaItem}}">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control" value="{{ $item->Qty}}">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control" value="{{ $item->NamaSatuan}}">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control" value="{{ $item->Keterangan}}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="col-md-9">
                                    <!-- <button type="submit" class="btn btn-success">Simpan</button> -->
                                    <!-- <button type="submit" class="btn btn-danger">Batal</button> -->
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection