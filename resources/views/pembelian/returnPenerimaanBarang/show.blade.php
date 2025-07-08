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
                    <h1 id="header">Return Penerimaan Barang</h1>
                </div>
                <div class="x_content">
                    <form action="/returnPenerimaanBarang/confirm/{{$id}}" method="post">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="">Nomor PB</label>
                                    <input type="text" class="form-control" name="Expired" readonly="readonly" value="{{$penerimaanbarangreturn->KodePenerimaanBarangReturn}}" id="inputBerlaku">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <input type="text" class="form-control" name="Tanggal" id="inputDate" readonly="readonly" value="{{\Carbon\Carbon::parse($penerimaanbarangreturn->Tanggal)->format('d-m-Y')}}">
                                </div>
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="Keterangan" id="inputKeterangan" rows="3" readonly="readonly">{{$penerimaanbarangreturn->Keterangan}}</textarea>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <input type="text" class="form-control" name="KodeMataUang" id="inputBerlaku" readonly="readonly" value="{{$matauang->NamaMataUang}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <input type="text" class="form-control" name="KodeLokasi" readonly="readonly" value="{{$lokasi->NamaLokasi}}">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label> -->
                                <input type="hidden" readonly="readonly" class="diskon form-control diskon" name="diskon" id="inputBerlaku" value="{{$penerimaanbarang->Diskon}}">
                                <!-- </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPN</label> -->
                                <input type="hidden" readonly="readonly" class="diskon form-control ppn" name="ppn" id="inputBerlaku" value="{{$penerimaanbarang->PPN}}">
                                <!-- </div> -->
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputTerm">Sales</label>
                                    <input type="text" class="form-control" name="KodeSales" id="inputBerlaku" readonly="readonly" value="{{$sales->Nama}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Supplier</label>
                                    <input type="text" class="form-control" name="KodeSupplier" readonly="readonly" value="{{$supplier->NamaSupplier}}">
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
                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                </div>
                                <div class="col-md-3">
                                    <input type="hidden" value="{{sizeof($items)}}" class="tot">
                                    <label for="subtotal">Subtotal</label>
                                    <input type="text" name="total" readonly class="form-control befDis" value="{{$string_total = "Rp. " . number_format(($penerimaanbarangreturn->Subtotal - $penerimaanbarangreturn->NilaiDiskon - $penerimaanbarangreturn->NilaiPPN), 0, ',', '.') .",-"}}">
                                    <label for="ppn">Nilai PPN</label>
                                    <input type="text" readonly name="ppnval" class="ppnval form-control" value="{{$string_total = "Rp. " . number_format(($penerimaanbarangreturn->NilaiPPN), 0, ',', '.') .",-"}}">
                                    <label for="diskon">Nilai Diskon</label>
                                    <input type="text" readonly name="diskonval" class="diskonval form-control" value="{{$string_total = "Rp. " . number_format(($penerimaanbarangreturn->NilaiDiskon), 0, ',', '.') .",-"}}">
                                    <label for="total">Total</label>
                                    <input type="text" readonly class="form-control subtotal" name="subtotal" value="{{$string_total = "Rp. " . number_format(($penerimaanbarangreturn->Subtotal), 0, ',', '.') .",-"}}">
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