@extends('index')
@section('content')
<style type="text/css">
  #black {
    color: black;
  }
</style>
<div class="container">
  <div class="x_panel">
    <div class="x_title">
      <form action="{{ url('/penerimaanBarang')}}">
        <button class="btn btn-default" data-toggle="collapse" data-target="#filter" type="button">
          <h2>Filter</h2>
        </button>
        <button class="btn btn-default" type="submit">
          <h2>Tampilkan semua</h2>
        </button>
      </form>
    </div>
    <div id="filter" class="collapse">
      <form action="{{ url('/penerimaanBarang/cari')}}" method="get">
        <div class="x_content">
          <div class="col-md-5 col-sm-5">
            <div class="form-group">
              <label>Cari:</label>
              <input type="text" class="form-control" name="name" value="{{Request::get('name')}}" placeholder="Nomor PO / Nomor PB / Nama Supplier" />
            </div>
          </div>
          <div class="col-md-3 col-sm-3">
            <div class="form-group">
              <label for="tanggalpo">Dari:</label>
              <div class="input-group date" id="tanggalpo">
                <input type="text" class="form-control" name="start" value="{{ Request::get('start')}}" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-3">
            <div class="form-group">
              <label for="tanggalpo">Sampai:</label>
              <div class="input-group date" id="tanggalposampai">
                <input type="text" class="form-control" name="end" value="{{ Request::get('end') }}" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-2">
            <div class="form-group">
              <label for=""> </label>
              <div class="input-group">
                <button type="submit" class="btn btn-md btn-block btn-success">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Alert -->
  @if(session()->get('created'))
  <div class="alert alert-success alert-dismissible fade-show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <b>{{ session()->get('created') }}</b>
  </div>

  @elseif(session()->get('edited'))
  <div class="alert alert-info alert-dismissible fade-show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <b>{{ session()->get('edited') }}</b>
  </div>

  @elseif(session()->get('deleted'))
  <div class="alert alert-danger alert-dismissible fade-show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <b>{{ session()->get('deleted') }}</b>
  </div>

  @elseif(session()->get('error'))
  <div class="alert alert-warning alert-dismissible fade-show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <b id="black">{{ session()->get('error') }}</b>
  </div>
  @endif

  <div class="x_panel">
    <div class="x_title">
      <div class="row">
        <div class="col-md-6 col-sm-6">
            <h3>Penerimaan Barang</h3>
        </div>
        <div class="col-md-6 col-sm-6">
            <h3>
                <a href="{{ url('/penerimaanBarang/create')}}" class="btn btn-primary pull-right" data-function="tambah">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </h3>
        </div>
      </div>
    </div>
    <div class="x_content">
      <table class="table table-light table-striped" id="tpenerimaanbarang">
        <thead class="thead-light">
          <tr>
            <th scope="col">Nomor PB</th>
            <th scope="col">Nomor PO</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Supplier</th>
            <th scope="col">Gudang</th>
            <th scope="col">Total</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($penerimaanbarangs as $penerimaanbarang)
          <tr>
            <td>{{ $penerimaanbarang->KodePenerimaanBarang }}</td>
            <td>{{ $penerimaanbarang->KodePO }}</td>
            <td>{{ \Carbon\Carbon::parse($penerimaanbarang->Tanggal)->format('d-m-Y') }}</td>
            <td>{{ $penerimaanbarang->NamaSupplier }}</td>
            <td>{{ $penerimaanbarang->NamaLokasi }}</td>
            <td>Rp. {{ number_format($penerimaanbarang->Subtotal, 0, ',', '.') }},-</td>
            <td>
              @if ($penerimaanbarang->Status == 'OPN')
              <a href="{{ url('/penerimaanBarang/confirm/'.$penerimaanbarang->KodePenerimaanBarang)}}" class="btn-xs btn btn-info" onclick="return confirm('Konfirmasi data ini?')" data-function="konfirmasi">
                <i class="fa fa-check" aria-hidden="true"></i>
              </a>
              <a href="{{ url('/penerimaanBarang/show/'.$penerimaanbarang->KodePenerimaanBarang) }}" class="btn-xs btn btn-primary">
                <i class="fa fa-eye" aria-hidden="true"></i> Lihat
              </a>
              <a href="{{ url('penerimaanBarang/edit/'.$penerimaanbarang->KodePenerimaanBarang)}}" class="btn btn-xs btn-success" data-function="ubah">
                <i class="fa fa-pencil" aria-hidden="true"></i> Ubah
              </a>
              @elseif ($penerimaanbarang->Status == 'CFM')
              <a href="{{ url('/returnPenerimaanBarang/create/'. $penerimaanbarang->KodePenerimaanBarang )}}" class="btn-xs btn btn-warning" data-function="return">
                  <i class="fa fa-undo" aria-hidden="true"></i> <b>Return</b>
              </a>
              <a href="{{ url('/penerimaanBarang/show/'.$penerimaanbarang->KodePenerimaanBarang) }}" class="btn-xs btn btn-primary">
                <i class="fa fa-eye" aria-hidden="true"></i> Lihat
              </a>
              @endif
              <a href="{{ url('/penerimaanBarang/destroy/'.$penerimaanbarang->KodePenerimaanBarang)}}" class="btn-xs btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" data-function="hapus">
                <i class="fa fa-trash" aria-hidden="true"></i> Hapus
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
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
  
  $('#tanggalpo').datetimepicker({
    format: 'YYYY-MM-DD'
  });

  $('#tanggalposampai').datetimepicker({
    defaultDate: new Date(),
    format: 'YYYY-MM-DD'
  });

  $('#tpenerimaanbarang').DataTable({
    "order": [],
    "pageLength": 25
  });
</script>
@endpush