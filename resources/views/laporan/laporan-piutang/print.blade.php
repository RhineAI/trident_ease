<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Piutang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        tr {
            border-top: 1.325px solid black;
            border-bottom: 1.325px solid black;
        }

        td, th {
            border: 1.325px solid black;
            border-bottom: 1.325px solid black;
            text-align: left;
            padding: 8px;
        }

        .button {
            /* text-align-last: right; */
            /* align-content: flex-end; */
            /* align-items: flex-end; */
            margin-left: 20px;
        }
        @page {
            size: A4;
            margin: 0;
            }
        @media print {
            html, body {
                width: 210mm;
                padding-right:9.5mm;
                padding-left:6.5mm;
                padding-top:5.7mm;
                padding-bottom:5.7mm;
                height: 297mm;
            }
            /* ... the rest of the rules ... */
        }
    </style>

<?php
    $style = '
    <style>
        * {
            font-family: "Gill Sans MT", cursive;
        }
        p {
            display: block;
            margin: 4px;
            font-size: 10pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

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
    <div class="button ml-4 align-items-end">
        @if (auth()->user()->hak_akses == 'admin')
            <a href="{{ route('admin.laporan-piutang.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none"><i class="fas fa-arrow-rotate-left"></i> Back</a>
        @elseif (auth()->user()->hak_akses == 'owner')
            <a href="{{ route('owner.laporan-piutang.index') }}" class="mb-3 mt-3 btn btn-sm btn-secondary ml-4 d-print-none"><i class="fas fa-arrow-rotate-left"></i> Back</a>
        @endif
        <button onclick="window.print()" class="mb-3 mt-3 btn btn-sm btn-danger ml-4 d-print-none"><i class="fa-solid fa-print"></i> Print PDF</button>
    </div>

    <small class="convert-tgl" style="visibility: hidden">
        {{ $no = 1 }}
    </small>
    <h2 class="text-center">{{ $cPerusahaan->nama }}</h2>
    <h3 class="text-center">Laporan Piutang</h3>
    <h5 class="text-center mb-4">
        Tanggal {{ tanggal_indonesia($tglAwal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h5>

    <div class="col-md-12 mt-3">
        <div class="table-responsive p-2">
            <table class="table align-items-center mb-5 table-bordered table-flush table-hover text-center table-responsive dt-responsive table-piutang" id="dataTableHover">
                {{-- <thead class="table-dark">
                    <tr>
                        <th width="4%" class="text-center" style="vertical-align:middle;">No</th>
                        <th width="10.5%" class="text-center" style="vertical-align:middle;">Kode Penjualan</th>
                        <th width="8%" class="text-center" style="vertical-align:middle;">Tanggal</th>
                        <th width="16%" class="text-center" style="vertical-align:middle;">Nama Pelanggan</th>
                        <th width="9%" class="text-center" style="vertical-align:middle;">Status</th>
                        <th width="13%" class="text-center" style="vertical-align:middle;">Total Bayar</th>
                    </tr>
                </thead> --}}
                <tbody>
                    {{-- <tr> --}}
                        <th width="4%" class="text-center" style="vertical-align:middle;">No</th>
                        <th width="10.5%" class="text-center" style="vertical-align:middle;">Kode Penjualan</th>
                        <th width="9%" class="text-center" style="vertical-align:middle;">Tanggal</th>
                        <th width="16%" class="text-center" style="vertical-align:middle;">Nama Pelanggan</th>
                        <th width="9%" class="text-center" style="vertical-align:middle;">Status</th>
                        <th width="13%" class="text-center" style="vertical-align:middle;">Total Bayar</th>
                    {{-- </tr> --}}
                    <span style="visibility: hidden">{{ $no = 1 }}</span>
                    @if ($piutang != NULL)
                        @foreach ($piutang as $item)
                            <tr>
                                <tr>    
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $item->kode_invoice }} </td>
                                    <td class="text-center">{{ tanggal_indonesia($item->tgl, false) }}</td>
                                    <td class="text-center">{{ $item->nama_pelanggan }}</td>
                                    @if ($item->sisa == 0) 
                                        <td class="text-center">Lunas</td>
                                    @else 
                                        <td class="text-center">Belum Lunas</td>
                                    @endif
                                    <td class="text-center">{{ 'Rp. '. format_uang($item->total_bayar) }}</td>
                                </tr>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas yang keluar</td>    
                        </tr> 
                    @endif
                    <tr>
                        <td class="text-center" colspan="5"><b>Total Terbayarkan</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalPiutang) }}</td>
                    </tr>
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td class="text-center" colspan="5"><b>Total Terbayarkan</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalPiutang) }}</td>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
        function remove() {
            var btn =$('.button').html();
            btn.remove();
        }

        $('div.button-print').hide();
    </script>

    </body>
</html>

