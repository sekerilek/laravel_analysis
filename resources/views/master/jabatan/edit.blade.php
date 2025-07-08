@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Edit Data Jabatan</h1>
                </div>
                <div class="x_content">
                    @foreach($jabatan as $jab)
                    <form action="{{ route('masterjabatan.update',$jab->KodeJabatan) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Jabatan: </label>
                            <input type="text" name="keterangan" placeholder="Jabatan" class="form-control" id="keterangan" value="{{$jab->KeteranganJabatan}}">
                        </div>

                        <div class="form-group">
                            <label>Kode Jabatan: </label>
                            <input type="text" name="kode" class="form-control" id="kode" value="{{$jab->KodeJabatan}}">
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;">Simpan</button>
                    </form>
                    @endforeach
                    <form action="{{ route('masterjabatan.index') }}" method="get">
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
    $('#keterangan').on('change', function() {
        var ket     = $('#keterangan').val();
        var kode    = ket.substring(0,3).toUpperCase();
        $('#kode').val(kode);
    });
</script>
@endpush