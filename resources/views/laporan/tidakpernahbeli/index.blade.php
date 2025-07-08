@extends('index')
@section('content')
<style type="text/css">
    #header {
        text-align: center;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="x_panel">
                <div class="x_body">
                        <!-- <div class="x_title"> -->
                        <h1 id="header">Laporan Tidak Pernah Beli</h1>
                        <!-- </div> -->
                    <!-- <input type="submit" name="" value="Print" class="btn btn-danger"> -->
                    <!-- </div> -->
                    <!-- </form> -->
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Kontak</th>
                                <th>Handphone</th>
                            </tr>
                        </thead>
                        {{-- <tbody> --}}
                            @foreach ($tpb as $item)
                            <tr>
                                <td>{{ $item->KodePelanggan }}</td>
                                <td>{{ $item->NamaPelanggan }}</td>
                                <td>{{ $item->Kontak }}</td>
                                <td>{{ $item->Handphone }}</td>
                            </tr>
                            @endforeach
                        {{-- </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        $('#table').DataTable({
            "order": [],
            "pageLength": 10
        });
    });
    

    $('#table').on('draw.dt', function() {
        initPage('{{Auth::user()->name}}');
    });
    $('#satuan').select2({
        width: '100%'
    });
</script>
@endpush