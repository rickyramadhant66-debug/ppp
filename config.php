<?php
session_start();

// koneksi database
$nama = new mysqli(
    "localhost",
    "root",
    "",
    "absensi_db"
);

// cek koneksi
if($nama->connect_error){
    die("Koneksi gagal : " . $nama->connect_error);
}
?>