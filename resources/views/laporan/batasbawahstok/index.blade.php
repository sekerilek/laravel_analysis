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
                        <h1 id="header">Batas Bawah Stok</h1>
                        <!-- </div> -->
                    <!-- <input type="submit" name="" value="Print" class="btn btn-danger"> -->
                    <!-- </div> -->
                    <!-- </form> -->
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Batas Bawah</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        {{-- <tbody> --}}
                            @foreach ($batas as $item)
                            <tr>
                                <td>{{ $item->KodeItem }}</td>
                                <td>{{ $item->NamaItem }}</td>
                                <td>{{ $item->BatasBawah }}</td>
                                <td>{{ $item->saldo }}</td>
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