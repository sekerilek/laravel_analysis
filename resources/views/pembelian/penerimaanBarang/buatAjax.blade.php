<form action="{{ url('/penerimaanBarang/store',$id)}}" method="post" class="formsub">
  @csrf

  <div class="form-row">
    <!-- column 1 -->
    <div class="form-group col-md-3">
      <input type="hidden" name="KodePO" value="{{$po->KodePO}}">
      <input type="hidden" name="KodeSupplier" value="{{$po->KodeSupplier}}">
      <div class="form-group">
        <label for="inputDate">Tanggal</label>
        <div class="input-group date" id="inputDate">
          <input type="text" class="form-control" name="Tanggal" id="inputDate" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label for="inputTerm">Sales</label>
        <select name="KodeSales" class="form-control" id="sales">
          @foreach($sales as $data)
          <option selected="selected" value="{{$data->KodeKaryawan}}">{{$data->Nama}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Total Item</label>
        <input type="text" class="form-control" name="TotalItem" id="inputFaktur" required>
      </div>
      <label for="inputKeterangan">Keterangan</label>
      <textarea class="form-control" name="InputKeterangan" id="inputKeterangan" rows="3" required></textarea>
    </div>
    <!-- pembatas -->
    <div class="form-group col-md-1"></div>
    <!-- column 2 -->
    <div class="form-group col-md-3">
      <div class="form-group">
        <label for="inputMatauang">Mata Uang</label>
        <select class="form-control" name="KodeMataUang" id="matauang" placeholder="Pilih mata uang">
          @foreach($matauang as $mu)
          <option value="{{$mu->KodeMataUang}}">{{$mu->NamaMataUang}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="inputGudang">Gudang</label>
        <select class="form-control" name="KodeLokasi" id="gudang">
          @foreach($lokasis as $lok)
          <option value="{{$lok->KodeLokasi}}">{{$lok->NamaLokasi}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Nomor Surat Jalan (Supplier)</label>
        <input type="text" class="form-control" name="KodeSJ" required> 
      </div>
      <!-- <div class="form-group">
        <label for="inputPelanggan">Diskon</label> -->
      <input type="hidden" step=0.01 readonly="readonly" class="form-control diskon" name="diskon" value="{{$po->Diskon}}">
      <!-- </div>
      <div class="form-group">
        <label for="inputPelanggan">PPN</label> -->
      <input type="hidden" readonly="readonly" class="form-control ppn" name="ppn" value="{{$po->PPN}}">
      <!-- </div> -->
    </div>
    <!-- pembatas -->
    <div class="form-group col-md-1"></div>
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
            <input type="text" class="form-control" readonly value="{{$data->NamaItem}}">
            <input type="hidden" readonly name="item[]" value="{{$data->KodeItem}}">
          </td>
          <td>
            <input type="number" step=0.01 onchange="qty({{$key+1}})" name="qty[]" class="form-control qty{{$key+1}} qtyj" required="" placeholder="{{$data->jml}}">
            <input type="hidden" class="max{{$key+1}}" value="{{$data->jml}}">
          </td>
          <td>
            <input type="hidden" class="form-control" readonly name="satuan[]" value="{{$data->KodeSatuan}}">
            <input type="text" class="form-control" readonly value="{{$data->NamaSatuan}}">
          </td>
          <td>
            <input readonly="" type="hidden" name="price[]" class="form-control price{{$key+1}}" required="" value="{{$data->Harga}}">
            <input readonly type="text" class="form-control" value="Rp. {{number_format($data->Harga)}},-">
          </td>
          <td>
            <input type="text" class="form-control" readonly name="keterangan[]" value="{{$data->Keterangan}}">
          </td>
          <td>
            <input readonly type="hidden" name="total[]" class="form-control total{{$key+1}}" required="" value="{{$data->Harga * $data->jml}}">
            <input readonly type="text" class="form-control showtotal{{$key+1}}" value="Rp. {{number_format($data->Harga * $data->jml)}},-">
          </td>
        </tr>
        @endforeach

      </table>
      <div class="col-md-9">
        <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data ini?')">Simpan</button>
      </div>
      <div class="col-md-3">
        <input type="hidden" value="{{sizeof($items)}}" class="tot">
        <label for="subtotal">Subtotal</label>
        <input type="hidden" name="total" readonly class="form-control befDis">
        <input type="text" readonly="" class="form-control showbefDis" value="Rp 0,-">
        <label for="ppn">Nilai PPN</label>
        <input type="hidden" readonly name="ppnval" class="ppnval form-control">
        <input type="text" readonly="" class="form-control showppnval" value="Rp 0,-">
        <label for="diskon">Nilai Diskon</label>
        <input type="hidden" readonly name="diskonval" class="diskonval form-control">
        <input type="text" readonly="" class="form-control showdiskonval" value="Rp 0,-">
        <label for="total">Total</label>
        <input type="hidden" readonly class="form-control subtotal" name="subtotal">
        <input type="text" readonly="" class="form-control showsubtotal" value="Rp 0,-">
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">
  $('#alamat').select2()
  $('#sales').select2()
  $('#gudang').select2()
  $('#matauang').select2()

  $('#inputDate').datetimepicker({
    defaultDate: new Date(),
    format: 'YYYY-MM-DD'
  });
</script>