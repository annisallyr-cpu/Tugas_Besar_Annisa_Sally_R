<?php
session_start();
require_once 'koneksi.php';

$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error_message = 'Username dan password wajib diisi!';
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        $valid = false;
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $valid = true;
            } elseif (hash_equals($user['password'], $password)) {
                // password lama (plain text) -> otomatis diubah jadi hash
                $valid = true;
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $up = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE id = ?");
                mysqli_stmt_bind_param($up, "si", $hash, $user['id']);
                mysqli_stmt_execute($up);
                mysqli_stmt_close($up);
            }
        }

        if ($valid) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: daftar_user.php");
            exit;
        } else {
            $error_message = 'Username atau password salah!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e0e6ef;
    }
    .login-card {
      max-width: 480px;
      margin: 60px auto;
      padding: 32px;
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 8px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="login-card">
      <h2 class="text-center fw-bold mb-4">Login</h2>

      <?php if ($error_message !== ''): ?>
        <div class="alert alert-danger py-2">
          <?= htmlspecialchars($error_message) ?>
        </div>
      <?php endif; ?>

      <form action="aksi_login.php" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username"
                 placeholder="Masukkan username" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password"
                 placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn btn-secondary w-100">Login</button>
      </form>

      <p class="text-center mt-3 mb-0">
        Belum punya akun? <a href="form_all.php">Register</a>
      </p>
    </div>
  </div>

</body>
</html>