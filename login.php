<?php
include 'config.php';


// =====================================================
// ===================== BACKEND =======================
// =====================================================

// CLASS LOGIN
class Login {

    private $nama;

    public function __construct($nama){
        $this->nama = $nama;
    }

    // proses login
    public function masuk($username, $password){

        // amankan input
        $username = $this->nama->real_escape_string($username);
        $password = $this->nama->real_escape_string($password);

        // query login
        $query = "
            SELECT * FROM user
            WHERE username='$username'
            AND password='$password'
        ";

        $result = $this->nama->query($query);

        if($result->num_rows > 0){

            $user = $result->fetch_assoc();

            $_SESSION['login'] = true;
            $_SESSION['role']  = $user['role'];

            // redirect role
            if($user['role'] == 'guru'){
                header("Location: index.php");
            } else {
                header("Location: laporan.php");
            }

            exit;

        } else {
            return "Username atau password salah!";
        }
    }
}


// menjalankan class login
$login = new Login($nama);

$error = "";

// proses form login
if(isset($_POST['login'])){
    $error = $login->masuk($_POST['user'], $_POST['pass']);
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

<title>Login - Sistem Kehadiran</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

/* ===================== RESET ===================== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* ===================== BODY ===================== */
body{
    font-family:'Poppins',sans-serif;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#eef2f7;
    padding:20px;
}

/* ===================== CARD ===================== */
.card{
    width:100%;
    max-width:750px;
    display:flex;
    overflow:hidden;
    border-radius:16px;
    box-shadow:0 15px 40px rgba(0,0,0,0.12);
}

/* ===================== LEFT ===================== */
.sisi-kiri{
    flex:1;
    background:linear-gradient(160deg,#0C447C,#378ADD);
    padding:48px 36px;
    color:white;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.logo-teks{
    font-size:18px;
    font-weight:600;
}

.info-judul{
    font-size:24px;
    margin-bottom:12px;
}

.info-deskripsi{
    font-size:13px;
    line-height:1.7;
    color:rgba(255,255,255,0.8);
}

.versi{
    font-size:11px;
    color:rgba(255,255,255,0.4);
}

/* ===================== RIGHT ===================== */
.sisi-kanan{
    width:320px;
    background:white;
    padding:48px 32px;
}

.form-judul{
    font-size:22px;
    margin-bottom:4px;
}

.form-subjudul{
    font-size:13px;
    color:#999;
    margin-bottom:24px;
}

/* ===================== ERROR ===================== */
.pesan-error{
    background:#fcebeb;
    color:#a32d2d;
    border:1px solid #f09595;
    padding:10px;
    border-radius:8px;
    margin-bottom:16px;
    font-size:12px;
}

/* ===================== FORM ===================== */
.form-grup{
    margin-bottom:16px;
}

.form-grup label{
    font-size:11px;
    color:#888;
    display:block;
    margin-bottom:5px;
}

.form-grup input{
    width:100%;
    height:42px;
    border:1px solid #ddd;
    border-radius:8px;
    padding:0 14px;
    background:#f8f9fa;
    font-family:'Poppins';
}

.form-grup input:focus{
    outline:none;
    border-color:#378ADD;
    background:white;
}

/* ===================== BUTTON ===================== */
.tombol-login{
    width:100%;
    height:44px;
    border:none;
    border-radius:8px;
    background:#185FA5;
    color:white;
    font-family:'Poppins';
    cursor:pointer;
    margin-top:10px;
    transition:0.2s;
}

.tombol-login:hover{
    background:#0C447C;
}

</style>
</head>

<body>

<div class="card">

    <!-- LEFT SIDE -->
    <div class="sisi-kiri">

        <div class="logo-teks">
            Sistem Kehadiran
        </div>

        <div>
            <h2 class="info-judul">
                Kelola kehadiran siswa dengan mudah
            </h2>

            <p class="info-deskripsi">
                Platform digital untuk guru dan staf sekolah
                dalam mencatat dan memantau kehadiran siswa.
            </p>
        </div>

        <div class="versi">
            SMK NEGERI 1 JAKARTA
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="sisi-kanan">

        <h3 class="form-judul">Selamat datang</h3>

        <p class="form-subjudul">
            Masuk untuk melanjutkan ke sistem
        </p>

        <!-- ERROR -->
        <?php if(!empty($error)): ?>
            <div class="pesan-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form method="POST">

            <div class="form-grup">
                <label>Username</label>
                <input type="text" name="user" placeholder="Masukkan username" required>
            </div>

            <div class="form-grup">
                <label>Password</label>
                <input type="password" name="pass" placeholder="Masukkan password" required>
            </div>

            <button class="tombol-login" name="login">
                Masuk
            </button>

        </form>

    </div>

</div>

</body>
</html>