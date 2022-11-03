<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Stok</title>
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
    <h3 class="text-center">Laporan Stok</h3>
    <h5 class="text-center mb-4">
        Untuk merk {{ $merk->nama }}
        dan kategori {{ $category->nama }}
     </h5>

    {{-- <h4 class="mb-2 mt-5">Stok</h4> --}}
    <div class="col-md-12">
        <div class="table-responsive p-2">
            <table border="1" class="table mb-5 table-bordered table-striped table-stok" id="dataTableHover">
                <thead >
                    <tr class="">
                        <th width="4.2%" class="text-center" style="margin:auto; text-align:center;">No</th>
                        <th width="7.35%" class="text-center" style="margin:auto; text-align:center;">Kode</th>
                        <th width="15.4%" class="text-center" style="margin:auto; text-align:center;">Nama Barang</th>
                        <th width="8%" class="text-center" style="margin:auto; text-align:center;">Merek</th>
                        <th width="12%" class="text-center" style="margin:auto; text-align:center;">Kategori</th>
                        <th width="4.5%" class="text-center">Stock Minimal</th>
                        <th width="4.5%" class="text-center">Stock Sekarang</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($stok != NULL)
                        @foreach ($stok as $s)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                @foreach ($s as $item)
                                    <td class="text-center">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center" style="color:grey; font-size:17px;">Tidak ada data</td>    
                        </tr>  
                    @endif          
                </tbody>
            </table>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>