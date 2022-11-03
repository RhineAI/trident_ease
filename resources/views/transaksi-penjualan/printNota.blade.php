<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Nota Penjualan</title>

    <?php
    $style = '
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

        @media print {
            @page {
                margin: 0;
                size: 85mm 
    ';
    ?>
    <?php 
    $style .= 
        ! empty($_COOKIE['innerHeight'])
            ? $_COOKIE['innerHeight'] .'mm; }'
            : '}';
    ?>
    <?php
    $style .= '
            html, body {
                width: 80mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    ';
    ?>

    {!! $style !!}
</head>
<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 0px; top: 0px; padding: 2px;" onclick="window.print()">Print</button>
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
    <p>No: {{ $cPenjualan->id_transaksi }}</p>
    <p>Pelanggan: {{ $cPenjualan->nama_pelanggan }}</p>
    <p class="text-center">===================================</p>
    
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($cDetailPenjualan as $item)
            <tr>
                <td colspan="3">{{ $item->nama_barang }}</td>
            </tr>
            <tr>
                <td>{{ $item->qty }} x Rp. {{ format_uang($item->harga_jual) }}</td>
                <td></td>
                <td class="text-right">Rp. {{ format_uang($item->qty * $item->harga_jual) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">Rp. {{ format_uang($cPenjualan->total_harga) }}</td>
        </tr>
        @if ($cPenjualan->jenis_pembayaran == 1)
            <tr>
                <td>Total Bayar:</td>
                <td class="text-right">Rp. {{ format_uang($cPenjualan->total_bayar) }}</td>
            </tr>
            <tr>
                <td>Kembalian:</td>
                <td class="text-right">Rp. {{ format_uang($cPenjualan->total_harga - $cPenjualan->total_bayar) }}</td>
            </tr>
        @else
            <tr>
                <td>DP:</td>
                <td class="text-right">Rp. {{ format_uang($cPenjualan->dp) }}</td>
            </tr>
            <tr>
                <td>Sisa:</td>
                <td class="text-right">Rp. {{ format_uang($cPenjualan->total_harga - $cPenjualan->dp) }}</td>
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