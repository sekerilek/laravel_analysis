@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1 style="text-align:center">User</h1><br>
                </div>
                <div class="x_body">

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

                    <br>
                    @if (Auth::user() && Auth::user()->name == 'admin')
                    <div style="float: left;">
                        <a href="{{ url('/user/add')}}" class="btn btn-primary">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah user
                        </a>
                    </div>
                    @endif
                    <br><br>
                    <table class="table table-striped table-light" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Ditambahkan tanggal</th>
                                <th>Terakhir login</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->last_login)->format('d-m-Y') }}</td>
                                <td>
                                    @if (Auth::user() && Auth::user()->name == 'admin')

                                    <a href="{{ url('/user/reset/'. $user->name )}}" class="btn-xs btn btn-primary">
                                        <i class="fa fa-key" aria-hidden="true"></i> Ubah password
                                    </a>
                                    <a href="{{ url('/user/destroy/'.$user->name )}}" class="btn-xs btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus user ini?')">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                    </a>
                                    @if ($user->name != 'admin')
                                    <a href="{{ url('/user/access/'. $user->name)}}" class="btn-xs btn btn-warning">
                                        <i class="fa fa-lock" aria-hidden="true"></i> Ubah Akses
                                    </a>
                                    @endif
                                    
                                    @endif
                                </td>
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
            [0, "asc"]
        ]
    });
</script>
@endpush