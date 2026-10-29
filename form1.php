<?php
require_once 'navbar.php';
?>

<!-- awal content -->
<div class="container">

    <!-- awal kolom -->
    <div class="container">
        <div class="row align-items-center">
            <div class="col-2">
                <!-- One of three columns -->
            </div>

            <div class="col-20">
                <br>
                <!-- awal card -->
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
                                <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Kelas Siswa  | Contoh: XI-RPL-1">
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

                            <h3>Data Kredensial Akun</h3>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username Akun | Contoh: ujang123">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Akun:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password Akun | Contoh: password123">
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" name="role" value="siswa" readonly><br>
                            </div>

                            <button type="submit" name="tambah" class="btn btn-primary">Simpan Data</button>
                            <a href="tabel.php" class="btn btn-secondary">Kembali</a>
                        </form>
                        <!-- akhir form -->
                    </div>
                </div>
                <!-- akhir card -->
            </div>

            <div class="col-2">
                <!-- One of three columns -->
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>