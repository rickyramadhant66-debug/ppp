<?php
include 'config.php';

// cek login
if(
    empty($_SESSION['login']) ||
    $_SESSION['role'] != 'guru'
){
    header("Location: login.php");
    exit;
}

// =====================================
// CLASS ABSENSI
// =====================================
class Absensi {

    private $nama;

    public function __construct($nama){
        $this->nama = $nama;
    }

    // simpan absensi
    public function simpan($dataStatus, $dataKet){

        $tgl = date("Y-m-d");

        foreach($dataStatus as $id_siswa => $status){

            $ket = $dataKet[$id_siswa];

            // cek data
            $cek = $this->nama->query("
                SELECT *
                FROM absensi
                WHERE id_siswa='$id_siswa'
                AND tanggal='$tgl'
            ");

            // update
            if($cek->num_rows > 0){

                $this->nama->query("
                    UPDATE absensi SET
                    status='$status',
                    keterangan='$ket'
                    WHERE id_siswa='$id_siswa'
                    AND tanggal='$tgl'
                ");

            } else {

                // insert
                $this->nama->query("
                    INSERT INTO absensi
                    (id_siswa,status,keterangan,tanggal)
                    VALUES
                    ('$id_siswa','$status','$ket','$tgl')
                ");
            }
        }
    }
}

// menjalankan class
$absensi = new Absensi($nama);

// simpan data
if(isset($_POST['status'])){

    $absensi->simpan(
        $_POST['status'],
        $_POST['ket']
    );
}

header("Location: index.php?save=success");
exit;
?>