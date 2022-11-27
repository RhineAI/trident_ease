<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan KAS</title>
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
        {{ $noKasMasuk = 1 }}
        {{ $noKasKeluar = 1 }}
    </small>
    <h2 class="text-center">{{ $cPerusahaan->nama }}</h2>
    <h3 class="text-center">Laporan KAS</h3>
    <h5 class="text-center mb-4">
        Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h5>

    <div class="col-md-12">
        <div class="table-responsive p-2">
            <h5 class="mb-2 mt-5">Kas Masuk</h5>
            <table border="1" class="table mb-5 table-bordered  table-kas-masuk" id="dataTableHover">
                {{-- <thead class="table-secondary">
                    <tr>
                        <th width="6%" class="text-center">No</th>
                        <th width="11.1%" class="text-center">Tanggal</th>
                        <th width="18%" class="text-center">Keterangan</th>
                        <th width="10.2%" class="text-center">Oleh</th>
                        <th width="13%" class="text-center">Jumlah</th>
                    </tr>
                </thead> --}}
                <tbody>
                    {{-- <tr> --}}
                        <th width="6%" class="text-center">No</th>
                        <th width="11.1%" class="text-center">Tanggal</th>
                        <th width="18%" class="text-center">Keterangan</th>
                        <th width="10.2%" class="text-center">Oleh</th>
                        <th width="13%" class="text-center">Jumlah</th>
                    {{-- </tr> --}}
                    @if ($kasMasuk != NULL)
                        @foreach ($kasMasuk as $item)
                            <tr>
                                <tr>
                                    <td class="text-center">{{ $noKasMasuk++ }}</td>
                                    <td class="text-center">{{ tanggal_indonesia($item->tgl, false) }}</td>
                                    <td class="text-center">{{ $item->keterangan }}</td>
                                    <td class="text-center">{{ ucfirst($item->nama_user) }}</td>
                                    <td class="text-center">{{ 'RP. '. format_uang($item->jumlah) }}</td>
                                </tr>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas yang keluar</td>    
                        </tr> 
                    @endif
                    <tr>
                        <td class="text-center" colspan="4"><b>Total</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalKasMasuk) }}</td>
                    </tr>
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td class="text-center" colspan="4"><b>Total</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalKasMasuk) }}</td>
                    </tr>
                </tfoot> --}}
            </table>

            <h5 class="mt-5 mb-2">Kas Keluar</h5>
            <table border="1" class="table mb-5 table-bordered  table-kas-keluar" id="dataTableHover">
                {{-- <thead class="table-secondary">
                    <tr>
                        <th width="6%" class="text-center">No</th>
                        <th width="11.1%" class="text-center">Tanggal</th>
                        <th width="18%" class="text-center">Keperluan</th>
                        <th width="10.2%" class="text-center">Oleh</th>
                        <th width="13%" class="text-center">Jumlah</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="6%" class="text-center">No</th>
                    <th width="11.1%" class="text-center">Tanggal</th>
                    <th width="18%" class="text-center">Keperluan</th>
                    <th width="10.2%" class="text-center">Oleh</th>
                    <th width="13%" class="text-center">Jumlah</th>
                    @if ($kasKeluar != NULL)
                        @foreach ($kasKeluar as $item)
                            <tr>
                                <tr>
                                    <td width="6%" class="text-center">{{ $noKasKeluar++ }}</td>
                                    <td width="11.1%" class="text-center">{{ tanggal_indonesia($item->tgl, false) }}</td>
                                    <td width="18%" class="text-center">{{ $item->keperluan }}</td>
                                    <td width="10.2%" class="text-center">{{ ucfirst($item->nama_user) }}</td>
                                    <td width="13%" class="text-center">{{ 'RP. '. format_uang($item->jumlah) }}</td>
                                </tr>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas yang keluar</td>    
                        </tr> 
                    @endif
                    <tr>
                        <td class="text-center" colspan="4"><b>Total</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalKasKeluar) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>