@extends('index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Invoice Hutang</h1>
                </div>
                <div class="x_content">
                    @foreach($invoice as $inv)
                    <form action="{{ url('invoicehutang/update/'.$inv->KodeInvoiceHutangShow) }}" method="post" style="display:inline-block;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="KodeInvoice" value="{{ $inv->KodeInvoiceHutangShow }}" class="form-control">
                        <div class="form-group">
                            <label>No Faktur: </label>
                            <input type="text" name="NoFaktur" value="{{ $inv->NoFaktur }}" placeholder="No Faktur" class="form-control">
                        </div>
                        <br>
                        <button class="btn btn-success" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection