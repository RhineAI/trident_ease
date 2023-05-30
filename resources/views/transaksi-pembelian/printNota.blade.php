<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Nota</title>
    @if ($cPerusahaan->logo == null)
        <link rel="icon" href="{{ asset('assets') }}/img/buildings.png" type="image/png">
    @else
        <link rel="icon" href="{{ $cPerusahaan->logo }}" type="image/png">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 4px;
            font-size: 10pt;
        }
        table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: end;
        }

        @page {
            /* size: 7in 10.5in ; */
            /* scale: 200; */
            margin: 0.4in;
            
        }


        @media print {
            html, body {
                margin: 0 auto;
            }

            #btn-print {
                display: none;
            }
        }

        tr.spaceUnder5>td {
            padding-bottom: 5em;
        }

        tr.spaceUnder2>td {
            padding-bottom: 2em;
        }

        table.bordered {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table.bordered td, table.bordered th {
            border: 1.325px solid black;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body onload="window.print()">
    {{-- <button class="btn-print" id="btn-print" style="position: absolute; right: 0px; top: 0px; padding: 2px; width: 100px; background: #4195D5; border-radius: 15px; color: white; border-color: blue; cursor: pointer;" onclick="window.print()">Print</button> --}}
    <div class="button ml-4 align-items-end">
        @if (auth()->user()->hak_akses == 'admin') 
            <a href="{{ route('admin.list-pembelian.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" id="btn-back"><i class="fas fa-arrow-rotate-left"></i> Data Transaksi</a>
            <a href="{{ route('admin.transaksi-pembelian.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" target="_blank" rel="noopener noreferrer"><i class="fas fa-plus"></i> Transaksi Baru</a>
        @elseif (auth()->user()->hak_akses == 'kasir')
            <a href="{{ route('kasir.list-pembelian.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" id="btn-back"><i class="fas fa-arrow-rotate-left"></i> Data Transaksi</a>
            <a href="{{ route('kasir.transaksi-pembelian.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" target="_blank" rel="noopener noreferrer"><i class="fas fa-plus"></i> Transaksi Baru</a>
        @endif
        <button onclick="window.print()" class="mb-3 mt-3 btn btn-sm btn-danger ml-4 d-print-none btn-print" id="btn-print"><i class="fa-solid fa-print"></i> Print PDF</button>
    </div> 
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($cPerusahaan->nama) }}</h3>
        <p>{{ strtoupper($cPerusahaan->alamat) }}</p>
    </div>
    <br> <br>
    <div>
        <p>{{ date('d-m-Y') }}</p>
        <p>No Faktur : {{ $cPembelian->id_transaksi }}</p>
    </div>
    <p>Petugas : {{ strtoupper(auth()->user()->nama) }}</p>
    <p>Supplier : {{ $cPembelian->nama_supplier }}</p>
    <p class="text-center">================================</p>
    {{-- <small style="visibility: hidden; display: none;">{{ $totalDiskon = 0 }}</small> --}}
    <table width="100%" style="border: 0;">
        @foreach ($cDetailPembelian as $item)
            {{-- <small style="">{{ $item->qty * $item->harga_beli * $item->diskon/100 }}</small> --}}
            <tr>
                <td colspan="3">{{ $item->nama_barang }}</td>
            </tr>
            <tr>
                <td>{{ $item->qty }} x Rp.{{ format_uang($item->harga_beli) }} </td>
                <td></td>
            @if ($item->diskon == 0)
                <td class="text-right"> &nbsp; Rp.{{ format_uang(($item->qty * $item->harga_beli)) }}</td>
            </tr>
            @else 
                <td class="text-right"></td>
            </tr>
            <tr>
                <td>Disc. {{ $item->diskon }}%</td>
                <td></td>
                <td class="text-right"> &nbsp; Rp.{{ format_uang(($item->qty * $item->harga_beli) - ($item->qty * $item->harga_beli * $item->diskon/100)  ) }}</td>
            </tr>
            @endif
        @endforeach
    </table>
    <p class="text-center">-------------------------------</p>
    <table width="100%" style="border: 0;">
        <tr>
            <td>Total :&nbsp;</td>
            <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPembelian->total_pembelian) }}</td>
        </tr>
        @if ($cPembelian->jenis_pembayaran == 1)
            <tr>
                <td>Bayar :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPembelian->bayar) }}</td>
            </tr>
            <tr>
                <td>Kembalian :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPembelian->bayar - $cPembelian->total_pembelian ) }}</td>
            </tr>
        @elseif ($cPembelian->jenis_pembayaran == 2)
            <tr>
                <td>DP :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPembelian->dp) }}</td>
            </tr>
            <tr>
                <td>Sisa :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPembelian->total_pembelian - $cPembelian->dp) }}</td>
            </tr>
        @else 
        <tr>
            <p class="text-center">Pembayaran Via Transfer</p>

        </tr>
        @endif     
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    {{-- <table class="mt-4" style='font-size:90%' width='100%' border='0'>
        <tr>
            <td width='30%' align='center'>Hormat Kami
            </td>
            <td width='40%' align='center'>
                
            </td>
            <td width='30%' align='center'>
                Penerima Barang
            </td>
        </tr>

        <tr>
            <td width='30%' align='left'>
        </td>
            <td width='40%'>
                <br><br>
            </td>
            <td width='30%' align='left'>
            </td>
        </tr>

        <tr>
            <td width='30%' align='left'>
        </td>
            <td width='40%'>
                <br><br>
            </td>
            <td width='30%' align='left'>
            </td>
        </tr>
        
        <tr>
            <td width='30%' align='center'>
                ...................<br>
                {{ strtoupper(auth()->user()->nama) }}
            </td>
            <td width='40%'>
            </td>
            <td width='30%' align='center'>
                ...................<br>
                {{ $cPembelian->nama_pelanggan }}
            </td>
        </tr>
    </table> --}}

    <script>
        let body = document.body;
        let html = document.documentElement;
        // let height = Math.max(
        //         body.scrollHeight, body.offsetHeight,
        //         html.clientHeight, html.scrollHeight, html.offsetHeight
        //     );

        // document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        // document.cookie = "innerHeight="+ ((height + 20) * 0.264583);
    </script>
</body>
</html>

{{-- <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Cetak Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courgette&family=Poppins:wght@300;400;500;600;700&display=swap');
        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        #invoice-POS {
            /* box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); */
            padding: 2mm;
            margin: 0 auto;
            width: 44mm;
            /* background: #FFF; */
        }

        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice-POS h2 {
            font-size: .9em;
        }

        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 1em;
        }

        #invoice-POS p {
            font-size: .42em;
            color: #666;
            line-height: 1.2em;
        }

        /* #invoice-POS #top,
        #invoice-POS #mid,
        #invoice-POS #bot {
            border-bottom: 1px solid #EEE;
        } */

        #invoice-POS #top {
            min-height: 20px;
        }

        #invoice-POS #mid {
            min-height: 30px;
        }

        #invoice-POS #bot {
            min-height: 50px;
        }

        /* #invoice-POS #top .logo {
            height: 40px;
            width: 150px;
            background: url(https://www.sistemit.com/wp-content/uploads/2020/02/SISTEMITCOM-smlest.png) no-repeat;
            background-size: 150px 40px;
        }

        #invoice-POS .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(https://www.sistemit.com/wp-content/uploads/2020/02/SISTEMITCOM-smlest.png) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        } */

        #invoice-POS .info {
            display: block;
            margin-left: 0;
        }

        #invoice-POS .title {
            float: right;
        }

        #invoice-POS .title p {
            text-align: right;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tabletitle {
            font-size: .5em;
            background: #EEE;
        }

        /* #invoice-POS .service {
            border-bottom: 1px solid #EEE;
        } */

        #invoice-POS .item {
            width: 23mm;
        }

        #invoice-POS .itemtext {
            font-size: .42em;
        }

        #invoice-POS #legalcopy {
            margin-top: 5mm;
            text-align: center;
        }

        table #rate {
            text-align: end; 
            margin-right: .3em;
        }

        .slogan {
            font-family: 'Courgette', cursive;
            /* font-family: 'Poppins', sans-serif; */
        }
    </style>

    <script>
        window.console = window.console || function (t) {};
    </script>

    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>


</head>

<body translate="no">
    <div id="invoice-POS">

        <center id="top">
            <div class="info">
                <h2>{{ strtoupper($cPerusahaan->nama) }}</h2>
                <p>{{ strtoupper($cPerusahaan->alamat) }}</p>
            </div>
        </center>
        <p class="text-center">================================</p>

        <div id="mid">
            <div class="info">
                <p>
                    {{ date('d-m-Y') }} <br>
                    No Faktur: {{ $cPembelian->id_transaksi }}<br>
    
                    Petugas : {{ ucFirst(auth()->user()->nama) }}<br>
                    Supplier : {{ $cPembelian->nama_supplier }}<br>
                </p>
            </div>
        </div>
        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Item</h2>
                        </td>
                        <td class="Hours">
                            <h2 style="text-align:center;">Qty</h2>
                        </td>
                        <td class="Rate">
                            <h2 id="rate">Sub Total</h2>
                        </td>
                    </tr>

                    @foreach ($cDetailPembelian as $item)

                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">
                                    {{ $item->nama_barang }} <br>
                                    @if ($item->diskon != 0)
                                    Diskon {{ $item->diskon }}%
                                    @endif
                                </p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext" style="text-align:center;">{{ $item->qty }}</p>
                            </td>
                            <td class="tableitem">
                                <p id="rate" class="itemtext">Rp. {{ format_uang(($item->qty * $item->harga_beli) - ($item->qty * $item->harga_beli * $item->diskon/100)) }}</p>
                            </td>
                        </tr>

                    @endforeach

                    <tr class="tabletitle">
                        <td class="Rate">
                            <h2 style="text-align:center;">Total  </h2>
                        </td>
                        <td>
                            <h2>:</h2>
                        </td>
                        <td class="payment">
                            <h2 id="rate">Rp. {{ format_uang($cPembelian->total_pembelian) }}</h2>
                        </td>
                    </tr>
                    @if ($cPembelian->jenis_pembayaran == 1)
                        <tr class="tabletitle">
                            <td class="Rate">
                                <h2 style="text-align:center;">Total Bayar  </h2>
                            </td>
                            <td>
                                <h2>:</h2>
                            </td>
                            <td class="payment">
                                <h2 id="rate">Rp. {{ format_uang($cPembelian->bayar) }}</h2>
                            </td>
                        </tr>
                        <tr class="tabletitle">
                            <td class="Rate">
                                <h2 style="text-align:center;">Kembalian  </h2>
                            </td>
                            <td>
                                <h2>:</h2>
                            </td>
                            <td class="payment">
                                <h2 id="rate">Rp. {{ format_uang($cPembelian->bayar - $cPembelian->total_pembelian) }}</h2>
                            </td>
                        </tr>
                    @elseif ($cPembelian->jenis_pembayaran == 2)
                        <tr class="tabletitle">
                            <td class="Rate">
                                <h2 style="text-align:center;">DP  </h2>
                            </td>
                            <td>
                                <h2>:</h2>
                            </td>
                            <td class="payment">
                                <h2 id="rate">Rp. {{ format_uang($cPembelian->dp) }}</h2>
                            </td>
                        </tr>
                        <tr class="tabletitle">
                            <td class="Rate">
                                <h2 style="text-align:center;">Sisa  </h2>
                            </td>
                            <td>
                                <h2>:</h2>
                            </td>
                            <td class="payment">
                                <h2 id="rate">Rp. {{ format_uang($cPembelian->total_pembelian - $cPembelian->dp) }}</h2>
                            </td>
                        </tr>   
                    @else
                        <tr class="tabletitle">
                            <td class="Rate">
                                <h2 style="text-align:center;">Transfer  </h2>
                            </td>
                            <td>
                                <h2>:</h2>
                            </td>
                            <td class="payment">
                                <h2 id="rate">Rp. {{ format_uang($cPembelian->total_pembelian) }}</h2>
                            </td>
                        </tr>   
                    @endif
                </table>
            </div>
            <!--End Table-->
            <p class="text-center">---------------------------------------------------</p>
            <div id="legalcopy">
                <p class="legal"><strong>Terimakasih Telah Berbelanja!</strong> 
                </p>
                <p class="slogan">{{ $cPerusahaan->slogan }}</p>
            </div>

        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script>
    $(window).on("load", function () {
        document.body.style.zoom = "200%" 
        window.print();  
    });
</script>
</html> --}}