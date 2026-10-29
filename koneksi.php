<?php

$host = "127.0.0.1"; //localhost, nama nama server yang kita gunakan 
$username = "root"; //username atau akun pengguna
$pass = "root"; //pass pengguna 
//untuk database disusaikan dengan nama database yang kalian akan gunakan
$database = "annisa_sipn";

//perintah untuk menghubungkan database yang kita gunakan dengan projek php kita
$koneksi = mysqli_connect($host, $username, $pass, $database, 3306);

//untuk mengecek apakah koneksi ke database nya berhasil atau gagal
if (!$koneksi) {
  die("koneksi ke database gagal" . mysqli_connect_error());
} else {
//  echo "koneksi ke database berhasil";
}