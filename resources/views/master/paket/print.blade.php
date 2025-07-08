<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slimplan-Master Item</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                              <th>Kode Kategori</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Kode Satuan</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Harga Member</th>
                                <th>Harga Grosir</th>
								<th>Harga Grab</th>
								<th>Harga Shopee</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($item as $i)
                            <tr>
                                <td>{{$i->KodeKategori}}</td>
                                <td>{{$i->KodeItem}}</td>
                                <td>{{$i->NamaItem}}</td>
                                <td>{{$i->KodeSatuan}}</td>
                                <td>Rp. {{number_format($i->HargaBeli, 0, ',', '.')}},-</td>
                                <td>Rp. {{number_format($i->HargaJual, 0, ',', '.')}},-</td>
                                <td>Rp. {{number_format($i->HargaMember, 0, ',', '.')}},-</td>
                                <td>Rp. {{number_format($i->HargaGrosir, 0, ',', '.')}},-</td>
								<td>Rp. {{number_format($i->Grab, 0, ',', '.')}},-</td>
								<td>Rp. {{number_format($i->Shopee, 0, ',', '.')}},-</td>
                            <tr>
                            @endforeach
                            </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>
</html>