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
                    <h1 id="header">Penerimaan Barang</h1>
                    <h3 id="header">{{$penerimaanbarang->KodePenerimaanBarang}}</h3>
                </div>
                <div class="x_content">
                    <form action="{{ url('/penerimaanBarang/update',$id)}}" method="post">
                        @csrf
                        <!-- Contents -->
                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <input type="hidden" class="form-control" name="KodePB" readonly="readonly" value="{{$penerimaanbarang->KodePenerimaanBarang}}">
                                <div class="form-group">
                                    <label>Nomor PO</label>
                                    <input type="text" class="form-control" name="KodePO" readonly="readonly" value="{{$penerimaanbarang->KodePO}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate" value="{{$penerimaanbarang->Tanggal}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Supplier</label>
                                    <input type="text" class="form-control" name="NamaSupplier" readonly="readonly" value="{{$supplier->NamaSupplier}}">
                                    <input type="hidden" class="form-control" name="KodeSupplier" readonly="readonly" value="{{$supplier->KodeSupplier}}">
                                </div>
                                @if($penerimaanbarang->PPN == "ya")
                                <div class="form-group">
                                    <label for="inputDate">No Faktur</label>
                                    <input type="text" class="form-control" name="NoFaktur" id="" value="{{$penerimaanbarang->NoFaktur}}">
                                </div>
                                @endif
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <select class="form-control" name="KodeMataUang" id="matauang">
                                        @foreach($matauang as $mu)
                                        @if($mu->KodeMataUang == $penerimaanbarang->KodeMataUang)
                                        <option value="{{$mu->KodeMataUang}}" selected>{{$mu->NamaMataUang}}</option>
                                        @else
                                        <option value="{{$mu->KodeMataUang}}">{{$mu->NamaMataUang}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputGudang">Gudang</label>
                                    <select class="form-control" name="KodeLokasi" id="gudang">
                                        @foreach($lokasi as $lok)
                                        @if($lok->KodeLokasi == $penerimaanbarang->KodeLokasi)
                                        <option value="{{$lok->KodeLokasi}}" selected>{{$lok->NamaLokasi}}</option>
                                        @else
                                        <option value="{{$lok->KodeLokasi}}">{{$lok->NamaLokasi}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Surat Jalan (Supplier)</label>
                                    <input type="text" class="form-control" name="KodeSJ" value="{{$penerimaanbarang->KodeSJ}}">
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
                                    <select class="form-control" name="KodeSales" id="sales">
                                        @foreach($sales as $sls)
                                        @if($sls->KodeKaryawan == $penerimaanbarang->KodeSales)
                                        <option value="{{$sls->KodeKaryawan}}" selected>{{$sls->Nama}}</option>
                                        @else
                                        <option value="{{$sls->KodeKaryawan}}">{{$sls->Nama}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Total Item</label>
                                    <input type="text" class="form-control" name="TotalItem" id="inputFaktur" value="{{$penerimaanbarang->TotalItem}}">
                                </div>
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="InputKeterangan" id="inputKeterangan" rows="3">{{$penerimaanbarang->Keterangan}}</textarea>
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
                                        <!-- <td id="header">Harga Satuan</td> -->
                                        <td id="header">Keterangan</td>
                                        <!-- <td id="header">Total</td> -->
                                    </tr>
                                    @foreach($items as $key => $data)
                                    <tr class="rowinput">
                                        <td>
                                            <input type="text" class="form-control" readonly value="{{$data->NamaItem}}">
                                            <input type="hidden" readonly name="item[]" value="{{$data->KodeItem}}">
                                        </td>
                                        <td>
                                            <input type="number" step=0.01 onchange="qty({{$key+1}})" name="qty[]" class="form-control qty{{$key+1}} qtyj" required="" value="{{$data->jml}}" placeholder="{{$data->max}}">
                                            <input type="hidden" class="max{{$key+1}}" value="{{$data->max}}">
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" readonly name="satuan[]" value="{{$data->KodeSatuan}}">
                                            <input type="text" class="form-control" readonly value="{{$data->NamaSatuan}}">
                                        </td>
                                        <!-- <td> -->
                                        <input readonly="" type="hidden" name="price[]" class="form-control price{{$key+1}}" required="" value="{{$data->Harga}}">
                                        <!-- </td> -->
                                        <td>
                                            <input type="text" class="form-control" readonly name="keterangan[]" value="{{$data->Keterangan}}">
                                        </td>
                                        <!-- <td> -->
                                        <input readonly type="hidden" name="total[]" class="form-control total{{$key+1}}" required="" value="{{$data->Harga * $data->jml}}">
                                        <!-- </td> -->
                                    </tr>
                                    @endforeach

                                </table>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
                                </div>
                                <div class="col-md-3">
                                    <input type="hidden" readonly value="{{sizeof($items)}}" class="tot">
                                    <!-- <label for="subtotal">Subtotal</label> -->
                                    <input type="hidden" name="total" readonly class="form-control befDis">
                                    <!-- <label for="ppn">Nilai PPN</label> -->
                                    <input type="hidden" readonly name="ppnval" class="ppnval form-control">
                                    <!-- <label for="diskon">Nilai Diskon</label> -->
                                    <input type="hidden" readonly name="diskonval" class="diskonval form-control">
                                    <!-- <label for="total">Total</label> -->
                                    <input type="hidden" readonly class="form-control subtotal" name="subtotal">
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

@push('scripts')
<script type="text/javascript">
    $('#alamat').select2()
    $('#sales').select2()
    $('#gudang').select2()
    $('#matauang').select2()

    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    function refresh(val) {
        var base = "{{ url('/') }}" + "/penerimaanBarang/create/" + val.value;
        window.location.href = base;
    }

    updatePrice($(".tot").val());

    function updatePrice(tot) {

        $(".subtotal").val(0);
        var diskon = 0;
        if ($(".diskon").val() != "") {
            diskon = parseInt($(".diskon").val());
        }
        for (var i = 1; i <= tot; i++) {
            if ($(".total" + i).val() != undefined) {
                $(".subtotal").val(parseInt($(".subtotal").val()) + parseInt($(".total" + i).val()));
            }
        }
        var befDis = $(".subtotal").val();
        diskon = parseInt($(".subtotal").val()) * diskon / 100;
        $(".subtotal").val(parseInt($(".subtotal").val()));
        var ppn = $(".ppn").val();
        if (ppn == "ya") {
            ppn = parseInt(befDis) * 10 / 100;
        } else {
            ppn = parseInt(0);
        }
        $(".ppnval").val(ppn);
        $(".diskonval").val(diskon);
        $(".befDis").val(parseInt($(".subtotal").val()));
        $(".subtotal").val(parseInt($(".subtotal").val()) + ppn - diskon);
    }

    function qty(int) {
        var qty = $(".qty" + int).val();
        var max = $(".max" + int).val();
        if (parseInt(qty) > parseInt(max)) {
            $(".qty" + int).val(max);
        }
        var qty = $(".qty" + int).val();
        var price = $(".price" + int).val();
        $(".total" + int).val(price * qty);
        var count = $(".tot").val();
        updatePrice(count);
    }
</script>
@endpush