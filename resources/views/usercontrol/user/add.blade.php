@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Tambah User</h1>
                    </div>
                    <div class="x_content">
                        @if (Auth::user() && Auth::user()->name == 'admin')
                        <form action="{{ url('/user/store') }}" method="post" style="display:inline-block;">
                            @csrf

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @method('POST')
                            <div class="form-group">
                                <label>Username: </label>
                                <input type="text" required="required" name="username" placeholder="Username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama: </label>
                                <input type="text" required="required" name="name" placeholder="Nama" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password: </label>
                                <input type="password" required="required" name="password" placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ulangi Password: </label>
                                <input type="password" required="required" name="password_confirmation" placeholder="Password" class="form-control">
                            </div>
                            <br>
                            <button class="btn btn-success" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                        </form>
                        <form action="{{ url('/user') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#Tipe').select2();
    });
</script>
@endpush