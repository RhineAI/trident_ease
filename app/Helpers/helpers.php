<?php

function format_uang ($angka) {
    return number_format($angka, 0, ',', '.');
}

function GetHargaJual($harga_beli,$keuntungan){    
    $margin=$harga_beli*$keuntungan/100;
    $harga_jual=$harga_beli+$margin;
    if($harga_jual<10000){
    $harga_jual=round($harga_jual,-2);
    }else{
        $harga_jual=round($harga_jual,-3);
    }
    echo $harga_jual;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari  = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'
    );
    $nama_bulan = array(1 =>
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $tahun   = substr($tgl, 0, 4);
    $bulan   = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text    = '';

    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0,0,0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari        = $nama_hari[$urutan_hari];
        $text       .= "$hari, $tanggal $bulan $tahun";
    } else {
        $text       .= "$tanggal $bulan $tahun";
    }
    
    return $text; 
}

function persentasePerbandingan($getDataYesterday, $getDataToday) {
    $checkJumlah = $getDataYesterday - $getDataToday;
        if($checkJumlah < 0) {
            $hasilCheck = $checkJumlah + -($checkJumlah*2);
        } elseif($checkJumlah >= 0) {
            $hasilCheck = $checkJumlah;
        }
        if ($hasilCheck != $getDataYesterday) {
            $cek1 = 100 / $getDataYesterday ;
            $cek2 = $getDataYesterday - $hasilCheck;
            $percentage = round($cek1 * $cek2, 2, PHP_ROUND_HALF_UP) ;
        } elseif($hasilCheck == $getDataYesterday) {
            $percentage = 100;
        } elseif($hasilCheck >= $getDataYesterday) {
            $cek1 = 100 / $getDataYesterday ;
            $cek2 = $getDataYesterday - $hasilCheck;
            $percentage = 100 + round($cek1 * $cek2, 2, PHP_ROUND_HALF_EVEN);
        }

        return $percentage;
}

