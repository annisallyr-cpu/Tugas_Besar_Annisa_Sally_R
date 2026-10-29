
<?php
require_once 'koneksi.php';
require_once 'navbar.php';

// Mengamankan output HTML
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

$id   = (int) ($_GET['id'] ?? 0);
$role = strtolower(trim($_GET['role'] ?? ''));

if ($id <= 0) {
    echo '<div class="container my-4">
            <div class="alert alert-danger">
                ID user tidak valid.
            </div>
          </div>';
} elseif ($role === 'admin') {

    // ================= DATA ADMIN =================
    $stmt = mysqli_prepare($koneksi, "
        SELECT *
        FROM users
        WHERE id = ? AND LOWER(role) = 'admin'
        LIMIT 1
    ");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $admin = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$admin) {
        echo '<div class="container my-4">
                <div class="alert alert-danger">
                    Data admin tidak ditemukan.
                </div>
              </div>';
    } else {
?>

<div class="container my-4">
    <div class="card">
        <div class="card-header">
            <h3>Form Edit User (Admin)</h3>
        </div>

        <div class="card-body">
            <form action="aksi_edit_user.php?aksi=editadmin" method="POST">

                <h3>Data Kredensial Akun</h3>

                <div class="mb-3">
                    <label for="username_admin" class="form-label">
                        Username:
                    </label>
                    <input
                        type="text"
                        id="username_admin"
                        name="username"
                        class="form-control"
                        value="<?= e($admin['username']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="password_admin" class="form-label">
                        Password Baru:
                    </label>
                    <input
                        type="password"
                        id="password_admin"
                        name="password"
                        class="form-control"
                        placeholder="Kosongkan jika tidak ingin mengubah password"
                    >
                </div>

                <input type="hidden" name="role" value="admin">
                <input type="hidden" name="id" value="<?= (int) $admin['id'] ?>">

                <button type="submit" name="edit" class="btn btn-primary me-2">
                    Ubah Data
                </button>

                <a href="daftar_user.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>
        </div>
    </div>
</div>

<?php
    }

} elseif ($role === 'guru') {

    // ================= DATA GURU =================
    // ID pada URL harus merupakan users.id
    $stmt = mysqli_prepare($koneksi, "
        SELECT
            u.id AS user_id,
            u.username,
            g.id AS profil_id,
            g.nip,
            g.nama,
            g.jenis_kelamin
        FROM users AS u
        LEFT JOIN guru AS g ON g.user_id = u.id
        WHERE u.id = ? AND LOWER(u.role) = 'guru'
        LIMIT 1
    ");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $guru = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$guru) {
        echo '<div class="container my-4">
                <div class="alert alert-danger">
                    Akun guru tidak ditemukan.
                </div>
              </div>';
    } else {
?>

<div class="container my-4">
    <div class="card">
        <div class="card-header">
            <h3>Form Edit User (Guru)</h3>
        </div>

        <div class="card-body">

            <?php if (empty($guru['profil_id'])): ?>
                <div class="alert alert-warning">
                    Profil guru belum ditemukan untuk akun ini.
                    Periksa hubungan user_id pada tabel guru.
                </div>
            <?php endif; ?>

            <form action="aksi_edit_user.php?aksi=editguru" method="POST">

                <h3>Data Profil Guru</h3>

                <div class="mb-3">
                    <label for="nip_guru" class="form-label">NIP:</label>
                    <input
                        type="text"
                        id="nip_guru"
                        name="nip"
                        class="form-control"
                        value="<?= e($guru['nip'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="nama_guru" class="form-label">
                        Nama Lengkap:
                    </label>
                    <input
                        type="text"
                        id="nama_guru"
                        name="nama"
                        class="form-control"
                        value="<?= e($guru['nama'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Jenis Kelamin:</label>

                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="jenis_kelamin"
                            id="guru_laki"
                            value="L"
                            <?= (($guru['jenis_kelamin'] ?? '') === 'L') ? 'checked' : '' ?>
                            required
                        >
                        <label class="form-check-label" for="guru_laki">
                            Laki-laki
                        </label>
                    </div>

                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="jenis_kelamin"
                            id="guru_perempuan"
                            value="P"
                            <?= (($guru['jenis_kelamin'] ?? '') === 'P') ? 'checked' : '' ?>
                        >
                        <label class="form-check-label" for="guru_perempuan">
                            Perempuan
                        </label>
                    </div>
                </div>

                <hr>

                <h3>Data Kredensial Akun</h3>

                <div class="mb-3">
                    <label for="username_guru" class="form-label">
                        Username:
                    </label>
                    <input
                        type="text"
                        id="username_guru"
                        name="username"
                        class="form-control"
                        value="<?= e($guru['username']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="password_guru" class="form-label">
                        Password Baru:
                    </label>
                    <input
                        type="password"
                        id="password_guru"
                        name="password"
                        class="form-control"
                        placeholder="Kosongkan jika tidak ingin mengubah password"
                    >
                </div>

                <input type="hidden" name="role" value="guru">

                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) ($guru['profil_id'] ?? 0) ?>"
                >

                <input
                    type="hidden"
                    name="user_id"
                    value="<?= (int) $guru['user_id'] ?>"
                >

                <button type="submit" name="edit" class="btn btn-primary me-2">
                    Ubah Data
                </button>

                <a href="daftar_user.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>
        </div>
    </div>
</div>

<?php
    }

} elseif ($role === 'siswa') {

    // ================= DATA SISWA =================
    $stmt = mysqli_prepare($koneksi, "
        SELECT
            u.id AS user_id,
            u.username,
            s.id AS profil_id,
            s.nis,
            s.nama,
            s.kelas,
            s.jenis_kelamin
        FROM users AS u
        LEFT JOIN siswa AS s ON s.user_id = u.id
        WHERE u.id = ? AND LOWER(u.role) = 'siswa'
        LIMIT 1
    ");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $siswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$siswa) {
        echo '<div class="container my-4">
                <div class="alert alert-danger">
                    Akun siswa tidak ditemukan.
                </div>
              </div>';
    } else {
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Form Edit User (Siswa)</h3>
                </div>

                <div class="card-body">

                    <?php if (empty($siswa['profil_id'])): ?>
                        <div class="alert alert-warning">
                            Profil siswa belum ditemukan untuk akun ini.
                            Periksa hubungan user_id pada tabel siswa.
                        </div>
                    <?php endif; ?>

                    <form action="aksi_edit_user.php?aksi=editsiswa" method="POST">

                        <h3>Data Profil Siswa</h3>

                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS:</label>
                            <input
                                type="text"
                                id="nis"
                                name="nis"
                                class="form-control"
                                value="<?= e($siswa['nis'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label">
                                Nama Lengkap:
                            </label>
                            <input
                                type="text"
                                id="nama_siswa"
                                name="nama"
                                class="form-control"
                                value="<?= e($siswa['nama'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas:</label>
                            <input
                                type="text"
                                id="kelas"
                                name="kelas"
                                class="form-control"
                                value="<?= e($siswa['kelas'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">
                                Jenis Kelamin:
                            </label>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="jenis_kelamin"
                                    id="siswa_laki"
                                    value="L"
                                    <?= (($siswa['jenis_kelamin'] ?? '') === 'L') ? 'checked' : '' ?>
                                    required
                                >
                                <label class="form-check-label" for="siswa_laki">
                                    Laki-laki
                                </label>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="jenis_kelamin"
                                    id="siswa_perempuan"
                                    value="P"
                                    <?= (($siswa['jenis_kelamin'] ?? '') === 'P') ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="siswa_perempuan">
                                    Perempuan
                                </label>
                            </div>
                        </div>

                        <hr>

                        <h3>Data Kredensial Akun</h3>

                        <div class="mb-3">
                            <label for="username_siswa" class="form-label">
                                Username:
                            </label>
                            <input
                                type="text"
                                id="username_siswa"
                                name="username"
                                class="form-control"
                                value="<?= e($siswa['username']) ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password_siswa" class="form-label">
                                Password Baru:
                            </label>
                            <input
                                type="password"
                                id="password_siswa"
                                name="password"
                                class="form-control"
                                placeholder="Kosongkan jika tidak ingin mengubah password"
                            >
                        </div>

                        <input type="hidden" name="role" value="siswa">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int) ($siswa['profil_id'] ?? 0) ?>"
                        >

                        <input
                            type="hidden"
                            name="user_id"
                            value="<?= (int) $siswa['user_id'] ?>"
                        >

                        <button type="submit" name="edit" class="btn btn-primary me-2">
                            Ubah Data
                        </button>

                        <a href="daftar_user.php" class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }

} else {
    echo '<div class="container my-4">
            <div class="alert alert-danger">
                Role tidak valid.
            </div>
          </div>';
}

require_once 'footer.php';
?>
