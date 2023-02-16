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
            <a href="{{ route('admin.list-transaksi.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" id="btn-back"><i class="fas fa-arrow-rotate-left"></i> Data Transaksi</a>
            <a href="{{ route('admin.transaksi-penjualan.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" target="_blank" rel="noopener noreferrer"><i class="fas fa-plus"></i> Transaksi Baru</a>
        @elseif (auth()->user()->hak_akses == 'kasir')
            <a href="{{ route('kasir.list-transaksi.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" id="btn-back"><i class="fas fa-arrow-rotate-left"></i> Data Transaksi</a>
            <a href="{{ route('kasir.transaksi-penjualan.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" target="_blank" rel="noopener noreferrer"><i class="fas fa-plus"></i> Transaksi Baru</a>
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
        <p>No Faktur : {{ $cPenjualan->id_transaksi }}</p>
    </div>
    <p>Petugas : {{ strtoupper(auth()->user()->nama) }}</p>
    <p>Pelanggan : {{ $cPenjualan->nama_pelanggan }}</p>
    <p class="text-center">================================</p>
    <small style="visibility: hidden; display: none;">{{ $totalDiskon = 0 }}</small>
    <table width="100%" style="border: 0;">
        @foreach ($cDetailPenjualan as $item)
            <small style="visibility: hidden; display: none;">{{ $totalDiskon+= $item->qty * $item->harga_jual * $item->diskon/100 }}</small>
            <tr>
                <td colspan="3">{{ $item->nama_barang }}</td>
            </tr>
            <tr>
                <td>{{ $item->qty }} x Rp.{{ format_uang($item->harga_jual) }} </td>
                <td></td>
            @if ($item->diskon == 0)
                <td class="text-right"> &nbsp; Rp.{{ format_uang(($item->qty * $item->harga_jual)) }}</td>
            </tr>
            @else 
                <td class="text-right"></td>
            </tr>
            <tr>
                <td>Disc. {{ $item->diskon }}%</td>
                <td></td>
                <td class="text-right"> &nbsp; Rp.{{ format_uang(($item->qty * $item->harga_jual) - $totalDiskon ) }}</td>
            </tr>
            @endif
        @endforeach
    </table>
    <p class="text-center">-------------------------------</p>
  
    <table width="100%" style="border: 0;">
        <tr>
            <td>Total :&nbsp;</td>
            <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPenjualan->total_harga) }}</td>
        </tr>
        @if ($cPenjualan->jenis_pembayaran == 1)
            <tr>
                <td>Bayar :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPenjualan->total_bayar) }}</td>
            </tr>
            <tr>
                <td>Kembalian :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPenjualan->total_bayar - $cPenjualan->total_harga ) }}</td>
            </tr>
        @else
            <tr>
                <td>DP :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPenjualan->dp) }}</td>
            </tr>
            <tr>
                <td>Sisa :&nbsp;</td>
                <td class="text-right" style="text-align: end"> Rp. {{ format_uang($cPenjualan->total_harga - $cPenjualan->dp) }}</td>
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
                {{ $cPenjualan->nama_pelanggan }}
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