<html>
	<head>
		<title>print</title>
		<link rel="stylesheet" href="assets/css/bootstrap.css">
		<style type="text/css">
			.right{
				text-align:right;
			}
			.judul{
				font-weight: bold;
			}
			td{
				font-weight:700;
			}
		</style>
	</head>
	<body>
		<script>window.print();</script>
		<div class="container">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<left>
						<center><p class="judul">SMART HEALTHY FROZEN FOOD</p></center>
						<strong>Jl. Bukit Dieng L-2<br>
						Kota Malang<br>
						085810308951<br/><br/>
						Tanggal 	: {{$kasir->Tanggal}}<br>
						Kode 	: {{$kasir->KodeKasir}}<br>
                       	Nama		:{{$pelanggan->NamaPelanggan}}<br>
						Alamat	:{{$alamat->Alamat}}<br/>
						---------------------------------------------</strong>
					</left>
					<table class="table table-bordered" style="width:100%;">
						<tr>
							<td>No.</td>
							<td>Barang</td>
							<td>Subtotal</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
                        <p hidden>{{$no = 1}}
                        {{$tot = 0}}</p>
                        @foreach($items as $item)
						<tr>
							<td>{{$no++}}</td>
							<td>{{$item->NamaItem}}</td>
							<td>{{$item->KodeSatuan}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>{{$item->Qty}} &nbsp X &nbsp{{number_format($item->Harga)}}&nbsp =</td>
							<td>{{number_format($item->Subtotal)}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
                        @endforeach
					</table>
					---------------------------------------------
					<table class="table table-bordered" style="width:100%;">
						<tr>
							<td>Total</td>
							<td></td>
							<td></td>
							<td>: &nbsp Rp.{{number_format(($kasir->Subtotal), 2, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Ongkir</td>
							<td></td>
							<td></td>
							<td>: &nbsp Rp.{{number_format(($ongkir->TarifPelanggan), 2, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Total Bayar</td>
							<td></td>
							<td></td>
							<td>: &nbsp Rp.{{number_format(($kasir->Total), 2, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>  
						<tr>
							<td>Bayar</td>
							<td></td>
							<td></td>
							<td>: &nbsp Rp.{{number_format(($kasir->Bayar), 2, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>  
					</table>
					---------------------------------------------
					<table class="table table-bordered" style="width:100%;">
						<tr>
							<td>Kembalian</td>
							<td>:  &nbsp Rp.{{number_format(($kasir->Kembalian), 2, ',', '.')}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</table>
					<div class="clearfix"></div>
					<center>
						<p><strong>Terima Kasih Telah berbelanja di toko kami !</strong></p>
						<p><strong>Barang yang telah dibeli tidak dapat dikembalikan</strong></p>
					</center>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</body>
</html>
