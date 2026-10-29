<?php
session_start();
require_once 'navbar.php';
require_once 'koneksi.php';

$nama = $_SESSION['nama'] ?? 'Pengguna';
$role = $_SESSION['role'] ?? 'Belum diketahui';
?>

<h1>Selamat Datang, <?= htmlspecialchars($nama) ?>, Anda sebagai <?= htmlspecialchars($role) ?></h1>

<br>
<a href="logout.php">Logout</a>

<?php require_once 'footer.php'; ?>