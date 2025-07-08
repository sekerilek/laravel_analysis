<html>
    <head></head>
    <body>
        <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h1>Kartu Stok</h1><br>
                    </div>
                    <div class="x_body">
                        <table border="1px solid black">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>ID Item</th>
                                    <th>ID Gudang</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Kode Transaksi</th>
                                    <th>QTY</th>
                                    <th>Average Price</th>
                                    <th>ID User</th>
                                    <th>idx</th>
                                    <th>indexmov</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stok as $stokmasuk)
                                    <tr>
                                        <td>{{ $stokmasuk->Tanggal}}</td>
                                        <td>{{ $stokmasuk->KodeItem}}</td>
                                        <td>{{ $stokmasuk->KodeLokasi}}</td>
                                        <td>{{ $stokmasuk->JenisTransaksi }}</td>
                                        <td>{{ $stokmasuk->KodeTransaksi}}</td>
                                        <td>{{ $stokmasuk->Qty}}</td>
                                        <td>{{ $stokmasuk->HargaRata}}</td>
                                        <td>{{ $stokmasuk->KodeUser}}</td>
                                        <td>{{ $stokmasuk->idx }}</td>
                                        <td>{{ $stokmasuk->indexmov}}</td>
                                        <td>{{ $stokmasuk->saldo}}</td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>