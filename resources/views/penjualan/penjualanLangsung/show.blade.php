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
                    <h1 id="header">Penjualan Langsung</h1>
                    <h3 id="header">{{$id}}</h3>
                </div>
                <div class="x_content">
                    <form action="#" method="post">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <input type="text" class="form-control" placeholder="" value="{{$data->NamaMataUang}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <input type="text" class="form-control" placeholder="" value="{{$data->NamaLokasi}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pelanggan">Pelanggan</label>
                                    <input type="text" class="form-control" placeholder="" value="{{$data->NamaPelanggan}}" readonly>
                                </div>
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputPelanggan">PPN</label>
                                    @if($data->PPN == "ya")
                                    <input type="text" class="form-control" name="so" placeholder="" value="Ya" readonly>
                                    @else
                                    <input type="text" class="form-control" name="so" placeholder="" value="Tidak" readonly>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <input type="number" class="diskon form-control" name="diskon" placeholder="%" value="{{$data->Diskon}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <!-- <div class="x_title"></div> -->
                                <br><br>
                                <div class="x_title">
                                </div>
                                <br>
                                <h3 id="header">Daftar Item</h3>
                                <br><br><br>
                                <input type="hidden" value="1" name="totalItem" id="totalItem">

                                <table id="items" class="table">
                                    <tr>
                                        <td id="header" style="width:18%;">Nama Barang</td>
                                        <td id="header" style="width:9%;">Qty</td>
                                        <td id="header" style="width:12%;">Satuan</td>
                                        <td id="header" style="width:18%;">Harga Satuan</td>
                                        <td id="header" style="width:20%;">Keterangan</td>
                                        <td id="header">Total</td>
                                    </tr>
                                    @foreach($items as $item)
                                    <tr class="rowinput">
                                        <td>
                                            {{$item->NamaItem}}
                                        </td>
                                        <td>
                                            {{$item->Qty}}
                                        </td>
                                        <td>
                                            {{$item->NamaSatuan}}
                                        </td>
                                        <td>
                                            Rp. {{number_format($item->Harga)}},-
                                        </td>
                                        <td>
                                            {{$item->Keterangan}}
                                        </td>
                                        <td>
                                            Rp {{number_format($item->Subtotal)}},-
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="col-md-9">
                                    <!-- <button type="submit" class="btn btn-primary" formaction="{{ url('/sopenjualan/print/'.$id) }}">Print</button> -->
                                </div>
                                <div class="col-md-3">
                                    <label>Subtotal</label>
                                    <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp " . number_format(($data->Subtotal), 0, ',', '.') .",-"}}">
                                    @if($data->PPN == "ya")
                                    <label>PPN</label>
                                    <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp " . number_format($data->NilaiPPN, 0, ',', '.') .",-"}}">
                                    @else
                                    @endif
                                    <label>Diskon</label>
                                    <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp " . number_format($data->Diskon, 0, ',', '.') .",-"}}">
                                    <label>Total</label>
                                    <input type="text" readonly class="form-control subtotal" value="{{$string_total = "Rp " . number_format($data->Total, 0, ',', '.') .",-"}}">
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