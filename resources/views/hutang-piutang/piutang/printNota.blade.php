<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Nota Piutang</title>
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
            size: A5;
            margin: 0;
        }

        @media print {
            html, body {
                width: 85mm;
                /* height: 100%; */
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
        <p>{{ $cPiutang->tgl_bayar }}</p>
        <p>No Faktur: {{$cPiutang->no_faktur}}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>Pelanggan: {{ $cPiutang->nama_pelanggan }}</p>
    <p>Admin: {{ auth()->user()->nama }}</p>
    <p class="text-center">===================================</p>
    
    <br>
    <table width="100%" class="bordered">
        <thead>
            <tr class="text-center">
                <td>Nama Barang</td>
                <td>Jumlah</td>
                <td>Harga</td>
                <td>Sub Total</td>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($cDetailPiutang as $item)
                <tr>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp. {{ format_uang($item->harga_jual) }}</td> 
                    <td class="text-right">Rp. {{ format_uang($item->qty * $item->harga_jual) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td class="text-right" colspan="8">Total : Rp. {{ format_uang($cPiutang->total_harga) }}</td>
        </tr>
        <tr>
            <td class="text-right" colspan="8">DP : Rp. {{ format_uang($cPiutang->dp) }}</td>
        </tr>
        <tr>
            <td class="text-right" colspan="8">Bayar : Rp. {{ format_uang($cPiutang->total_bayar) }}</td>
        </tr>
        <tr>
            <td class="text-right" colspan="8">Sisa : Rp. {{ format_uang($cPiutang->sisa) }}</td>
        </tr>
        <tr class="spaceUnder2">
            <td class="text-right" colspan="8">Status : <strong>LUNAS</strong></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td class="text-left" colspan="4">Hormat Kami</td>
            <td class="text-right" colspan="4">Pelanggan</td>
        </tr>
        <tr class="spaceUnder5">
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="4" class="text-left">{{ auth()->user()->nama }}</td>
            <td colspan="4" class="text-right">{{ $cPiutang->nama_pelanggan }}</td>
        </tr>
    </table>
    {{-- <script>
        let body = document.body;
        let html = document.documentElement;
    </script> --}}
</body>
</html>