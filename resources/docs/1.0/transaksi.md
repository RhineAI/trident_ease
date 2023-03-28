# Transaksi

---

- [Halaman Transaksi](#transaksi-penjualan)
- [Form Transaksi](#form-transaksi)
- [Penyimpanan Transaksi](#simpan-transaksi)

<larecipe-badge type="primary" circle icon="fa fa-user"></larecipe-badge>
<larecipe-badge type="success" rounded>Luhung Lugina</larecipe-badge>
<a name="transaksi-penjualan"></a>
## Halaman Transaksi
`Cuplikan Halaman Transaksi`

![image](/docs/images/transaksi.png)

Pada halaman ini user dapat melakukan transaksi barang baik itu penjualan maupun pembelian. Adapun jenis pembayaran yang ada pada penjualan yaitu tunai dan kredit, sementara untuk pembelian jenis pembayarannya yaitu tunai, kredit, dan juga transfer

<a name="form-transaksi"></a>
## Modal Transaksi
`Sintak Modal`

![image](/docs/images/modal-transaksi.png)

`Tampilan Untuk Memilih Barang`

![image](/docs/images/select-barang.png)

Ketika user klik tombol cari atau search pada pilih produk atau pilih pelanggan maka akan membuka modal 
&nbsp;

`Form Pemilihan Barang`

![image](/docs/images/modal-open-transaksi.png)


<a name="simpan-transaksi"></a>
## Menyimpan Transaksi  

Kemudian setelah user menginput pelanggan, barang yang akan dijual pada transaksi, serta pembayaran maka sistem akan menjalankan function `store()` pada controller

`Sintak pada fungsi store() Transaksi`

![image](/docs/images/store-transaksi-1.png)
![image](/docs/images/store-transaksi-2.png)
![image](/docs/images/store-transaksi-3.png)


