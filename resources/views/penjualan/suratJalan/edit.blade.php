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
                    <h1 id="header">Surat Jalan</h1>
                    <h3 id="header">{{$suratjalan->KodeSuratJalan}}</h3>
                </div>
                <div class="x_content">
                    <form action="{{ url('/suratJalan/update',$id)}}" method="post">
                        @csrf
                        <!-- Contents -->

                        @foreach($alamat as $almt)
                        <input type="hidden" id="Kota{{$almt->NoIndeks}}" value="{{$almt->Kota}}">
                        <input type="hidden" id="Alamat{{$almt->NoIndeks}}" value="{{$almt->Alamat}}">
                        @endforeach

                        <br>
                        <div class="form-row">
                            <!-- column 1 -->
                            <div class="form-group col-md-3">
                                <input type="hidden" class="form-control" name="KodeSJ" readonly="readonly" value="{{$suratjalan->KodeSuratJalan}}">
                                <div class="form-group">
                                    <label>Nomor SO</label>
                                    <input type="text" class="form-control" name="KodeSO" readonly="readonly" value="{{$suratjalan->KodeSO}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputDate">Tanggal</label>
                                    <div class="input-group date" id="inputDate">
                                        <input type="text" class="form-control" name="Tanggal" id="inputDate" value="{{$suratjalan->Tanggal}}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">Pelanggan</label>
                                    <input type="text" class="form-control" name="NamaPelanggan" readonly="readonly" value="{{$pelanggan->NamaPelanggan}}">
                                    <input type="hidden" class="form-control" name="KodePelanggan" readonly="readonly" value="{{$pelanggan->KodePelanggan}}">
                                </div>
                                @if($suratjalan->PPN == "ya")
                                <div class="form-group">
                                    <label for="inputDate">No Faktur</label>
                                    <input type="text" class="form-control" name="NoFaktur" id="" value="{{$suratjalan->NoFaktur}}">
                                </div>
                                @endif
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 2 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputBerlaku">Alamat</label>
                                    <select class="form-control alamat1" name="AlamatPelanggan" onchange="getalamat(this)" id="alamat">
                                        @foreach($alamat as $alm)
                                        @if($alm->Alamat == $suratjalan->Alamat)
                                        <option value="{{$alm->NoIndeks}}" selected>{{$alm->Alamat}}</option>
                                        @else
                                        <option value="{{$alm->NoIndeks}}">{{$alm->Alamat}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @foreach($alamat as $dtalm)
                                    @if($dtalm->Alamat == $suratjalan->Alamat)
                                    <input type="hidden" class="form-control alamat" name="Alamat" value="{{$dtalm->Alamat}}">
                                    <input type="text" readonly class="form-control kota" name="Kota" value="{{$dtalm->Kota}}">
                                    @endif
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="inputTerm">Sopir</label>
                                    <select class="form-control" name="KodeSopir" id="sopir">
                                        @foreach($driver as $drv)
                                        @if($drv->KodeDriver == $suratjalan->KodeSopir)
                                        <option value="{{$drv->KodeDriver}}" selected>{{$drv->NamaDriver}}</option>
                                        @else
                                        <option value="{{$drv->KodeDriver}}">{{$drv->NamaDriver}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputNopol">No Polisi</label>
                                    <input type="text" class="form-control" name="nopol" id="inputNopol" value="{{$suratjalan->Nopol}}">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="inputPelanggan">Diskon</label> -->
                                <input type="hidden" readonly="readonly" class="diskon form-control diskon" name="diskon" id="inputBerlaku" value="{{$suratjalan->Diskon}}">
                                <!-- </div>
                                <div class="form-group">
                                    <label for="inputPelanggan">PPN</label> -->
                                <input type="hidden" readonly="readonly" class="diskon form-control ppn" name="ppn" id="inputBerlaku" value="{{$suratjalan->PPN}}">
                                <!-- </div> -->
                            </div>
                            <!-- pembatas -->
                            <div class="form-group col-md-1"></div>
                            <!-- column 3 -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="inputMatauang">Mata Uang</label>
                                    <select class="form-control" name="KodeMataUang" id="matauang">
                                        @foreach($matauang as $mu)
                                        @if($mu->KodeMataUang == $suratjalan->KodeMataUang)
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
                                        @if($lok->KodeLokasi == $suratjalan->KodeLokasi)
                                        <option value="{{$lok->KodeLokasi}}" selected>{{$lok->NamaLokasi}}</option>
                                        @else
                                        <option value="{{$lok->KodeLokasi}}">{{$lok->NamaLokasi}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Total Item</label>
                                    <input type="text" class="form-control" name="TotalItem" id="inputFaktur" value="{{$suratjalan->TotalItem}}">
                                </div>
                                <label for="inputKeterangan">Keterangan</label>
                                <textarea class="form-control" name="InputKeterangan" id="inputKeterangan" rows="3">{{$suratjalan->Keterangan}}</textarea>
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
    $('#sopir').select2()
    $('#gudang').select2()
    $('#matauang').select2()

    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    function refresh(val) {
        var base = "{{ url('/') }}" + "/suratJalan/create/" + val.value;
        window.location.href = base;
    }

    function getalamat(val) {
        var kota = $("#" + "Kota" + val.value).val();
        var alamat = $("#" + "Alamat" + val.value).val();
        $(".kota").val(kota);
        $(".alamat").val(alamat);
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