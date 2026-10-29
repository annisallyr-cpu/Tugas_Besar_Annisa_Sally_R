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
                        <h3>Form Tambah User (Admin)</h3>
                    </div>
                    <div class="card-body">
                        <h3>Data Kredensial Akun</h3>
                        
                        <!-- awal form -->
                        <form action="aksi_tambah_user.php" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="username" placeholder="Username Akun | Contoh: ujang123">
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password Akun | Contoh: password123">
                            </div>

                          <div class="mb-3">
                                <label for="role" class="form-label">Pilih Role</label>
                                <select class="form-select" id="role" aria-label="Pilih Role">
                                    <option selected disabled>Pilih Role</option>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <div class="form-text text-muted fs-6 fst-italic mt-2">
                                    Pilih role Siswa atau Guru untuk menampilkan form data profil.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
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