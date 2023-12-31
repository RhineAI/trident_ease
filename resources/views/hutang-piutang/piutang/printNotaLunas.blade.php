<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Nota Piutang</title>
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
            text-align: right;
        }

        @page {
            /* size: 7in 10.5in ; */
            /* scale: 200; */
            margin: 87px;
            
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
    {{-- <button class="btn-print" id="btn-print" style="position: absolute; right: 0px; top: 0px; padding: 2px; width: 100px; background: #4195D5; border-radius: 15px; color: white; border-color: blue; cursor: pointer;" onclick="window.print()">Print</button> --}}
    <div class="button ml-4 align-items-end">
        <a href="{{ route('admin.data-piutang.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none btn-print" id="btn-back"><i class="fas fa-arrow-rotate-left"></i> Back</a>
        <button onclick="window.print()" class="mb-3 mt-3 btn btn-sm btn-danger ml-4 d-print-none btn-print" id="btn-print"><i class="fa-solid fa-print"></i> Print PDF</button>
    </div>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($cPerusahaan->nama) }}</h3>
        <p>{{ strtoupper($cPerusahaan->alamat) }}</p>
    </div>
    <br>
    <div>
        <p>Tgl Bayar : {{ $cPiutang->tgl_bayar }}</p>
        <p>No Faktur: {{$cPiutang->no_faktur}}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>Supplier: {{ $cPiutang->nama_supplier }}</p>
    <p>Admin: {{ auth()->user()->nama }}</p>
    <p class="text-center">===================================</p>
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($cDetailPiutang as $item)
            <small style="visibility: hidden; display: none;">{{ $totalDiskon = 0 }}</small>
            <small style="visibility: hidden; display: none;">{{ $totalDiskon+= $item->qty * $item->harga_jual * $item->diskon/100 }}</small>
            <tr>
                <td colspan="3">{{ $item->nama_barang }}</td>
            </tr>
            <tr>
              	<td>{{ $item->qty }} x Rp. {{ format_uang($item->harga_jual) }}</td>
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
            </tr>
        @endforeach
    </table>

    <p class="text-center">-------------------------------</p>

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
            <td class="text-center" colspan="8" style="font-size: 19px;">Lunas</td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
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