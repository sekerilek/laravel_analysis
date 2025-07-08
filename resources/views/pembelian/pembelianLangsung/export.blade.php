<html>
<head>
	<title>Data Barang di Gudang</title>
</head>
<body>
 
	<h2>Pencatatan Transaksi Pembelian Putra Mandiri</h2><br>
 
	<table border="1">
		<tr>
			<th>Kode PO</th>
			<th>Kode Item</th>
			<th>QTY</th>
            <th>Kode Satuan</th>
            <th>Harga</th>
            <th>SubTotal</th>
            <th>Nama Supplier</th>
            <th>Alamat</th>
		</tr>
		@foreach($kasir as $kasir)
		<tr>
            <td>{{$kasir->KodePO}}</td>
			<td>{{$kasir->KodeItem}}</td>
			<td>{{$kasir->Qty}}</td>
			<td>{{$kasir->KodeSatuan}}</td>
            <td>{{$kasir->Harga}}</td>
            <td>{{$kasir->Subtotal}}</td>
            <td>{{$kasir->NamaSupplier}}</td>
            <td>{{$kasir->Alamat}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>