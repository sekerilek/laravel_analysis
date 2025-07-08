@extends('index')
@section('content')
<div class="col-md-12">
    <h3>Data Rak Baru</h3>
    <form action="/produksi/rak/upload" method="post">
        @csrf
        <table class="table table-bordered">
           <thead>
               <tr>
                   <th class="text-center"><h4>Rak Utama</h4></th>
                   <th class="text-center"><h4>Tambahan</h4></th>
               </tr>
           </thead> 
           <tbody>
               <tr>
                   <td class="utama">
                       <div class="form-group">
                           <label class="form-label">Harga : </label>
                           <input type="number" name="hargautama" class="form-control" min="0" step="1" value="0" required>
                       </div>
                       <div class="form-group">
                           <label class="form-label">Nama : </label>
                           <input type="text" name="namautama" class="form-control" placeholder="Nama Rak" required>
                       </div>
                       <table class="table" id="tableUtama">
                           <thead>
                               <tr>
                                   <th>Komponen</th>
                                   <th>Jumlah</th>
                                   <th>
                                       <button type="button" class="btn btn-primary btnAddUtama">
                                           <span class="fa fa-plus"></span>
                                       </button>
                                   </th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr>
                                   <td>
                                       <select name="komponenutama[]" class="form-control">
                                           <option value="" selected disabled hidden>Pilih Komponen</option>
                                           @foreach($komponen as $item)
                                           <option value="{{$item->KodeItem}}">{{$item->NamaItem}}</option>
                                           @endforeach
                                       </select>
                                   </td>
                                   <td>
                                       <input type="number" name="jumlahkomponenutama[]" class="form-control" min="1" step="1" value="1">
                                   </td>
                                   <td></td>
                               </tr>
                           </tbody>
                       </table>
                   </td>

                   <td class="tambahan">
                       <div class="form-group">
                           <label class="form-label">Harga : </label>
                           <input type="number" name="hargatambahan" class="form-control" min="0" step="1" value="0" required>
                       </div>
                       <table class="table" id="tableTambahan">
                           <thead>
                               <tr>
                                   <th>Komponen</th>
                                   <th>Jumlah</th>
                                   <th>
                                       <button type="button" class="btn btn-primary btnAddTambahan">
                                           <span class="fa fa-plus"></span>
                                       </button>
                                   </th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr>
                                   <td>
                                       <select name="komponentambahan[]" class="form-control">
                                           <option value="" selected disabled hidden>Pilih Komponen</option>
                                           @foreach($komponen as $item)
                                           <option value="{{$item->KodeItem}}">{{$item->NamaItem}}</option>
                                           @endforeach
                                       </select>
                                   </td>
                                   <td>
                                       <input type="number" name="jumlahkomponentambahan[]" class="form-control" min="1" step="1" value="1">
                                   </td>
                                   <td></td>
                               </tr>
                           </tbody>
                       </table>
                   </td>
               </tr>
           </tbody>
           <tfoot>
               <tr>
                   <td colspan="2">
                       <a href="/produksi/rak" class="btn btn-danger">Batal</a>
                       <button type="submit" class="btn btn-success">Upload</button>
                   </td>
               </tr>
           </tfoot>
        </table>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('select').select2();
        $('.btnAddUtama').click(function () {
            $('#tableUtama tbody tr:first select').select2('destroy');
            let $tr = $('#tableUtama tbody tr:first').html();
            $('#tableUtama tbody').append('<tr>'+$tr+'</tr>');
            $('#tableUtama tbody tr:last td:last').append('<button type="button" class="btn btn-sm btn-danger btnRemove"><span class="fa fa-minus"></span></button>');
            $('#tableUtama tbody tr:last select').val('');
            $('#tableUtama tbody select').select2({width: '100%'});
        });

        $('.btnAddTambahan').click(function () {
            $('#tableTambahan tbody tr:first select').select2('destroy');
            let $tr = $('#tableTambahan tbody tr:first').html();
            $('#tableTambahan tbody').append('<tr>'+$tr+'</tr>');
            $('#tableTambahan tbody tr:last td:last').append('<button type="button" class="btn btn-sm btn-danger btnRemove"><span class="fa fa-minus"></span></button>');
            $('#tableTambahan tbody tr:last select').val('');
            $('#tableTambahan tbody select').select2({width: '100%'});
        });

        $('.btnRemove').each(function () {
            $(this).parent('tr').remove();
        });
    });
</script>
@endpush