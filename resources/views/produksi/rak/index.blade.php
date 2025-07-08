@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="text-align:center">DATA RAK</h1>

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

                    <a href="{{ url('produksi/rak/new') }}" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah Rak
                    </a><br><br>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_body">
                    <table class="table table-striped" id="table-rak">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="#modalShow">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Data Rak
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tableShow">
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
                                   <input type="text" id="hargautama" class="form-control" readonly>
                               </div>
                               <div class="form-group">
                                   <label class="form-label">Nama : </label>
                                   <input type="text" id="namautama" class="form-control" readonly>
                               </div>
                               <table class="table" id="tableShowUtama">
                                   <thead>
                                       <tr>
                                           <th>Komponen</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <tr>
                                           <td><ul></ul></td>
                                       </tr>
                                   </tbody>
                               </table>
                           </td>

                           <td class="tambahan">
                               <div class="form-group">
                                   <label class="form-label">Harga : </label>
                                   <input type="text" id="hargatambahan" class="form-control" readonly>
                               </div>
                               <table class="table" id="tableShowTambahan">
                                   <thead>
                                       <tr>
                                           <th>Komponen</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <tr>
                                           <td><ul></ul></td>
                                       </tr>
                                   </tbody>
                               </table>
                           </td>
                       </tr>
                   </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="close btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    var $table = $('#table-rak').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/api/rak",
        columns: [
            { data: 'kode' },
            { data: 'nama' },
            { 
                data: 'harga',
                render: (data) => {
                    return data.toLocaleString('id-ID', { style:'currency', currency:'IDR', minimumFractionDigits:0 });
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    $('.btnShow').each(function () {
        $(this).click(function () {
            console.log($(this));
            $.ajax({
                url: '/produksi/rak/detail/' + $(this).data('id'),
                success: (response) => {
                    $('#namautama').val(response.namautama);
                    $('#hargautama').val(response.hargautama);
                    $('#tableShowUtama tbody td ul').append(response.komponenutama);
                    $('#hargatambahan').val(response.hargatambahan);
                    $('#tableShowTambahan tbody td ul').append(response.komponentambahan);

                    $('#modalShow').modal('show');
                },
                error: (error) => {
                    alert(error.message);
                    console.log(error);
                }
            });
        });
    });

    $('.btnEdit').each(function () {

    });

    $('.btnDelete').each(function () {
        $(this).click(function () {
            console.log($(this));
            if (confirm('Hapus data rak?')) {
                $.ajax({
                    url: '/produksi/rak/delete',
                    method: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        kode: $(this).data('id')
                    },
                    success: (response) => {
                        alert('Data rak ' + response.rak + ' telah dihapus');
                        $table.draw(false);
                    },
                    error: (error) => {
                        alert(error.message);
                        console.log(error);
                    }
                });
            }
        });
    });
});
</script>
@endpush