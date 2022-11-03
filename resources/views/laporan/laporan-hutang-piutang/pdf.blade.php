<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Hutang Piutang</title>
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
    <h2 class="text-center">Laporan Hutang Piutang</h2>
    <h3 class="text-center mb-4">
        <div class="convert-tgl" style="visibility: hidden">
            {{ $awals = date('Y-m-d', strtotime("-2day", strtotime($awal))); }}
        </div>
        Tanggal {{ tanggal_indonesia($awals, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h3>

    <div class="col-md-12">
        <div class="table-responsive p-2">
            <h5 class="mb-2 mt-5">Hutang</h5>
            <table border="1" class="table mb-5 table-bordered table-striped table-hutang" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="3.8%" class="text-center">No</th>
                        <th width="10.5%" class="text-center">Kode Pembelian</th>
                        <th width="10%" class="text-center">Tanggal</th>
                        <th width="16%" class="text-center">Nama Supplier</th>
                        <th width="12%" class="text-center">Total Bayar</th>
                        <th width="7%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $no = 1 }}
                    @foreach ($hutang as $h)
                        <tr>
                            {{-- <td class="text-center">{{ $no++ }}</td> --}}
                            @foreach ($h as $item)
                                <td class="text-center">{{ $item }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <h5 class="mt-5 mb-2">Piutang</h5>
            <table border="1" class="table mb-5 table-bordered table-striped table-piutang" id="dataTableHover">
                <thead>
                    <tr>
                        <th width="3.8%" class="text-center">No</th>
                        <th width="10.5%" class="text-center">Kode Penjualan</th>
                        <th width="8%" class="text-center">Tanggal</th>
                        <th width="16%" class="text-center">Nama Pelanggan</th>
                        <th width="13%" class="text-center">Total Bayar</th>
                        <th width="9%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $no = 1 }}
                    @foreach ($piutang as $p)
                        <tr>
                            {{-- <td class="text-center">{{ $no++ }}</td> --}}
                            @foreach ($p as $item)   
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

