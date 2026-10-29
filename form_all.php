<?php
require_once 'navbar.php';
?>

<?php
// Mengambil nilai role dari query string URL (GET)
$role = isset($_GET['role']) ? $_GET['role'] : '';

// Menentukan judul form sesuai role yang dipilih
$title = "Form Tambah User";
if ($role === 'Siswa') {
    $title = "Form Tambah User (Siswa)";
} elseif ($role === 'Guru') {
    $title = "Form Tambah User (Guru)";
} elseif ($role === 'Admin') {
    $title = "Form Tambah User (Admin)";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-3 p-md-5">

    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm">
            <!-- Header Form -->
            <div class="card-header bg-white fw-bold fs-5">
                <?= htmlspecialchars($title); ?>
            </div>
            
            <div class="card-body">
                <!-- FORM UTAMA DENGAN AKSI AKSI_TAMBAH_USER.PHP -->
                <form action="aksi_tambah_user.php" method="POST">
                    
                    <!-- Input Hidden untuk menyimpan role yang sedang dipilih -->
                    <input type="hidden" name="role" value="<?= htmlspecialchars($role); ?>">

                    <?php if ($role === 'Siswa'): ?>
                        <!-- ================= FORM PROFIL SISWA ================= -->

                        <div class="card">
                    <div class="card-header">
                        <h3>Form Tambah User (Siswa)</h3>
                    </div>
                    <div class="card-body">
                        <h3>Data Profil User</h3>
                        
                        <!-- awal form -->
                        <form action="aksi_tambah_user.php" method="POST">
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS:</label>
                                <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk Siswa | Contoh: 1234567890"></div>

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap:</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap Siswa | Contoh: Ujang Asep">
                            </div>

                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas:</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Kelas Siswa | Contoh: XI-RPL-1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin:</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="L" checked>
                                    <label class="form-check-label" for="laki">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P">
                                    <label class="form-check-label" for="perempuan">
                                        Perempuan
                                    </label>
                                </div>
                            </div>

                            <hr>

                    <?php elseif ($role === 'Guru'): ?>
                        <!-- ================= FORM PROFIL GURU ================= -->
                        <h5 class="fw-bold mb-3">Data Profil Guru</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">NIP:</label>
                            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai | Contoh: 198501012010011001" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap Guru:</label>
                            <input type="text" name="nama_guru" class="form-control" placeholder="Nama Lengkap Guru | Contoh: Budi Santoso, S.Kom" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Jenis Kelamin:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="L" checked>
                                <label class="form-check-label" for="jenis_kelamin">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P">
                                <label class="form-check-label" for="jenis_kelamin">Perempuan</label>
                            </div>
                        </div>
                        <hr>

                    <?php endif; ?>

                    <!-- ================= DATA KREDENSIAL AKUN (TAMPIL DI SEMUA ROLE) ================= -->
                    <h5 class="fw-bold mb-3">Data Kredensial Akun (Tabel Users)</h5>

                    <div class="mb-3">
                        <label class="form-label">Username Akun:</label>
                        <input type="text" name="username" class="form-control" placeholder="Username Akun | Contoh: ujang123" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Akun:</label>
                        <input type="password" name="password" class="form-control" placeholder="Password Akun | Contoh: password123" required>
                    </div>

                    <!-- DROPDOWN PILIH ROLE -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Role</label>
                        <!-- Menggunakan event bawaan HTML 'onchange="this.form.action=\'form_all.php\'; this.form.method=\'GET\'; this.form.submit();"' -->
                        <select name="role" class="form-select" onchange="this.form.action='form_all.php'; this.form.method='GET'; this.form.submit();" required>
                            <option value="" disabled <?= empty($role) ? 'selected' : ''; ?>>Pilih Role</option>
                            <option value="Siswa" <?= ($role === 'Siswa') ? 'selected' : ''; ?>>Siswa</option>
                            <option value="Guru" <?= ($role === 'Guru') ? 'selected' : ''; ?>>Guru</option>
                            <option value="Admin" <?= ($role === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                        <small class="text-muted italic d-block mt-1">
                            Pilih role Siswa atau Guru untuk menampilkan form data profil.
                        </small>
                    </div>

                    <!-- TOMBOL SIMPAN & KEMBALI -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4 me-2">Simpan Data</button>
                        <a href="form_all.php" class="btn btn-secondary px-4">Kembali</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>