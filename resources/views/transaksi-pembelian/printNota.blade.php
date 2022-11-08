<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Nota Pembelian</title>
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
            text-align: right;
        }

        @page {
            /* size: 7in 10.5in ; */
            scale: 200;
            margin: 87px;
            
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
    <button class="btn-print" id="btn-print" style="position: absolute; right: 0px; top: 0px; padding: 2px; width: 100px; background: #4195D5; border-radius: 15px; color: white; border-color: blue; cursor: pointer;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($cPerusahaan->nama) }}</h3>
        <p>{{ strtoupper($cPerusahaan->alamat) }}</p>
    </div>
    <br>
    <div>
        <p>{{ date('d-m-Y') }}</p>
        <p>Admin: {{ strtoupper(auth()->user()->nama) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>No Faktur: {{ $cPembelian->kode_invoice }}</p>
    <p>Supplier: {{ $cPembelian->nama_supplier }}</p>
    <p class="text-center">===================================</p>
    
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($cDetailPembelian as $item)
            <tr>
                <td colspan="3">{{ $item->nama_barang }}</td>
            </tr>
            <tr>
                <td>{{ $item->qty }} x Rp. {{ format_uang($item->harga_beli) }}</td>
                <td></td>
                <td class="text-right">Rp. {{ format_uang($item->qty * $item->harga_beli) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">Rp. {{ format_uang($cPembelian->total_pembelian) }}</td>
        </tr>
        @if ($cPembelian->jenis_pembayaran == 1)
            <tr>
                <td>Total Bayar:</td>
                <td class="text-right">Rp. {{ format_uang($cPembelian->bayar) }}</td>
            </tr>
            <tr>
                <td>Kembalian:</td>
                <td class="text-right">Rp. {{ format_uang($cPembelian->bayar - $cPembelian->total_pembelian ) }}</td>
            </tr>
        @elseif($cPembelian->jenis_pembayaran == 2) 
            <tr>
                <td>DP:</td>
                <td class="text-right">Rp. {{ format_uang($cPembelian->dp) }}</td>
            </tr>
            <tr>
                <td>Sisa:</td>
                <td class="text-right">Rp. {{ format_uang($cPembelian->total_pembelian - $cPembelian->dp) }}</td>
            </tr>
        @else 
            <tr>
                <td>Total Transfer:</td>
                <td class="text-right">Rp. {{ format_uang($cPembelian->total_pembelian) }}</td>
            </tr>
        @endif
        
    </table>

    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

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