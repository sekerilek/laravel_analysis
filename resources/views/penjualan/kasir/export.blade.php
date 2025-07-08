<html>
<head>
	<title>Data Barang di Gudang</title>
</head>
<body>
 
	<h2>Pencatatan Transaksi Penjualan Kasir</h2>
 
	<table border="1">
		<tr>
			<th>Kode Kasir</th>
			<th>Kode Item</th>
			<th>QTY</th>
            <th>Kode Satuan</th>
            <th>Harga</th>
            <th>SubTotal</th>
            <th>created_at</th>
            <th>updated_at</th>
		</tr>
		@foreach($kasir as $kasir)
		<tr>
            <td>{{$kasir->KodeKasir}}</td>
			<td>{{$kasir->KodeItem}}</td>
			<td>{{$kasir->Qty}}</td>
			<td>{{$kasir->KodeSatuan}}</td>
            <td>{{$kasir->Harga}}</td>
            <td>{{$kasir->Subtotal}}</td>
            <td>{{$kasir->created_at}}</td>
            <td>{{$kasir->updated_at}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>