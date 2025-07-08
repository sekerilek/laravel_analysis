@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!-- Alert -->
            @if(session()->get('created'))
            <div class="alert alert-success alert-dismissible fade-show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session()->get('created') }}
            </div>

            @elseif(session()->get('edited'))
            <div class="alert alert-info alert-dismissible fade-show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session()->get('edited') }}
            </div>

            @elseif(session()->get('deleted'))
            <div class="alert alert-danger alert-dismissible fade-show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session()->get('deleted') }}
            </div>
            @endif

            <!-- <button type="button" class="btn btn-primary addResep">
                <span class="fa fa-plus"></span> Tambah resep
            </button>
            <br><br> -->

            <h3>RESEP</h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h4>Data Rak</h4>
                        <table class="table table-bordered" id="tableIndexResep" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Kode Rak</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <br>
                    <div class="row">
                        <h4>Tambah Rak</h4>
                        <form action="/resep/upload" method="post" id="formAddRak" enctype="multipart/form-data">
                            @csrf
                            <table class="table table-bordered" id="tableAddResep" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="50%">Rak Utama</th>
                                        <th>Tambahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="form-label">Harga (Rp) : </label>
                                                <input type="number" name="hargautama" class="form-control" min="0" step="1" value="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="form-label">Harga (Rp) : </label>
                                                <input type="number" name="hargatambahan" class="form-control" min="0" step="1" value="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="form-label">Nama : </label>
                                                <input type="text" name="namautama" class="form-control" placeholder="Nama Rak">
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="table" id="tableItemUtama">
                                                <thead>
                                                    <tr>
                                                        <td colspan="2"><button type="button" class="btn btn-sm btn-primary btnAddItemUtama" data-for="#tableItemUtama"><i class="fa fa-plus"></i></button></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="50%">
                                                            <select name="itemutama[]" class="form-control">
                                                                <option value="" selected disabled hidden>Pilih Komponen</option>
                                                                @foreach($item as $i)
                                                                <option value="{{$i->KodeItem}}">{{$i->NamaItem}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="qtyutama[]" class="form-control" min="1" step="1" value="1">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>

                                        <td>
                                            <table class="table" id="tableItemTambahan">
                                                <thead>
                                                    <tr>
                                                        <td colspan="2"><button type="button" class="btn btn-sm btn-primary btnAddItemTambahan" data-for="#tableItemTambahan"><i class="fa fa-plus"></i></button></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="50%">
                                                            <select name="itemtambahan[]" class="form-control">
                                                                <option value="" selected disabled hidden>Pilih Komponen</option>
                                                                @foreach($item as $i)
                                                                <option value="{{$i->KodeItem}}">{{$i->NamaItem}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="qtytambahan[]" class="form-control" min="1" step="1" value="1">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <div class="text-right d-flex">
                                                <button type="submit" class="btn btn-success btnUpload">Upload</button>
                                                <button type="reset" class="btn btn-warning btnReset">Ulang</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
$(function() {

    var $table = $('#tableIndexResep').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 3,
        ajax: `/resep/all`,
        columns: [
            {data: 'kode'},
            {data: 'nama'},
            {data: 'harga'},
            {
                data: 'tools',
                searchable: false,
                orderable: false
            }
        ]
    });
});

$('.btnAddItemUtama, .btnAddItemTambahan').click(function () {
    console.log($(this).data('for'));
    var table = $(this).data('for');
    var tr = $(`${table} tbody tr:first`).html();
    $(`${table} tbody`).append(`<tr>${tr}</tr>`);
    $(`${table} tbody tr:last select`).val('').trigger('change');
    $(`${table} tbody tr:last input`).val('1');
});

$('.btnReset').click(function () {
    $('#formAddRak')[0].reset();
    $('#tableItemUtama tbody tr:not(:first)').remove();
    $('#tableItemTambahan tbody tr:not(:first)').remove();
});

$('.btnUpload').click(function () {
    if (confirm('Lakukan upload data?')) {
        $('#formAddRak').submit();
    } else {
        return false;
    }
});
</script>
@endpush