<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
        .card {
        	width  : 340px;
        	height : 225px;
            border: 1px solid #eeeeee;
        }
        
        .card_name {
        	font-family: Arial;
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .card-barcode {
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            	@foreach($data as $karyawan)
                <div class="card">
                	<div class="card_name">
                		<h3>{{$karyawan->Nama}}</h3>
                	</div>

                    <div class="card-barcode">
                        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($karyawan->KodeKaryawan, 'C39')}}" alt="barcode" height="50" width="200">
                    </div>
                </div>
              @endforeach
            </div>
        </div>
    </div>
</body>

</html>