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

// cek role
if ($_SESSION['role'] != 'guru') {
    header("Location: laporan.php");
    exit;
}

$mode = $_GET['mode'] ?? 'view';
$tgl  = date("Y-m-d");


// ===================== PROSES SIMPAN ABSENSI =====================
if (isset($_POST['simpan'])) {

    foreach ($_POST['status'] as $id => $status) {

        $ket = $_POST['ket'][$id] ?? '';

        // cek apakah sudah ada data
        $cek = $nama->query("
            SELECT * FROM absensi
            WHERE id_siswa='$id'
            AND tanggal='$tgl'
        ");

        if ($cek->num_rows > 0) {

            // UPDATE data
            $nama->query("
                UPDATE absensi SET
                status='$status',
                keterangan='$ket'
                WHERE id_siswa='$id'
                AND tanggal='$tgl'
            ");

        } else {

            // INSERT data baru
            $nama->query("
                INSERT INTO absensi
                (id_siswa, tanggal, status, keterangan)
                VALUES
                ('$id', '$tgl', '$status', '$ket')
            ");
        }
    }

    header("Location: index.php?success=1");
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
<title>Absensi Siswa</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}

/* ===== JUDUL ===== */
.judul{
    text-align:center;
    margin-bottom:20px;
}

/* ===== ACTION BUTTON ===== */
.action{
    width:90%;
    margin:20px auto;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn{
    background:#4da3ff;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:5px;
    text-decoration:none;
    cursor:pointer;
}

.btn:hover{
    opacity:0.9;
}

.logout{
    background:red;
}

/* ===== TABLE ===== */
table{
    width:90%;
    margin:auto;
    border-collapse:collapse;
    background:white;
}

th,td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

th{
    background:#e9edf3;
}

input[type=text]{
    width:100%;
    padding:7px;
}

.hapus{
    background:red;
    color:white;
    padding:5px 10px;
    border-radius:5px;
    text-decoration:none;
}
</style>
</head>

<body>

<!-- ===================== ALERT ===================== -->
<?php if (isset($_GET['success'])): ?>
<script>
alert("Absensi berhasil disimpan!");
</script>
<?php endif; ?>


<!-- ===================== UI FRONTEND ===================== -->

<div class="judul">
    <h2>ABSENSI SISWA</h2>
    <h4>SMK NEGERI 1 JAKARTA</h4>
</div>

<div class="action">

    <div>
        <?php if ($mode == 'edit'): ?>
            <a href="tambah.php" class="btn">Tambah Siswa</a>
        <?php endif; ?>
    </div>

    <div>
        <a href="logout.php" class="btn logout">Logout</a>
    </div>

</div>

<form method="POST">

<table>

<tr>
    <th>Nama</th>
    <th>NISN</th>
    <th>Hadir</th>
    <th>Sakit</th>
    <th>Izin</th>
    <th>Alpa</th>
    <th>Keterangan</th>

    <?php if ($mode == 'edit'): ?>
        <th>Aksi</th>
    <?php endif; ?>
</tr>

<?php
$data = $nama->query("
    SELECT siswa.*, absensi.status, absensi.keterangan
    FROM siswa
    LEFT JOIN absensi
    ON siswa.id = absensi.id_siswa
    AND absensi.tanggal = '$tgl'
    ORDER BY siswa.id DESC
");

while ($d = $data->fetch_assoc()):
$status = $d['status'];
?>

<tr>
    <td><?= $d['nama'] ?></td>
    <td><?= $d['nisn'] ?></td>

    <td><input type="radio" name="status[<?= $d['id'] ?>]" value="hadir" <?= ($status=='hadir')?'checked':'' ?>></td>
    <td><input type="radio" name="status[<?= $d['id'] ?>]" value="sakit" <?= ($status=='sakit')?'checked':'' ?>></td>
    <td><input type="radio" name="status[<?= $d['id'] ?>]" value="izin" <?= ($status=='izin')?'checked':'' ?>></td>
    <td><input type="radio" name="status[<?= $d['id'] ?>]" value="alpa" <?= ($status=='alpa')?'checked':'' ?>></td>

    <td>
        <input type="text" name="ket[<?= $d['id'] ?>]" value="<?= $d['keterangan'] ?>">
    </td>

    <?php if ($mode == 'edit'): ?>
    <td>
        <a href="hapus.php?id=<?= $d['id'] ?>" class="hapus" onclick="return confirm('Hapus siswa?')">
            Hapus
        </a>
    </td>
    <?php endif; ?>
</tr>

<?php endwhile; ?>

</table>

<div class="action">

<?php if ($mode == 'edit'): ?>

    <a href="index.php" class="btn">Selesai</a>

    <button type="submit" name="simpan" class="btn">Simpan</button>

<?php else: ?>

    <a href="index.php?mode=edit" class="btn">Edit</a>

<?php endif; ?>

</div>

</form>

</body>
</html>