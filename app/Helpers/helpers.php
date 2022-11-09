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

function persentasePerbandingan($getDataYesterday, $getDataToday, $countDataNow) {
    $checkJumlah = $getDataYesterday - $getDataToday;
    $now = now();
    if($checkJumlah < 0) {
        $hasilCheck = $checkJumlah + -($checkJumlah*2);
    } elseif($checkJumlah >= 0) {
        $hasilCheck = $checkJumlah;
    }

    if($getDataYesterday == 0) {
        if($countDataNow != 0) {
            $cek = 100 / $countDataNow;
            $percentage = round($hasilCheck * $cek, 2, PHP_ROUND_HALF_UP); 
        } elseif($countDataNow == 0) {
            $percentage = 0;
        }
    }elseif ($hasilCheck != $getDataYesterday) {
        if($getDataYesterday <= $hasilCheck) {
            $cek1 = 100 / $getDataYesterday;
            $cek2 = $getDataToday - $getDataYesterday;
            $cek3 = $cek2 - $getDataYesterday;
            $percentage = round($cek1 * $cek3 , 2, PHP_ROUND_HALF_UP);
        } 
        elseif($getDataYesterday >= $hasilCheck) {
            $cek4 = 100/ $getDataYesterday;
            $percentage = round($cek4 * $hasilCheck, 2, PHP_ROUND_HALF_UP);
            
        } 
    }elseif($hasilCheck == $getDataYesterday) {
        $percentage = 100;   
    } 
    elseif($hasilCheck >= $getDataYesterday) {
        $cek1 = 100 / $getDataYesterday ;
        $cek2 = $getDataYesterday - $hasilCheck;
        $percentage = 100 + round($cek1 * $cek2, 2, PHP_ROUND_HALF_EVEN);
    }
    return $percentage;
}

function persentasePerbandinganSemuaData($getDataToday, $getAllData) {
    if ($getAllData == 0) {
        $times = 100 * $getDataToday;
        if ($times > 1000) {
            $percentage = 1000 . '+';
        } else {
            $percentage = $times;
        }
    } else {
        $difference = $getAllData - $getDataToday;
        $getPercentage = 100 / $getAllData;
        $times = $getPercentage * $difference;
        if ($times > 1000) {
            $percentage = 1000 . '+';
        } else {
            $percentage = $times;
        }
    }
    return $percentage;
}

function persentasePerbandinganHarga($getLatestTotal, $getNowTotal ) {
    if ($getLatestTotal == 0) {
        if($getNowTotal < 100) {
            $percentage = $getNowTotal;
        } elseif ($getNowTotal < 1000) {
            $percentage = $getNowTotal / 10;
        } elseif ($getNowTotal < 10000) {
            $percentage = $getNowTotal / 10;
        } elseif ($getNowTotal < 100000) {
            $percentage = $getNowTotal / 100;
        } elseif ($getNowTotal < 1000000) {
            $percentage = $getNowTotal / 1000;
        } elseif ($getNowTotal < 10000000) {
            $percentage = $getNowTotal / 10000;
        } elseif ($getNowTotal < 100000000) {
            $percentage = $getNowTotal / 100000;
        } elseif ($getNowTotal < 1000000000) {
            $percentage = $getNowTotal / 1000000;
        } elseif ($getNowTotal < 10000000000) {
            $percentage = $getNowTotal / 10000000;
        } elseif ($getNowTotal < 100000000000) {
            $percentage = $getNowTotal / 100000000;
        } elseif ($getNowTotal < 1000000000000) {
            $percentage = $getNowTotal / 1000000000;
        } elseif ($getNowTotal < 10000000000000) {
            $percentage = $getNowTotal / 10000000000;
        } 
    } else {
        $difference = $getNowTotal - $getLatestTotal;
        // JIKA KURANG DARI    $differece = 1000 - 2000 (-1000); 
        // JIKA LEBIH DARI     $differece = 5000 - 1000 (4000); 
        // JIKA DATA LAST 0    $difference = 1000 - 0 (1000);

        if ($difference <= $getLatestTotal) { //-1000
            $makePositive = -1 * $difference; //1000 
            $divide = 100 / $getLatestTotal; //100 / 2000 = 0.05
            $percentage = round($makePositive * $divide, 2, PHP_ROUND_HALF_UP); //1000 * 0.05 = 50
        } elseif ($difference == $getLatestTotal) {
            $percentage = 100;
        } elseif ($difference >= $getLatestTotal) { //4000
            $divide = 100 / $getLatestTotal; //100 / 1000 = 0.1
            $times = round($difference * $divide, 2, PHP_ROUND_HALF_UP); // 4000 * 0.1 = 500
            if ($times > 1000) {
                $percentage = 1000 . '+';
            } else {
                $percentage = $times;
            }
        }
    }
    return $percentage;
}
