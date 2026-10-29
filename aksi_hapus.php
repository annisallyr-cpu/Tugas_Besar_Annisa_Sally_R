<?php
require_once 'koneksi.php';

function pesan($teks, $url)
{
    echo "<script>alert(" . json_encode($teks) . "); window.location.href=" . json_encode($url) . ";</script>";
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    pesan('ID user tidak valid!', 'daftar_user.php');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    mysqli_begin_transaction($koneksi);

    // hapus data profil dulu (siswa / guru), baru hapus akun di tabel users
    foreach (['siswa', 'guru'] as $tabel) {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM $tabel WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $stmt = mysqli_prepare($koneksi, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_commit($koneksi);
    pesan('User Berhasil dihapus', 'daftar_user.php');
} catch (Throwable $e) {
    mysqli_rollback($koneksi);
    pesan('User Tidak Berhasil dihapus', 'daftar_user.php');
}