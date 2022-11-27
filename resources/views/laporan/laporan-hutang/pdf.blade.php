<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Hutang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
    </style>
  </head>
  <body>
    <small class="convert-tgl" style="visibility: hidden">
        {{ $no = 1 }}
    </small>
    <h2 class="text-center">{{ $cPerusahaan->nama }}</h2>
    <h3 class="text-center">Laporan Hutang</h3>
    <h5 class="text-center mb-4">
        Tanggal {{ tanggal_indonesia($tglAwal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h5>

    <div class="col-md-12 mt-3">
        <div class="table-responsive p-2">
            {{-- <h5 class="mb-2 mt-5">Hutang</h5> --}}
            <table border="1" class="table mb-5 table-bordered table-hutang" id="dataTableHover">
                {{-- <thead class="table-dark">
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="10.5%" class="text-center">Kode Pembelian</th>
                        <th width="8%" class="text-center">Tanggal</th>
                        <th width="16%" class="text-center">Nama Supplier</th>
                        <th width="9%" class="text-center">Status</th>
                        <th width="13%" class="text-center">Dibayar</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="10.5%" class="text-center">Kode Pembelian</th>
                    <th width="9%" class="text-center">Tanggal</th>
                    <th width="16%" class="text-center">Nama Supplier</th>
                    <th width="9%" class="text-center">Status</th>
                    <th width="13%" class="text-center">Dibayar</th>
                    <span style="visibility: hidden">{{ $no = 1 }}</span>
                    @if ($hutang != NULL)
                        @foreach ($hutang as $item)
                            <tr>
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $item->kode_invoice }}</td>
                                    <td class="text-center">{{ tanggal_indonesia($item->tgl, false) }}</td>
                                    <td class="text-center">{{ $item->nama_supplier }}</td>
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
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalHutang) }}</td>
                    </tr>
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td class="text-center" colspan="5"><b>Total Terbayarkan</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalHutang) }}</td>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>

