@extends('index')
@section('content')
<style type="text/css">
  #black {
    color: black;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <form action="{{ url('/returnSuratJalan')}}">
            <button class="btn btn-default" data-toggle="collapse" data-target="#filter" type="button">
              <h2>Filter</h2>
            </button>
            <button class="btn btn-default" type="submit">
              <h2>Tampilkan semua</h2>
            </button>
          </form>
        </div>
        <div id="filter" class="collapse">
          <form class="" action="{{ url('/returnSuratJalan/cari')}}" method="get">
            <div class="x_content">
              <div class="col-md-3 col-sm-3">
                <div class="form-group">
                  <label for="tanggalpo">Dari :</label>
                  <div class="input-group date" id="start">
                    <input type="text" class="form-control" name="start" value="{{ Request::get('start')}}" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="form-group">
                  <label for="tanggalpo">Sampai :</label>
                  <div class="input-group date" id="end">
                    <input type="text" class="form-control" name="end" value="{{ Request::get('end')}}" />
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

      <div class="clearfix"></div>

      <div class="x_panel">
        <div class="x_title">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <h3>Return Surat Jalan</h3>
                </div>
            </div>
        </div>
        <div class="x_content">
          <table class="table table-light" id="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">Nomor SJ Return</th>
                <th scope="col">Nomor SJ</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($suratjalanreturns as $suratjalanreturn)
              <tr>
                <td>{{ $suratjalanreturn->KodeSuratJalanReturn}}</td>
                <td>{{ $suratjalanreturn->KodeSuratJalan}}</td>
                <td>{{ \Carbon\Carbon::parse($suratjalanreturn->Tanggal)->format('d-m-Y') }}</td>
                <td>{{ $suratjalanreturn->Keterangan}}</td>
                <td>Rp. {{ number_format($suratjalanreturn->Subtotal, 0, ',', '.') }},-</td>
                <td>
                  <a href="{{ url('/returnSuratJalan/show/'.$suratjalanreturn->KodeSuratJalanReturnID) }}" class="btn-xs btn btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> Lihat
                  </a>
                  <a href="{{ url('/returnSuratJalan/destroy/'.$suratjalanreturn->KodeSuratJalanReturnID) }}" class="btn-xs btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" data-function="hapus">
                    <i class=" fa fa-trash" aria-hidden="true"></i> Hapus
                  </a>
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
  
  $('#start').datetimepicker({
    defaultDate: new Date(),
    format: 'YYYY-MM-DD'
  });

  $('#end').datetimepicker({
    defaultDate: new Date(),
    format: 'YYYY-MM-DD'
  });

  $('#table').DataTable({
    "order": [],
    "pageLength": 25
  });
</script>
@endpush