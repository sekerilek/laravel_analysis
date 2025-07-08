@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Jabatan</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('masterjabatan.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Nama Jabatan: </label>
                                <input type="text" name="keterangan" placeholder="Jabatan" class="form-control" id="keterangan">
                            </div>

                            <div class="form-group">
                                <label>Kode Jabatan: </label>
                                <input type="text" name="kode" class="form-control" id="kode">
                            </div>
                            
                            <br>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </form>
                        <form action="{{ route('masterjabatan.index') }}" method="get">
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
    $('#keterangan').on('change', function() {
        var ket     = $('#keterangan').val();
        var kode    = ket;
        $('#kode').val(kode);
    });
</script>
@endpush