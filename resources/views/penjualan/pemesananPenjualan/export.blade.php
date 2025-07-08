<html>
<head>
	<title>Data Barang di Gudang</title>
</head>
<body>
 
	<h2>Pencatatan Transaksi Pemesanan Penjualan Putra Mandiri</h2>
 
	<table border="1">
		<tr>
			<th>Kode SO</th>
			<th>Kode Item</th>
			<th>QTY</th>
            <th>Kode Satuan</th>
            <th>Harga</th>
            <th>SubTotal</th>
            <th>Nama Pelanggan</th>
		</tr>
		@foreach($kasir as $kasir)
		<tr>
            <td>{{$kasir->KodeSO}}</td>
			<td>{{$kasir->KodeItem}}</td>
			<td>{{$kasir->Qty}}</td>
			<td>{{$kasir->KodeSatuan}}</td>
            <td>{{$kasir->Harga}}</td>
            <td>{{$kasir->Subtotal}}</td>
            <td>{{$kasir->NamaPelanggan}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>