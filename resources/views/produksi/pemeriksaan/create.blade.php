@extends('index')
@section('content')
<style type="text/css">
    form {
        margin: 20px 0;
    }

    form input,
    button {
        padding: 5px;
    }

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
            <div class="x_panel">
                <div class="x_title">
                    <h1 id="header">Pemeriksaan Hasil Produksi</h1>
                </div>
                <div class="x_content">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <br>
                                <label for="">Kode Produksi</label>
                                <select name="prodId" class="form-control" id="prodId">
                                    <option value="0">- Pilih Kode Produksi -</option>
                                    @foreach($produksi as $p)
                                    <option name="KodeProduksi" value="{{$p->KodeProduksi}}">{{$p->KodeProduksi}}</option>
                                    @endforeach
                                </select>
                                <br><br>
                                <div class="po-select-container">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                        </div>
                        <div class="prod-detail-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#prodId').select2()

    $('#inputDate').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('body').on('change', '#prodId', function() {
        var prodId = $('#prodId option:selected').attr('value');
        if (prodId == 0) {
            $('.prod-detail-container').html('')
        } else {
            var my_url = '/pemeriksaanproduksi/select/' + prodId;
            $.get(my_url, function(datas, status) {
                $('.prod-detail-container').html(datas)
            });
            console.log(my_url);
        }
    });

    function refresh(val) {
        var base = "{{ url('/') }}" + "/pemeriksaanproduksi/create/" + val.value;
        window.location.href = base;
    }
</script>
@endpush