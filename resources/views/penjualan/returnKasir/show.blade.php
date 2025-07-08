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
                    <h1 id="header">Return Kasir</h1>
                </div>
                <div class="x_content">
                    @csrf
                    <!-- Contents -->
                    <br>
                    <div class="form-row">
                        <!-- column 1 -->
                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="">Kode Return Kasir</label>
                                <input type="text" class="form-control" readonly="readonly" value="{{$kasirreturn->KodeKasirReturn}}">
                            </div>
                            <div class="form-group">
                                <label for="inputDate">Tanggal</label>
                                <input type="text" class="form-control" name="Tanggal" id="inputDate" readonly="readonly" value="{{\Carbon\Carbon::parse($kasirreturn->Tanggal)->format('d-m-Y')}}">
                            </div>
                        </div>
                        <!-- pembatas -->
                        <div class="form-group col-md-1"></div>
                        <!-- column 2 -->
                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputPelanggan">Pelanggan</label>
                                <input type="text" class="form-control" name="KodePelanggan" readonly="readonly" value="{{$pelanggan->NamaPelanggan}}">
                            </div>
                            <!-- <div class="form-group">
                                <label for="inputMatauang">Mata Uang</label>
                                <input type="text" class="form-control" name="KodeSopir" id="inputBerlaku" readonly="readonly" value="{{$matauang->NamaMataUang}}">
                            </div> -->
                            <div class="form-group">
                                <label for="inputGudang">Gudang</label>
                                <input type="text" class="form-control" name="KodeLokasi" readonly="readonly" value="{{$lokasi->NamaLokasi}}">
                            </div>
                            <!-- <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label> -->
                            <input type="hidden" readonly="readonly" class="diskon form-control diskon" name="diskon" id="inputBerlaku" value="{{$kasir->Diskon}}">
                            <!-- </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPN</label> -->
                            <input type="hidden" readonly="readonly" class="diskon form-control ppn" name="ppn" id="inputBerlaku" value="{{$kasir->PPN}}">
                            <!-- </div> -->
                        </div>
                        <!-- pembatas -->
                        <div class="form-group col-md-1"></div>
                        <!-- column 3 -->
                        <div class="form-group col-md-3">
                            <div>
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="3" readonly="readonly">{{$kasirreturn->Keterangan}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="x_title">
                            </div>
                            <br>
                            <h3 id="header">Daftar Item</h3>
                            <br>
                            <table id="items">
                                <tr>
                                    <td id="header">Nama Barang</td>
                                    <td id="header">Qty</td>
                                    <td id="header">Satuan</td>
                                    <td id="header">Harga Satuan</td>
                                    <td id="header">Keterangan</td>
                                    <td id="header">Total</td>
                                </tr>
                                @foreach($items as $key => $data)
                                <tr class="rowinput">
                                    <td>
                                        {{$data->NamaItem}}
                                    </td>
                                    <td>
                                        {{$data->jml}}
                                    </td>
                                    <td>
                                        {{$data->NamaSatuan}}
                                    </td>
                                    <td>
                                        Rp. {{number_format($data->Harga)}},-
                                    </td>
                                    <td>
                                        {{$data->Keterangan}}
                                    </td>
                                    <td>
                                        Rp. {{number_format($data->Harga * $data->jml)}},-
                                    </td>
                                </tr>
                                @endforeach

                            </table>
                            <div class="col-md-9">
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" value="{{sizeof($items)}}" class="tot">
                                <label for="subtotal">Subtotal</label>
                                <input type="text" name="total" readonly class="form-control befDis" value="{{$string_total = "Rp. " . number_format(($kasirreturn->Subtotal - $kasirreturn->NilaiDiskon - $kasirreturn->NilaiPPN), 0, ',', '.') .",-"}}">
                                <label for="ppn">Nilai PPN</label>
                                <input type="text" readonly name="ppnval" class="ppnval form-control" value="{{$string_total = "Rp. " . number_format(($kasirreturn->NilaiPPN), 0, ',', '.') .",-"}}">
                                <label for="diskon">Nilai Diskon</label>
                                <input type="text" readonly name="diskonval" class="diskonval form-control" value="{{$string_total = "Rp. " . number_format(($kasirreturn->NilaiDiskon), 0, ',', '.') .",-"}}">
                                <label for="total">Total</label>
                                <input type="text" readonly class="form-control subtotal" name="subtotal" value="{{$string_total = "Rp. " . number_format(($kasirreturn->Subtotal), 0, ',', '.') .",-"}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection