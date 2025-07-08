<html>
<head>
	<title>Data Barang di Gudang</title>
</head>
<body>
 
	<h2>Pencatatan Transaksi Penerimaan Barang Putra Mandiri</h2>
 
	<table border="1">
		<tr>
			<th>Kode Penerimaan Barang</th>
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
			<td>{{$kasir->KodePenerimaanBarang}}</td>
            <td>{{$kasir->KodePO}}</td>
			<td>{{$kasir->KodeItem}}</td>
			<td>{{$kasir->Qty}}</td>
			<td>{{$kasir->KodeSatuan}}</td>
            <td>{{$kasir->Harga}}</td>
            <td>{{$kasir->Total}}</td>
            <td>{{$kasir->NamaSupplier}}</td>
            <td>{{$kasir->Alamat}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>