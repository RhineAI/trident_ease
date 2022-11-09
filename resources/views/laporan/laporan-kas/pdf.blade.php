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
            <table border="1" class="table mb-5 table-bordered table-striped table-kas-masuk" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="5%" class="text-center mb-3">No</th>
                        <th width="13%" class="text-center mb-3">Tanggal</th>
                        <th width="14%" class="text-center mb-3">Jumlah</th>
                        <th width="14%" class="text-center mb-3">Keterangan</th>
                        <th width="14%" class="text-center mb-3">Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($kas_masuk != NULL)
                        @foreach ($kas_masuk as $km)
                            <tr>
                                <td class="text-center">{{ $noKasMasuk++ }}</td>
                                @foreach ($km as $item)
                                    <td class="text-center">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas yang masuk </td>    
                        </tr>  
                    @endif  
                </tbody>
            </table>
            
            <h5 class="mt-5 mb-2">Kas Keluar</h5>
            <table border="1" class="table mb-5 table-bordered table-striped table-kas-keluar" id="dataTableHover">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="13%" class="text-center">Tanggal</th>
                        <th width="14%" class="text-center">Jumlah</th>
                        <th width="14%" class="text-center">Keperluan</th>
                        <th width="14%" class="text-center">Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($kas_keluar != NULL)
                        @foreach ($kas_keluar as $kk)
                            <tr>
                                <td class="text-center">{{ $noKasKeluar++ }}</td>
                                @foreach ($kk as $item)   
                                    <td class="text-center">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas yang keluar</td>    
                        </tr> 
                    @endif
                  
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>