@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    @csrf
                    @foreach($pelanggan as $pel)
                    <form action="{{ route('masterpelanggan.update',$pel->KodePelanggan) }}" method="post" style="display:inline-block;">
                        @endforeach
                        <div class="col-md-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h1>Tambah Data Pelanggan</h1>
                                </div>
                                <div class="x_content">
                                    @foreach($pelanggan as $pel)
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Kode Pelanggan: </label>
                                        <input type="text" readonly name="KodePelanggan" value="{{ $pel->KodePelanggan }}" placeholder="Kode Pelanggan" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Pelanggan: </label>
                                        <input type="text" required="required" name="NamaPelanggan" value="{{ $pel->NamaPelanggan }}" placeholder="Nama Pelanggan" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Kontak: </label>
                                        <input type="text" required="required" name="Kontak" value="{{ $pel->Kontak }}" placeholder="Kontak" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>NIK: </label>
                                        <input type="text" name="NIK" value="{{ $pel->NIK }}" placeholder="NIK" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>NPWP: </label>
                                        <input type="text" name="NPWP" value="{{ $pel->NPWP }}" placeholder="NPWP" class="form-control">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h3>Daftar Alamat Pelanggan</h3>
                                </div>
                                <div class="x_content">
                                    <table class="table table-responsive">
                                        <tbody>
                                            <a href="#" class="btn btn-sm btn-primary addRow">
                                                <i class="fa fa-plus"></i> <b>Tambah Alamat</b>
                                            </a>
                                            <br><br>
                                            @foreach($alamats as $alamat)
                                            <tr>
                                                <td>
                                                    <input type="text" style="width:110%;" name="alamat[]" class="form-control" placeholder="Alamat" value="{{$alamat->Alamat}}">
                                                </td>
                                                <td>
                                                    <input type="text" name="kota[]" class="form-control" placeholder="Kota" value="{{$alamat->Kota}}">
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-danger" id="remove">
                                                        <i class="fa fa-minus"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br><br>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </div>
                    </form>
                    <form action="{{ route('masterpelanggan.index') }}" method="get">
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
    $('.addRow').on('click', function() {
        tambahRow();
    });

    function tambahRow() {
        let tr = '<tr>' +
            '<td>' +
            '<input type="text" style="width:110%;" name="alamat[]" class="form-control" placeholder="Alamat">' +
            '</td>' +
            '<td>' +
            '<input type="text" name="kota[]" class="form-control" placeholder="Kota">' +
            '</td>' +
            '<td>' +
            '<a href="#" class="btn btn-sm btn-danger" id="remove">' +
            '<i class="fa fa-minus"></i>' +
            '</a>' +
            '</td>' +
            '</tr>';
        $('tbody').append(tr);
    }

    $('tbody').on('click', '#remove', function() {
        $(this).parent().parent().remove();
    });
</script>
@endpush