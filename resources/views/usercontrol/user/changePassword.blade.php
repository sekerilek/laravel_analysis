@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card uper">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Ubah Password</h1>
                    </div>
                    <div class="x_content">
                        <form action="{{ url('/user/change') }}" method="get" style="display:inline-block;">
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

                            @method('GET')
                            @foreach($users as $user)
                            <input type="hidden" name="name" value="{{ $user->name }}" class="form-control">
                            @endforeach
                            <div class="form-group">
                                <label>Password Lama: </label>
                                <input type="password" required="required" name="password" placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password Baru: </label>
                                <input type="password" required="required" name="newpassword" placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ulangi Password Baru: </label>
                                <input type="password" required="required" name="newpassword_confirmation" placeholder="Password" class="form-control">
                            </div>
                            <br>
                            <button class="btn btn-success" style="width:120px;" onclick="return confirm('Konfirmasi ubah password?')">Simpan</button>
                        </form>
                        <form action="{{ url('/user') }}" method="get">
                            <button class="btn btn-danger" style="width:120px;">Batal</button>
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
    $(document).ready(function() {
        $('#Tipe').select2();
    });
</script>
@endpush