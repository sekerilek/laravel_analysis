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
						Tanggal&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{$kasir->Tanggal}}<br>
						Kode&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{$kasir->KodeKasir}}<br>
                       	Nama&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{$namapelanggan}}<br>
						Alamat&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{$alamatpelanggan}}<br/>
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
                        {{--<p hidden>{{$no = 1}}
                        {{$tot = 0}}</p>--}}
                        @foreach($kasirdetail as $item)
						@if($item->Qty == 0)
						<tr>
						</tr>
						@else
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{$item->NamaItem}}</td>
							<td>{{$item->KodeSatuan}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endif
						@if($item->Qty == 0)
						<tr>
						</tr>
						@else
						<tr>
							<td></td>
							<td>{{$item->Qty}}&nbsp;X&nbsp;{{number_format($item->Harga, 0, ',', '.')}}&nbsp;=</td>
							<td>{{number_format($item->Qty * $item->Harga, 0, ',', '.')}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endif
                        @endforeach
					</table>
					---------------------------------------------
					<table class="table table-bordered" style="width:100%;">
						<tr>
							<td>Total</td>
							<td></td>
							<td></td>
							<td>:&nbsp;Rp&nbsp;{{number_format(($kasir->Subtotal - $kasirreturn - $kasir->NilaiDiskon), 0, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Total Retur</td>
							<td></td>
							<td></td>
							<td>:&nbsp;Rp&nbsp;{{number_format(($kasirreturn), 0, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Ongkir</td>
							<td></td>
							<td></td>
							<td>:&nbsp;Rp&nbsp;{{number_format(($ongkir), 0, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Diskon</td>
							<td></td>
							<td></td>
							<td>:&nbsp;Rp&nbsp;{{number_format(($kasir->NilaiDiskon), 0, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Total Bayar</td>
							<td></td>
							<td></td>
							<td>:&nbsp;Rp&nbsp;{{number_format(($kasir->Subtotal - $kasirreturn + $ongkir - $kasir->NilaiDiskon), 0, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>  
						<tr>
							<td>Bayar</td>
							<td></td>
							<td></td>
							<td>:&nbsp;Rp&nbsp;{{number_format(($kasir->Bayar), 0, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>  
					</table>
					---------------------------------------------
					<table class="table table-bordered" style="width:100%;">
						<tr>
							<td>Kembalian</td>
							<td></td>
							<td></td>
							<td>:&nbsp;Rp&nbsp;{{number_format(($kasir->Bayar-($kasir->Subtotal - $kasirreturn) - $kasir->NilaiDiskon), 0, ',', '.')}}</td>
							<td></td>
							<td></td>
						</tr>
					</table>
					<div class="clearfix"></div>
					<center>
						<p><strong>Terima kasih telah berbelanja di toko kami !</strong></p>
						<p><strong>Barang yang telah dibeli tidak dapat dikembalikan</strong></p>
					</center>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</body>
</html>
