@extends('index')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">

      <!-- <div class="x_panel">
              <div class="x_title">
                <h3>Filter Tanggal</h3>
              </div>
              <form action="{{ url('/sopenjualan')}}" method="get">
                <div class="x_content">
                  <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                        <label for="tanggalpo">Dari :</label>
                        <div class="input-group date" id="tanggalpo">
                            <input type="text" class="form-control" name="start"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                        <label for="tanggalpo">Sampai :</label>
                        <div class="input-group date" id="tanggalposampai" name="end">
                            <input type="text" class="form-control"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="form-group">
                      <label for="">Filter</label>
                      <div class="input-group">
                        <input type="submit" class="btn btn-md btn-block btn-primary" value="Filter">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
          </div> -->

      <div class="x_panel">
        <div class="x_title">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <h3>Penjualan Langsung</h3>
            </div>
            <div class="col-md-6 col-sm-6">
              <a href="{{ url('/penjualanLangsung/create')}}" class="btn btn-success pull-right">
                <i class="fa fa-plus" aria-hidden="true"></i> Penjualan Langsung
              </a>
            </div>
          </div>
        </div>
        <div class="x_content">
          <table class="table table-light" id="table">
            <thead class="thead-light">
              <tr>
                <th>Kode Penjualan</th>
                <th>Tanggal</th>
                <th>Gudang</th>
                <th>MataUang</th>
                <th>Pelanggan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            @foreach ($penjualanlangsung as $p)
            <tr>
              <td>{{ $p->KodePenjualanLangsung }}</td>
              <td>{{ \Carbon\Carbon::parse($p->Tanggal)->format('d-m-Y') }}</td>
              <td>{{ $p->NamaLokasi }}</td>
              <td>{{ $p->NamaMataUang }}</td>
              <td>{{ $p->NamaPelanggan }}</td>
              <td>
                <a href="{{ url('/penjualanLangsung/show/'. $p->KodePenjualanLangsung )}}" class="btn-xs btn btn-primary">
                  <i class="fa fa-eye" aria-hidden="true"></i> Lihat
                </a>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')

<script type="text/javascript">
  $('#table').DataTable();
</script>


@endpush