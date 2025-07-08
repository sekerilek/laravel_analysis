@extends('index')
@section('content')
<div class="container">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Penerimaan Barang Batal</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <form>

        <!-- Contents -->
        <hr class="style1">
        <div class="form-row">
          <table id="penerimaanbarang" class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Kode LPB</th>
                <th scope="col">Kode PO</th>
                <th scope="col">Supplier</th>
                <th scope="col">Gudang</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  var table = $('#penerimaanbarang').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('api.penerimaanbarangDEL') }}",
    columns: [{
        data: 'KodePenerimaanBarang',
        name: 'KodePenerimaanBarang'
      },
      {
        data: 'KodePO',
        name: 'KodePO'
      },
      {
        data: 'NamaSupplier',
        name: 'NamaSupplier'
      },
      {
        data: 'NamaLokasi',
        name: 'NamaLokasi'
      },
      {
        data: 'Tanggal',
        name: 'Tanggal'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }
    ]
  });
</script>
@endpush