
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once 'koneksi.php';

// Pastikan data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Silakan buka form tambah user terlebih dahulu.');
}

// Ambil data dari form
$nis           = trim($_POST['nis'] ?? '');
$nama_lengkap  = trim($_POST['nama_lengkap'] ?? '');
$kelas         = trim($_POST['kelas'] ?? '');
$jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
$username      = trim($_POST['username'] ?? '');
$password      = $_POST['password'] ?? '';
$role          = trim($_POST['role'] ?? '');

// Periksa data akun
if ($username === '' || $password === '' || $role === '') {
    exit('Username, password, dan role wajib diisi.');
}

try {

    // Mulai transaksi database
    mysqli_begin_transaction($koneksi);

    // 1. Simpan akun ke tabel users
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO users
        (username, password, role, created_at)
        VALUES (?, ?, ?, NOW())"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $username,
        $pass_hash,
        $role
    );

    mysqli_stmt_execute($stmt);

    $last_insert_id = mysqli_insert_id($koneksi);

    mysqli_stmt_close($stmt);

    // 2. Simpan profil jika role siswa
    if (strtolower($role) === 'siswa') {

        if (
            $nis === '' ||
            $nama_lengkap === '' ||
            $kelas === '' ||
            $jenis_kelamin === ''
        ) {
            throw new Exception(
                'NIS, nama, kelas, dan jenis kelamin wajib diisi.'
            );
        }

        $stmt2 = mysqli_prepare(
            $koneksi,
            "INSERT INTO siswa
            (nis, nama, kelas, jenis_kelamin, user_id)
            VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt2,
            "ssssi",
            $nis,
            $nama_lengkap,
            $kelas,
            $jenis_kelamin,
            $last_insert_id
        );

        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }

    // 3. Selesaikan transaksi
    mysqli_commit($koneksi);

    // 4. Tampilkan notifikasi dan kembali ke form
    echo "<script>
        alert('Data berhasil ditambahkan!');
        window.location.href = 'form_all.php';
    </script>";
    exit;

} catch (Throwable $e) {

    // Batalkan perubahan jika gagal
    mysqli_rollback($koneksi);

    echo "<h3>Data gagal ditambahkan!</h3>";
    echo "<p>Penyebab: " .
        htmlspecialchars(
            $e->getMessage(),
            ENT_QUOTES,
            'UTF-8'
        ) .
        "</p>";

    echo "<p><a href='javascript:history.back()'>
        Kembali ke form
    </a></p>";
}
?>
