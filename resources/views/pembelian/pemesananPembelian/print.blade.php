<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style>
        p,
        tr {
            font-size: 15px;
            margin: 2;
        }

        form {
            margin: 0;
        }

        form input,
        button {
            padding: 0px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            padding: 0;
            margin: 0;
        }

        table,
        th,
        td {
            border: 1px solid #cdcdcd;
        }

        table th,
        table td {
            padding: 0;
            text-align: left;
        }

        .column {
            margin: 0;
            display: inline-block;
            float: left;
            width: 33%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        #center {
            text-align: center;
        }

        #right {
            text-align: right;
        }

        #marginless {
            margin: 0;
        }

        #borderless {
            border-collapse: collapse;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        @csrf
                        <!-- Contents -->
                        <div class="form-row">
                            <p id="center"><b>PEMESANAN PEMBELIAN</b></p>
                        </div>
                        <br>
                        <div class="form-row" id="marginless">
                            <div style="width: 50%; float:left">
                                <table id="borderless">
                                    <tr id="borderless">
                                        <td width="25%" id="borderless">
                                            <p>Kepada yth.</p>
                                        </td>
                                        <td width="75%" id="borderless">
                                            @foreach($data as $dt)
                                            <p>:&nbsp; {{$dt->NamaSupplier}}</p>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="width: 50%; float:right">
                                <table id="borderless">
                                    <tr id="borderless">
                                        <td width="60%" id="borderless">
                                            <p id="right">No. PO :</p>
                                        </td>
                                        <td width="40%" id="borderless">
                                            @foreach($data as $dt)
                                            <p>{{$dt->KodePO}}</p>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr id="borderless">
                                        <td width="60%" id="borderless">
                                            <p id="right">Tanggal :</p>
                                        </td>
                                        <td width="40%" id="borderless">
                                            @foreach($data as $dt)
                                            <p>{{$dt->Tanggal}}</p>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br><br><br><br>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <table id="items">
                                    <tr>
                                        <td id="center"><b>No</b></td>
                                        <td id="center"><b>Nama Barang</b></td>
                                        <td id="center"><b>Qty</b></td>
                                        <td id="center"><b>Satuan</b></td>
                                        <td id="center"><b>Harga</b></td>
                                        <td id="center"><b>Subtotal</b></td>
                                    </tr>
                                    {{$no = 1}}
                                    @foreach($items as $item)
                                    <tr class="rowinput">
                                        <td>
                                            &nbsp;&nbsp;&nbsp;{{$no++}}
                                        </td>
                                        <td>
                                            &nbsp;&nbsp;&nbsp;{{$item->NamaItem}}
                                        </td>
                                        <td id="right">
                                            {{$item->Qty}}&nbsp;&nbsp;&nbsp;
                                        </td>
                                        <td id="right">
                                            {{$item->KodeSatuan}}&nbsp;&nbsp;&nbsp;
                                        </td>
                                        <td id="right">
                                            Rp. {{number_format(($item->Harga), 0, ',', '.')}},-&nbsp;&nbsp;&nbsp;
                                        </td>
                                        <td id="right">
                                            Rp. {{number_format(($item->Harga*$item->Qty), 0, ',', '.')}},-&nbsp;&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <br><br>
                                <div class="row">
                                    <div class="column">
                                        @foreach($data as $dt)
                                        <p>Keterangan : {{$dt->Keterangan}}</p>
                                        @endforeach
                                    </div>
                                    <div class="column"></div>
                                    <div class="column">
                                        @foreach($data as $dt)
                                        <table id="borderless">
                                            <tr id="borderless">
                                                <td width="35%" id="borderless">
                                                    <p>Subtotal</p>
                                                </td>
                                                <td width="65%" id="borderless">
                                                    <p>:&nbsp; Rp. {{number_format(($dt->Subtotal), 0, ',', '.')}},-</p>
                                                </td>
                                            </tr>
                                            <tr id="borderless">
                                                <td width="35%" id="borderless">
                                                    <p>Diskon</p>
                                                </td>
                                                <td width="65%" id="borderless">
                                                    <p>:&nbsp; Rp. {{number_format(($dt->NilaiDiskon), 0, ',', '.')}},-</p>
                                                </td>
                                            </tr>
                                            <tr id="borderless">
                                                <td width="35%" id="borderless">
                                                    <p>PPN</p>
                                                </td>
                                                <td width="65%" id="borderless">
                                                    <p>:&nbsp; Rp. {{number_format(($dt->NilaiPPN), 0, ',', '.')}},-</p>
                                                </td>
                                            </tr>
                                            <tr id="borderless">
                                                <td width="35%" id="borderless">
                                                    <p>Total</p>
                                                </td>
                                                <td width="65%" id="borderless">
                                                    <p>:&nbsp; Rp. {{number_format(($dt->Total), 0, ',', '.')}},-</p>
                                                </td>
                                            </tr>
                                        </table>
                                        @endforeach
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="column"></div>
                                    <div class="column">
                                        <p id="center">Penerima,</p>
                                        <br><br>
                                        <p id="center">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ) </p>
                                    </div>
                                    <div class="column">
                                        <p id="center">Hormat kami,</p>
                                        <br><br>
                                        <p id="center">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ) </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>