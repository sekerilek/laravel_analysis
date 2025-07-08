@extends('index')
@section('content')
<style type="text/css">
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
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Paket</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ route('masterpaket.store') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Nama Item:</label>
                                <input type="text" required="required" name="nama" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Harga:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="number" required="required" name="harga" class="form-control">
                                </div>
                            </div>
                            <br>

                            <!-- input satuan Konversi -->
                            <div class="x_title">
                                <h3>Tambah Komponen</h3>
                            </div>
                            <div class="form-row">
                                <button type="button" class="btn btn-primary" onclick="addrow()">
                                    <i class="fa fa-plus"></i>&nbsp;Tambah
                                </button>
                                <br><br>
                                <table id="komponen">
                                    <tr>
                                        <td id="header"><b>Item</b></td>
                                        <td id="header"><b>Satuan</b></td>
                                        <td id="header"><b>Qty</b></td>
                                        <td id="header"><b>Hapus</b></td>
                                    </tr>
                                    <tr class="rowinput">
                                        <td>
                                            <select name="komponen[]" class="form-control" required>
                                                @foreach($bahanjadi as $bhn)
                                                <option value="{{$bhn->KodeItem}}">{{$bhn->NamaItem}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="satuan[]" class="form-control" required>
                                                @foreach($satuan as $sat)
                                                <option value="{{$sat->KodeSatuan}}">{{$sat->NamaSatuan}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" min="1" step="1" name="qty[]" class="form-control" required value="1">
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <button class="btn btn-success" style="width:120px;">Simpan</button>
                        </form>
                        <form action="{{ route('masterpaket.index') }}" method="get">
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
<script>
    function addrow() {
        var tr = $('#komponen .rowinput').html();
        $('#komponen').append(`<tr>${tr}</tr>`);
        $('#komponen tr:last select').val('').trigger('change');
        $('#komponen tr:last td:last').append('<button type="button" class="btn btn-sm btn-danger" onclick="del(this)"><i class="fa fa-trash"></i></button>');
    }

    function del(el) {
        $(el).parents('tr').remove();
    }
</script>
@endpush