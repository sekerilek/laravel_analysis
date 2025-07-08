@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 style="text-align:center">Eventlog</h1><br>
                </div>
                <div class="x_body">
                    <table class="table table-striped table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>User</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eventlog as $event)
                            <tr>
                                <td>{{ $event->Tanggal}}</td>
                                <td>{{ $event->Jam}}</td>
                                <td>{{ $event->KodeUser}}</td>
                                <td>{{ $event->Keterangan}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#tanggalsampai').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });

    $('#table').DataTable({
        "order": [
            [0, "desc"]
        ],
        "pageLength": 25
    });
</script>
@endpush