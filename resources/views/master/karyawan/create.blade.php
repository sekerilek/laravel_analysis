@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Karyawan</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('masterkaryawan.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Kode Karyawan: </label>
                                <input readonly type="text" value="{{ $newID }}" name="KodeKaryawan" placeholder="Kode Karyawan" class="form-control" id="KodeKaryawan">
                            </div>
                            <div class="form-group">
                                <label>Nama Karyawan: </label>
                                <input type="text" required="required" name="Nama" placeholder="Nama Karyawan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jabatan: </label>
                                <select name="Jabatan" id="Jabatan" class="form-control">
                                    <option disabled hidden selected>-- Pilih Jabatan --</option>
                                    @foreach($jabatan as $jab)
                                    <option value="{{$jab->KodeJabatan}}">{{$jab->KeteranganJabatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Golongan: </label>
                                <select name="Golongan" id="Golongan" class="form-control">
                                    <option selected disabled hidden>-- Pilih Golongan  --</option>
                                    @foreach($golongan as $datagol)
                                    <option value="{{ $datagol->KodeGolongan }}">
                                      {{ $datagol->NamaGolongan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Gaji Pokok: </label>
                                <input type="text" id="GajiPokok" class="form-control" name="GajiPokok" placeholder="GajiPokok" value="0" required>
                                <input type="text" id="GajiPokokFormat" value="0" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Alamat: </label>
                                <textarea class="form-control" name="Alamat" placeholder="Alamat" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis kelamin</label>
                                <select name="JenisKelamin" id="JenisKelamin" class="form-control">
                                    <option value="Perempuan" selected>Perempuan</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kota: </label>
                                <input type="text" name="Kota" placeholder="Kota" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Telepon: </label>
                                <input type="text" name="Telepon" placeholder="Telepon" class="form-control">
                            </div>
                            <br>
                            <button class="btn btn-success" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                        </form>
                        <form action="{{ route('masterkaryawan.index') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#Golongan').on('change', function() {
        var kodegolongan            = $(this).val();
        var nomorgolongan           = +(kodegolongan.substr(-2));
        if (nomorgolongan < 4) {
            $('#GajiPokok').attr('readonly','readonly');
        }
        else {
            $('#GajiPokok').removeAttr('readonly');
        }
    });

    $('#GajiPokok').on('change', function() {
        var gaji        = +($('#GajiPokok').val());
        $('#GajiPokokFormat').val(number_format(gaji));
    });

    function number_format(number, decimals, decPoint, thousandsSep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
        var n = !isFinite(+number) ? 0 : +number
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
        var sep = (typeof thousandsSep === 'undefined') ? '.' : thousandsSep
        var dec = (typeof decPoint === 'undefined') ? ',' : decPoint
        var s = ''

        var toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
                .toFixed(prec)
        }

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
        }

        return s.join(dec)
    }
</script>
@endpush