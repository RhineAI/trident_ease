<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Harian</title>
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
        {{ $noPenjualan = 1 }}
        {{ $noPembelian = 1 }}
        {{ $noReturPenjualan = 1 }}
        {{ $noReturPembelian = 1 }}
        {{ $noHutang = 1 }}
        {{ $noPiutang = 1 }}
        {{ $noKasMasuk = 1 }}
        {{ $noKasKeluar= 1 }}
    </small>
    <h1 class="text-center">{{ $cPerusahaan->nama }}</h1>
    <h2 class="text-center">Laporan Harian</h2>
    <h3 class="text-center mb-4">
        Tanggal {{ tanggal_indonesia($tglAwal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h3>

    <div class="col-md-12 mt-3">
        <div class="table-responsive p-2">
            <h5 class="mb-2 mt-5">Penjualan Barang</h5>
            <table class="table mb-5 table-bordered table-striped table-penjualan" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="15%" class="text-center">Tanggal</th>
                        <th width="9%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="14%" class="text-center">Omset</th>
                        <th width="11%" class="text-center">Keuntungan</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($penjualan != NULL)
                        @foreach ($penjualan as $pb)
                            <tr>
                                <td class="text-center">{{ $noPenjualan++ }}</td>
                                @foreach ($pb as $item)
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center" style="color:grey; font-size:17px;">Tidak ada data penjualan</td>    
                        </tr>     
                    @endif   
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Pembelian Barang</h5>
            <table class="table mb-5 table-bordered table-striped table-pembelian" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="8%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="17%" class="text-center">Total Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($pembelian != NULL)
                        @foreach ($pembelian as $pb)
                            <tr>
                                <td class="text-center">{{ $noPembelian++ }}</td>
                                @foreach($pb as $item) {
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data pembelian</td>    
                        </tr>     
                    @endif        
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Retur Penjualan</h5>
            <table class="table mb-5 table-bordered table-striped table-retur-penjualan" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="10.5%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="13%" class="text-center">Total Retur</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($returPenjualan != NULL)
                        @foreach ($returPenjualan as $rp)
                            <tr>
                                <td class="text-center">{{ $noReturPenjualan++ }}</td>
                                @foreach ($rp as $item)
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data retur penjualan</td>    
                        </tr>     
                    @endif
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Retur Pembelian</h5>
            <table class="table mb-5 table-bordered table-striped table-retur-pembelian" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="10.5%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="13%" class="text-center">Total Retur</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($returPembelian != NULL)
                        @foreach ($returPembelian as $rp)
                            <tr>
                                <td class="text-center">{{ $noReturPembelian++ }}</td>
                                @foreach ($rp as $item)
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data retur pembelian</td>    
                        </tr>    
                    @endif         
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Hutang</h5>
            <table class="table mb-5 table-bordered table-striped table-hutang" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="6%" class="text-center">Invoice</th>
                        <th width="11%" class="text-center">Tanggal</th>
                        <th width="16%" class="text-center">Nama Supplier</th>
                        <th width="14.5%" class="text-center">Total Bayar</th>
                        <th width="9%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($hutang != NULL)
                        @foreach ($hutang as $h)
                            <tr>
                                <td class="text-center">{{ $noHutang++ }}</td>
                                @foreach ($h as $item)
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center" style="color:grey; font-size:17px;">Tidak ada data hutang</td>    
                        </tr>    
                    @endif
                  
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Piutang</h5>
            <table class="table mb-5 table-bordered table-striped table-piutang" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="6%" class="text-center">Invoice</th>
                        <th width="11%" class="text-center">Tanggal</th>
                        <th width="14%" class="text-center">Nama Pelanggan</th>
                        <th width="14.5%" class="text-center">Total Bayar</th>
                        <th width="9%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($piutang != NULL)
                        @foreach ($piutang as $p)
                            <tr>
                                <td class="text-center">{{ $noPiutang++ }}</td>
                                @foreach ($p as $item)
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center" style="color:grey; font-size:17px;">Tidak ada data piutang</td>    
                        </tr>    
                    @endif
                  
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Kas Masuk</h5>
            <table class="table mb-5 table-bordered table-striped table-kas-masuk" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="13%" class="text-center">Tanggal</th>
                        <th width="14%" class="text-center">Jumlah</th>
                        <th width="14%" class="text-center">Keterangan</th>
                        <th width="14%" class="text-center">Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($kasMasuk != NULL)
                        @foreach ($kasMasuk as $km)
                            <tr>
                                <td class="text-center">{{ $noKasMasuk++ }}</td>
                                @foreach ($km as $item)
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas masuk</td>    
                        </tr>    
                    @endif
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Kas Keluar</h5>
            <table class="table mb-5 table-bordered table-striped table-kas-keluar" id="dataTableHover">
                <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="13%" class="text-center">Tanggal</th>
                        <th width="14%" class="text-center">Jumlah</th>
                        <th width="14%" class="text-center">Keperluan</th>
                        <th width="14%" class="text-center">Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($kasKeluar != NULL) 
                        @foreach ($kasKeluar as $kk)
                            <tr>
                                <td class="text-center">{{ $noKasKeluar++ }}</td>
                                @foreach ($kk as $item)
                                    <td class="text-center" style="vertical-align:center;">{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas keluar</td>    
                        </tr>    
                    @endif  
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>

