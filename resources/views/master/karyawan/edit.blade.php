@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Karyawan</h1>
                </div>
                <div class="x_content">
                    @foreach($karyawan as $kar)
                    <form action="{{ route('masterkaryawan.update',$kar->KodeKaryawan) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Karyawan: </label>
                            <input readonly type="text" value="{{ $kar->KodeKaryawan }}" name="KodeKaryawan" class="form-control" id="KodeKaryawan">
                        </div>
                        <div class="form-group">
                            <label>Nama Karyawan: </label>
                            <input type="text" value="{{ $kar->Nama }}" required="required" type="text" name="Nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Jabatan: </label>
                            <select name="Jabatan" id="Jabatan" class="form-control">
                                @foreach($jabatan as $jab)
                                <option value="{{$jab->KodeJabatan}}" {{($kar->KodeJabatan == $jab->KodeJabatan) ? "selected" : "" }}>
                                    {{$jab->KeteranganJabatan}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Golongan: </label>
                            <select name="Golongan" id="Golongan" class="form-control">
                                @foreach($golongan as $datagol)
                                    <option value="{{ $datagol->KodeGolongan }}" {{ ($kar->KodeGolongan == $datagol->KodeGolongan) ? "selected" : "" }}>
                                      {{ $datagol->NamaGolongan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gaji Pokok: </label>
                            <input type="text" name="GajiPokok" class="form-control" id="GajiPokok" placeholder="Gaji Pokok" value="{{$kar->GajiPokok}}">
                            <input type="text" id="GajiPokokFormat" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Alamat: </label>
                            <textarea class="form-control" name="Alamat" placeholder="Alamat" required>{{ $kar->Alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Jenis kelamin</label>
                            <select name="JenisKelamin" value="{{ $kar->JenisKelamin }}" id="JenisKelamin" class="form-control">
                                @if($kar->JenisKelamin == "Laki-laki")
                                <option value="Perempuan">Perempuan</option>
                                <option value="Laki-laki" selected>Laki-laki</option>
                                @elseif($kar->JenisKelamin == "Perempuan")
                                <option value="Perempuan" selected>Perempuan</option>
                                <option value="Laki-laki">Laki-laki</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kota: </label>
                            <input type="text" name="Kota" value="{{ $kar->Kota }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Telepon: </label>
                            <input type="text" name="Telepon" value="{{ $kar->Telepon }}" class="form-control">
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('masterkaryawan.index') }}" method="get">
                        <button class="btn btn-danger" style="width:120px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var gaji        = +($('#GajiPokok').val());
        $('#GajiPokokFormat').val(number_format(gaji));
    });

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