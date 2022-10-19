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