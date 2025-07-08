@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah Data Rak</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ url('produksi/rak/upload') }}" method="post" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Nama Rak: </label>
                                <input type="text" name="namarak" placeholder="Nama Rak" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Harga: </label>
                                <input type="number" name="hargarak" class="form-control" value="0" required>
                            </div>
                            <br>
                            <br>
                            <div class="row divTambahan">
                                <h4>Tambahan</h4>
                                <div class="text-right">
                                    <button type="button" class="btn btn-primary btnAddTambahan">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label>Harga: </label>
                                    <input type="number" name="hargatambahan" class="form-control" value="0" required>
                                </div>
                                <div class="col-12">
                                    <table class="table table-responsive" id="tableRakTambahan">
                                        <thead>
                                            <tr>
                                                <th>Komponen</th>
                                                <th>Jumlah</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control" name="komponenrak[]">
                                                        <option value="" selected disabled hidden>Pilih Komponen</option>
                                                        @foreach($komponen as $item)
                                                        <option value="{{$item->KodeItem}}">{{$item->NamaItem}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="jumlahkomponen[]" class="form-control" min="0" value="0" step="1">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger">
                                                        <span class="fa fa-minus"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Proses</button>
                            <a href="/produksi/rak" class="btn btn-danger">Batal</a>
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
    $(function () {
        let $table = $('#tableRakTambahan').DataTable({
            searching: false
        });
        $('select').select2();
        $('.btnAddTambahan').click(function () {
            let $tr = [];
            $('#tableRakTambahan tbody tr:last select').select2('destroy');
            $('#tableRakTambahan tbody tr:last td').each(function () {
                $tr.push($(this).html());
            });

            $table.row.add($tr).draw(false);
            $('#tableRakTambahan tbody tr select').select2();
        });
    });
</script>
@endpush