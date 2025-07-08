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
                <!-- <div class="x_title"> -->
                <h1 id="header">Sisa Stok</h1><br>
                <form action="{{ url('/sisastok/show') }}" method="get" style="display:inline-block;">
                    <button class="btn btn-default" type="submit">
                        Tampilkan Semua
                    </button>
                </form>
                <form style="display:inline-block;">
                    <button class="btn btn-default" data-toggle="collapse" data-target="#filteritem" type="button">
                        Filter
                    </button>
                </form>
                <br>
                <div id="filteritem" class="collapse">
                    <div class="x_content">
                        <div class="row">
                            <form action="{{ url('/sisastok/filter') }}" method="post">
                                @csrf
                                @method('post')
                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Item</label>
                                        <select class="form-control" name="item" id="item">
                                            <option value="" disabled hidden>Pilih Item</option>
                                            @foreach(session()->get('item_list') as $i)
                                            <option value="{{ $i->KodeItem }}">{{ $i->NamaItem }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-md btn-block btn-success">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>

            <div class="x_panel">
                <div class="x_body">
                    @if($filter)
                    <table class="table table-light table-striped" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Satuan</th>
                                <th>Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                @if(count($item->KodeItem) > 1)
                                <td rowspan="{{ count($item->KodeItem) }}">{{ $item->KodeItem }}</td>
                                @else

                                @endif
                                <td>{{ $item->NamaItem }}</td>
                                <td>{{ $item->NamaSatuan }}</td>
                                <td>{{ $item->SisaStok }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        if ($('body').has('[data-function]')) {
            $('[data-function]').each(function() {
                initPage('{{Auth::user()->name}}', $(this).data('function'));
            });
        }
        else {
            initPage('{{Auth::user()->name}}');
        }
    });
    
    $('#table').DataTable({
        "order": [],
        "pageLength": 25
    });

    $('#item').select2({
        width: '100%'
    }).val("{{ session()->get('item') }}").trigger('change');
</script>
@endpush