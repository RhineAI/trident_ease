<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Kesesuaian Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1.325px solid black;
            text-align: left;
            padding: 8px;
        }
    </style>
  </head>
  <body>
    <h1 class="text-center">{{ $cPerusahaan->nama }}</h1>
    <h2 class="text-center">Laporan Kesesuaian Stok</h2>
    <h3 class="text-center">
       Untuk merk {{ $merk->nama }}
       dan kategori {{ $category->nama }}
    </h3>
    <h3 class="text-center mb-4">
        Dari Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h3>
    

    {{-- <h4 class="mb-2 mt-5">Kesesuaian Stok</h4> --}}
    <div class="col-md-12">
        <div class="table-responsive p-2">
            <table border="1" class="table mb-5 table-bordered table-striped table-kesesuaian-stok" id="dataTableHover">
                <thead >
                    <tr class="">
                        <th width="3.81%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">No</th>
                        {{-- <th width="15%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">No</th> --}}
                        <th width="7%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Kode</th>
                        <th width="16%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Nama Barang</th>
                        <th width="8.1%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Merek</th>
                        <th width="12.3%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Kategori</th>
                        <th width="5%" class="text-center">Stok Sistem</th>
                        <th width="5%" class="text-center">Stok Baru</th>
                        <th width="5%" class="text-center" style="vertical-align:middle;">Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $no = 1 }}
                    @foreach ($kesesuaian_stok as $ks)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            @foreach ($ks as $item)
                                <td class="text-center">{{ $item }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>