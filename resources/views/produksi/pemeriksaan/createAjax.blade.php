<form action="{{ url('/pemeriksaanproduksi/store',$id)}}" method="post" class="formsub">
    @csrf

    <div class="form-row">
        <!-- column 1 -->
        <div class="form-group col-md-3">
            <input type="hidden" name="KodeProduksi" value="{{$produksi->KodeProduksi}}">
            <input type="hidden" name="KodeResep" value="{{$produksi->KodeResep}}">
            <input type="hidden" name="TanggalInput" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" class="form-control" value="{{$produksi->TanggalProduksi}}" readonly>
            </div>
            <div class="form-group">
                <label for="inputDate">Tanggal Cek</label>
                <div class="input-group date">
                    <input type="text" class="form-control" name="TanggalCek" id="inputCek" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <!-- pembatas -->
        <div class="form-group col-md-1"></div>
        <!-- column 2 -->
        <div class="form-group col-md-3">
            <div class="form-group">
                <label for="inputKeterangan">Keterangan</label>
                <textarea class="form-control" name="Keterangan" rows="3" required></textarea>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <div class="x_title">
            </div>
            <br>
            <h3 id="header">Daftar Produksi Karyawan</h3>
            <br>
            <table id="items">
                <tr>
                    <td id="header" style="width:25%;">Karyawan</td>
                    <td id="header" style="width:15%;">Jumlah</td>
                    <td id="header" style="width:15%;">Jumlah Cek</td>
                    <td id="header" style="width:15%;">Satuan</td>
                    <td id="header" style="width:30%;">Keterangan</td>
                </tr>
                @foreach($produksidetail as $key => $data)
                <tr class="rowinput">
                    <td>
                        <input type="text" class="form-control" readonly value="{{$data->Nama}}">
                        <input type="hidden" name="karyawan[]" readonly value="{{$data->KodeKaryawan}}">
                    </td>
                    <td>
                        <input type="number" step=1 name="qty[]" class="form-control" readonly value="{{$data->QtyHasil}}">
                    </td>
                    <td>
                        <input type="number" step=1 name="qtycek[]" class="form-control" required="" placeholder="{{$data->QtyHasil}}">
                    </td>
                    <td>
                        <input type="text" class="form-control" readonly value="{{$data->NamaSatuan}}">
                        <input type="hidden" name="satuan[]" class="form-control" readonly value="{{$data->KodeSatuan}}">
                    </td>
                    <td>
                        <textarea class="form-control" name="keterangan[]" rows="2"></textarea>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="col-md-9">
                <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi data ini?')"><b>Konfirmasi</b></button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#inputCek').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
</script>