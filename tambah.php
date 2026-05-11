<?php
include 'config.php';


// =====================================================
// ===================== BACKEND =======================
// =====================================================

// cek login
if (empty($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}


// ===================== CLASS SISWA =====================
class Siswa {

    private $nama; // koneksi DB

    public function __construct($nama){
        $this->nama = $nama;
    }

    public function tambah($nama, $nisn){

        // amankan input
        $nama = $this->nama->real_escape_string($nama);
        $nisn = $this->nama->real_escape_string($nisn);

        // insert data
        $this->nama->query("
            INSERT INTO siswa (nama, nisn)
            VALUES ('$nama', '$nisn')
        ");
    }
}


// jalankan class
$siswa = new Siswa($nama);


// ===================== PROSES SIMPAN =====================
if (isset($_POST['simpan'])) {

    $siswa->tambah($_POST['nama'], $_POST['nisn']);

    header("Location: index.php");
    exit;
}

?>



<!-- ===================================================== -->
<!-- ===================== FRONTEND ====================== -->
<!-- ===================================================== -->

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Siswa</title>

<style>

/* ================= RESET ================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* ================= BODY ================= */
body{
    font-family:Arial;
    background:#f4f6f9;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* ================= BOX ================= */
.box{
    width:100%;
    max-width:380px;
    background:white;
    padding:30px;
    border-radius:14px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* ================= TITLE ================= */
h2{
    text-align:center;
    margin-bottom:25px;
}

/* ================= INPUT ================= */
.input{
    margin-bottom:15px;
}

.input label{
    display:block;
    margin-bottom:6px;
    font-size:14px;
}

.input input{
    width:100%;
    height:42px;
    padding:0 12px;
    border:1px solid #ccc;
    border-radius:8px;
}

.input input:focus{
    outline:none;
    border-color:#4da3ff;
}

/* ================= BUTTON ================= */
.btn{
    width:100%;
    height:44px;
    background:#4da3ff;
    border:none;
    border-radius:8px;
    color:white;
    cursor:pointer;
}

.btn:hover{
    background:#2f80ed;
}

/* ================= BACK LINK ================= */
.back{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#666;
}

</style>
</head>

<body>

<div class="box">

    <h2>Tambah Siswa</h2>

    <form method="POST">

        <div class="input">
            <label>Nama Siswa</label>
            <input type="text" name="nama" required>
        </div>

        <div class="input">
            <label>NISN</label>
            <input type="text" name="nisn" required>
        </div>

        <button type="submit" name="simpan" class="btn">
            Simpan
        </button>

    </form>

    <a href="index.php" class="back">← Kembali</a>

</div>

</body>
</html>