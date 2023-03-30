# CRUD

---

- [Barang](#barang)
- [Barang Konsinyasi](#barang-konsinyasi)
- [Form Barang](#form-barang)
- [Menyimpan Barang ke Database](#simpan-barang)

<larecipe-badge type="primary" circle icon="fa fa-user"></larecipe-badge>
<larecipe-badge type="success" rounded>Luhung Lugina</larecipe-badge>
<a name="barang"></a>
## Halaman Index Barang Utama
`Cuplikan Halaman Index Barang Utama`

![image](/docs/images/barang.png)

Tampilan utama halaman produk utama, disini user dapat menambahkan data, mengubah data, menghapus data, import data dari excel, export ke excel



<a name="barang-konsinyasi"></a>
## Halaman Index Barang Konsinyasi
`Cuplikan Halaman Index Barang Konsinyasi`

![image](/docs/images/barang-konsinyasi.png)

Tampilan utama halaman produk konsinyasi, disini user juga dapat menambahkan data, mengubah data, menghapus data, import data dari excel, export ke excel


<a name="form-barang"></a>
##Halaman Form Input Barang
`Tampilan Form`

![image](/docs/images/form-barang.png)

Sebelum dilanjutkan menyimpan ke database, aplikasi akan mengecek terlebih dahulu apakah ada inputan yang masih kosong apa tidak.

`Pengecekan`

Berikut sintak dari pengecekan menggunakan `Javascript` untuk mengecek inputan yang kosong

![image](/docs/images/check-input-barang.png)

<a name="simpan-barang"></a>
## Menyimpan Barang ke Database

Apabila semua pengecekan lolos, maka akan dilanjut untuk menyimpan ke database, berikut sintak pada fungsi `store()` di controller

![image](/docs/images/store-barang-1.png)

Kemudian akan dicek lagi untuk level sewa dari perusahaan

![image](/docs/images/store-barang-2.png)

