<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pembelian</title>
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
    <small class="convert-tgl" style="visibility: hidden;">
        {{ $no = 1 }}
    </small>
    <h2 class="text-center">{{ $cPerusahaan->nama }}</h2>
    <h3 class="text-center">Laporan Pembelian</h3>
    <h5 class="text-center mb-4">
        Tanggal {{ tanggal_indonesia($tglAwal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h5>

    <div class="col-md-12">
        <div class="table-responsive p-2">
            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-Pembelian" id="dataTableHover">
                {{-- <thead class="table-primary">
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="9%" class="text-center">Tanggal</th>
                        <th width="8%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="17%" class="text-center">Total Pembelian</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="9%" class="text-center">Tanggal</th>
                    <th width="8%" class="text-center">Kode</th>
                    <th width="16%" class="text-center">Nama Barang</th>
                    <th width="8%" class="text-center">QTY</th>
                    <th width="17%" class="text-center">Total Pembelian</th>
                    @if ($detPembelian != NULL)
                        @foreach ($detPembelian as $dp)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ tanggal_indonesia($dp->tgl,false) }}</td>
                                <td class="text-center">{{ $dp->kode }}</td>
                                <td class="text-center">{{ $dp->nama_barang }}</td>
                                <td class="text-center">{{ $dp->qty }}</td>
                                {{-- <td class="text-center" id="omset">{{ 'Rp.' . format_uang($dp->qty * $dp->harga_beli) }}</td> --}}
                                @if ($dp->diskon == 0)
                                    <td class="text-center ">{{ 'Rp. ' . format_uang(($dp->harga_beli) * $dp->qty) }}</td>
                                @else 
                                    <td class="text-center" >{{ 'Rp. ' . format_uang((($dp->harga_beli) * $dp->qty) - ( ($dp->harga_beli) * $dp->qty) * $dp->diskon/100) }}</td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center" style="color:grey; font-size:17px;">Tidak ada data</td>    
                        </tr>  
                    @endif
                    <tr>
                        <td class="text-center" colspan="5"><b>Total</b></td>
                        <td id="totalU" class="text-center">{{ 'Rp. '. format_uang($totalBeli) }}</td>
                    </tr>
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td class="text-center" colspan="5"><b>Total</b></td>
                        <td id="totalU" class="text-center">{{ 'Rp. '. format_uang($totalBeli) }}</td>
                    </tr>
                </tfoot> --}}
            </table>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>