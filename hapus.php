<?php
include 'config.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // hapus absensi
    $nama->query("
        DELETE FROM absensi
        WHERE id_siswa='$id'
    ");

    // hapus siswa
    $nama->query("
        DELETE FROM siswa
        WHERE id='$id'
    ");
}

header("Location: index.php");
exit;
?>