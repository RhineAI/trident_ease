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
    <h2 class="text-center">{{ $cPerusahaan->nama }}</h2>
    <h3 class="text-center">Laporan Harian</h3>
    <h5 class="text-center mb-4">
        Tanggal {{ tanggal_indonesia($tglAwal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h5>

    <div class="col-md-12 mt-3">
        <div class="table-responsive p-2">
            <h5 class="mb-2 mt-5">Penjualan Barang</h5>
            <table class="table mb-5 table-bordered table-striped table-penjualan" id="dataTableHover">
                {{-- <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="15%" class="text-center">Tanggal</th>
                        <th width="9%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="14%" class="text-center">Omset</th>
                        <th width="11%" class="text-center">Keuntungan</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="15%" class="text-center">Tanggal</th>
                    <th width="9%" class="text-center">Kode</th>
                    <th width="16%" class="text-center">Nama Barang</th>
                    <th width="8%" class="text-center">QTY</th>
                    <th width="14%" class="text-center">Omset</th>
                    <th width="11%" class="text-center">Keuntungan</th>
                    @if ($penjualan != NULL)
                        @foreach ($penjualan as $p)
                            <tr>
                                <td class="text-center">{{ $noPenjualan++ }}</td>
                                <td class="text-center">{{ tanggal_indonesia($p->tgl,false) }}</td>
                                <td class="text-center">{{ $p->kode }}</td>
                                <td class="text-center">{{ $p->nama_barang }}</td>
                                <td class="text-center">{{ $p->qty }}</td>
                                <td class="text-center" id="omset">{{ 'Rp.' . format_uang($p->qty * $p->harga_jual) }}</td>
                                @if ($p->diskon == 0)
                                    <td class="text-center ">{{ 'Rp. ' . format_uang(($p->harga_jual - $p->harga_beli) * $p->qty) }}</td>
                                @else 
                                    <td class="text-center" >{{ 'Rp. ' . format_uang((($p->harga_jual - $p->harga_beli) * $p->qty) - ( ($p->harga_jual - $p->harga_beli) * $p->qty) * $p->diskon/100) }}</td>
                                @endif
                            </tr>
                        @endforeach 
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data</td>    
                        </tr>  
                    @endif
                    <tr>
                        <td class="text-center" colspan="5"><b>Total Penjualan</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalO) }}</td>
                        <td id="totalU" class="text-center">{{ 'Rp. '. format_uang($totalU) }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Pembelian Barang</h5>
            <table class="table mb-5 table-bordered table-striped table-pembelian" id="dataTableHover">
                {{-- <thead >
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
                    @if ($pembelian != NULL)
                        @foreach ($pembelian as $dp)
                            <tr>
                                <td class="text-center">{{ $noPembelian++ }}</td>
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
                        <td class="text-center" colspan="5"><b>Total Pembelian</b></td>
                        <td id="totalU" class="text-center">{{ 'Rp. '. format_uang($totalBeli) }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Retur Penjualan</h5>
            <table class="table mb-5 table-bordered table-striped table-retur-penjualan" id="dataTableHover">
                {{-- <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="10.5%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="13%" class="text-center">Total Retur</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="10.5%" class="text-center">Kode</th>
                    <th width="16%" class="text-center">Nama Barang</th>
                    <th width="8%" class="text-center">QTY</th>
                    <th width="13%" class="text-center">Total Retur</th>
                    @if ($returPenjualan != NULL)
                        @foreach ($returPenjualan as $rp)
                            <tr>
                                <td class="text-center">{{ $noReturPenjualan++ }}</td>
                                <td class="text-center">{{ $rp->kode }}</td>
                                <td class="text-center">{{ $rp->nama_barang }}</td>
                                <td class="text-center">{{ $rp->qty }}</td>
                                <td class="text-center">{{ 'Rp.' . format_uang($rp->qty * $rp->harga_jual) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center" style="color:grey; font-size:17px;">Tidak ada data</td>    
                        </tr>  
                    @endif
                    <tr>
                        <td class="text-center" colspan="4"><b>Total Retur Penjualan</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalReturPenjualan) }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Retur Pembelian</h5>
            <table class="table mb-5 table-bordered table-striped table-retur-pembelian" id="dataTableHover">
                {{-- <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="10.5%" class="text-center">Kode</th>
                        <th width="16%" class="text-center">Nama Barang</th>
                        <th width="8%" class="text-center">QTY</th>
                        <th width="13%" class="text-center">Total Retur</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="10.5%" class="text-center">Kode</th>
                    <th width="16%" class="text-center">Nama Barang</th>
                    <th width="8%" class="text-center">QTY</th>
                    <th width="13%" class="text-center">Total Retur</th>
                    @if ($returPembelian != NULL)
                        @foreach ($returPembelian as $rp)
                            <tr>
                                <td class="text-center">{{ $noReturPembelian++ }}</td>
                                <td class="text-center">{{ $rp->kode }}</td>
                                <td class="text-center">{{ $rp->nama_barang }}</td>
                                <td class="text-center">{{ $rp->qty }}</td>
                                <td class="text-center">{{ 'Rp.' . format_uang($rp->qty * $rp->harga_beli) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center" style="color:grey; font-size:17px;">Tidak ada data</td>    
                        </tr>  
                    @endif       
                    <tr>
                        <td class="text-center" colspan="4"><b>Total Retur Pembelian</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalReturPembelian) }}</td>
                    </tr> 
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Hutang</h5>
            <table class="table mb-5 table-bordered table-striped table-hutang" id="dataTableHover">
                {{-- <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="6%" class="text-center">Invoice</th>
                        <th width="11%" class="text-center">Tanggal</th>
                        <th width="16%" class="text-center">Nama Supplier</th>
                        <th width="9%" class="text-center">Status</th>
                        <th width="14.5%" class="text-center">Total Bayar</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="6%" class="text-center">Invoice</th>
                    <th width="11%" class="text-center">Tanggal</th>
                    <th width="16%" class="text-center">Nama Supplier</th>
                    <th width="9%" class="text-center">Status</th>
                    <th width="14.5%" class="text-center">Total Bayar</th>
                    @if ($hutang != NULL)
                        @foreach ($hutang as $item)
                            <tr>
                                <tr>
                                    <td class="text-center">{{ $noHutang++ }}</td>
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
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data hutang</td>    
                        </tr> 
                    @endif
                    <tr>
                        <td class="text-center" colspan="5"><b>Total Terbayarkan</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalHutang) }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Piutang</h5>
            <table class="table mb-5 table-bordered table-striped table-piutang" id="dataTableHover">
                {{-- <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="6%" class="text-center">Invoice</th>
                        <th width="11%" class="text-center">Tanggal</th>
                        <th width="14%" class="text-center">Nama Pelanggan</th>
                        <th width="9%" class="text-center">Status</th>
                        <th width="14.5%" class="text-center">Total Bayar</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="6%" class="text-center">Invoice</th>
                    <th width="11%" class="text-center">Tanggal</th>
                    <th width="14%" class="text-center">Nama Pelanggan</th>
                    <th width="9%" class="text-center">Status</th>
                    <th width="14.5%" class="text-center">Total Bayar</th>
                    @if ($piutang != NULL)
                        @foreach ($piutang as $item)
                            <tr>
                                <tr>    
                                    <td class="text-center">{{ $noPiutang++ }}</td>
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
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data piutang</td>    
                        </tr> 
                    @endif
                    <tr>
                        <td class="text-center" colspan="5"><b>Total Terbayarkan</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalPiutang) }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Kas Masuk</h5>
            <table class="table mb-5 table-bordered table-striped table-kas-masuk" id="dataTableHover">
                {{-- <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="13%" class="text-center">Tanggal</th>
                        <th width="14%" class="text-center">Keterangan</th>
                        <th width="14%" class="text-center">Oleh</th>
                        <th width="14%" class="text-center">Jumlah</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="13%" class="text-center">Tanggal</th>
                    <th width="14%" class="text-center">Keterangan</th>
                    <th width="14%" class="text-center">Oleh</th>
                    <th width="14%" class="text-center">Jumlah</th>
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
                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data kas yang masuk</td>    
                        </tr> 
                    @endif
                    <tr>
                        <td class="text-center" colspan="4"><b>Total Kas Masuk</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalKasMasuk) }}</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mb-2 mt-5">Kas Keluar</h5>
            <table class="table mb-5 table-bordered table-striped table-kas-keluar" id="dataTableHover">
                {{-- <thead >
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="13%" class="text-center">Tanggal</th>
                        <th width="14%" class="text-center">Keperluan</th>
                        <th width="14%" class="text-center">Oleh</th>
                        <th width="14%" class="text-center">Jumlah</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <th width="4%" class="text-center">No</th>
                    <th width="13%" class="text-center">Tanggal</th>
                    <th width="14%" class="text-center">Keperluan</th>
                    <th width="14%" class="text-center">Oleh</th>
                    <th width="14%" class="text-center">Jumlah</th>
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
                        <td class="text-center" colspan="4"><b>Total Kas Keluar</b></td>
                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalKasKeluar) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>

