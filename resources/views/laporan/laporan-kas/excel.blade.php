<table>
    <thead>
        <th>No</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Oleh</th>
        <th>Jumlah</th>
    </thead>
    <tbody>
        @foreach ($kasMasuk as $item)
            <tr>
                <td>{{ $noKasMasuk++ }}</td>
                <td>{{ ($item->tgl) }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ ($item->nama_user) }}</td>
                <td>{{ 'RP. '. ($item->jumlah) }}</td>
            </tr>
        @endforeach
        <tr>
            <td><b>Total</b></td>
            <td>{{ 'Rp. '. ($totalKasMasuk) }}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <th>No</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Oleh</th>
        <th>Jumlah</th>
    </thead>
    <tbody>
        @foreach ($kasKeluar as $item)
            <tr>
                <td>{{ $noKasKeluar++ }}</td>
                <td>{{ ($item->tgl) }}</td>
                <td>{{ $item->keperluan }}</td>
                <td>{{ ($item->nama_user) }}</td>
                <td>{{ 'RP. '. ($item->jumlah) }}</td>
            </tr>
        @endforeach
s        <tr>
            <td><b>Total</b></td>
            <td>{{ 'Rp. '. ($totalKasKeluar) }}</td>
        </tr>
    </tbody>
</table>
