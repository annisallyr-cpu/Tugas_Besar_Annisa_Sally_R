<?php

require_once 'koneksi.php';
session_start();

$username = $_POST['username'] ?? '';
$pass     = $_POST['password'] ?? '';

$sql = "SELECT users.*, COALESCE(siswa.nama, guru.nama) AS nama, siswa.kelas, siswa.user_id
FROM users
LEFT JOIN siswa ON users.id = siswa.user_id
LEFT JOIN guru ON users.id = guru.user_id
WHERE users.username = ?";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($pass, $user['password'])) {

  $_SESSION['id']       = $user['id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['nama']     = $user['nama'];
  $_SESSION['role']     = $user['role'];
  $_SESSION['kelas']    = $user['kelas'];
  $_SESSION['login']    = true;

  header("Location: index.php");
  exit;
} else {
  echo "<script>alert('username atau password salah !!!');window.location.href='login.php'</script>";
}