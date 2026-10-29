<?php
require_once 'koneksi.php';

function pesan($teks, $url)
{
    echo "<script>alert(" . json_encode($teks) . "); window.location.href=" . json_encode($url) . ";</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    pesan('Tidak Boleh Langsung Mengakses Halaman Ini!!!', 'daftar_user.php');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// update tabel users (password hanya diubah jika diisi)
function update_users($koneksi, $user_id, $username, $pass)
{
    // username tidak boleh sama dengan user lain
    $cek = mysqli_prepare($koneksi, "SELECT id FROM users WHERE username = ? AND id <> ?");
    mysqli_stmt_bind_param($cek, "si", $username, $user_id);
    mysqli_stmt_execute($cek);
    $ada = mysqli_num_rows(mysqli_stmt_get_result($cek)) > 0;
    mysqli_stmt_close($cek);
    if ($ada) {
        throw new Exception('Username sudah dipakai');
    }

    if ($pass !== '') {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($koneksi, "UPDATE users SET username = ?, password = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $username, $hash, $user_id);
    } else {
        $stmt = mysqli_prepare($koneksi, "UPDATE users SET username = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $username, $user_id);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$aksi     = $_GET['aksi'] ?? '';
$username = trim($_POST['username'] ?? '');
$pass     = $_POST['password'] ?? '';

try {
    mysqli_begin_transaction($koneksi);

    if ($aksi === 'editadmin') {
        // di form admin, "id" adalah id dari tabel users
        $user_id = (int) ($_POST['id'] ?? 0);
        update_users($koneksi, $user_id, $username, $pass);

    } elseif ($aksi === 'editguru') {
        $id      = (int) ($_POST['id'] ?? 0);        // id tabel guru
        $user_id = (int) ($_POST['user_id'] ?? 0);   // id tabel users
        $nip     = trim($_POST['nip'] ?? '');
        $nama    = trim($_POST['nama'] ?? '');
        $jk      = $_POST['jenis_kelamin'] ?? 'L';

        update_users($koneksi, $user_id, $username, $pass);

        if ($id > 0) {
            $stmt = mysqli_prepare($koneksi, "UPDATE guru SET nip = ?, nama = ?, jenis_kelamin = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $nip, $nama, $jk, $id);
        } else {
            // akun belum punya profil -> buat baru
            $stmt = mysqli_prepare($koneksi, "INSERT INTO guru (nip, nama, jenis_kelamin, user_id) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssi", $nip, $nama, $jk, $user_id);
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } elseif ($aksi === 'editsiswa') {
        $id      = (int) ($_POST['id'] ?? 0);        // id tabel siswa
        $user_id = (int) ($_POST['user_id'] ?? 0);   // id tabel users
        $nis     = trim($_POST['nis'] ?? '');
        $nama    = trim($_POST['nama'] ?? '');
        $kelas   = trim($_POST['kelas'] ?? '');
        $jk      = $_POST['jenis_kelamin'] ?? 'L';

        update_users($koneksi, $user_id, $username, $pass);

        if ($id > 0) {
            $stmt = mysqli_prepare($koneksi, "UPDATE siswa SET nis = ?, nama = ?, kelas = ?, jenis_kelamin = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssssi", $nis, $nama, $kelas, $jk, $id);
        } else {
            // akun belum punya profil -> buat baru
            $stmt = mysqli_prepare($koneksi, "INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssi", $nis, $nama, $kelas, $jk, $user_id);
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } else {
        mysqli_rollback($koneksi);
        pesan('Aksi tidak dikenali!', 'daftar_user.php');
    }

    mysqli_commit($koneksi);
    pesan('Data Berhasil Diubah', 'daftar_user.php');
} catch (Throwable $e) {
    mysqli_rollback($koneksi);
    pesan('Data Tidak Berhasil Diubah: ' . $e->getMessage(), 'daftar_user.php');
}