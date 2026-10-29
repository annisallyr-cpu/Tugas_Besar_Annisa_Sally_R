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

            <div class="col-30">
                <br>
                <!-- awal card -->
                <div class="card">
                    <div class="card-header">
                        <h3>Tabel</h3>
                    </div>
                    <div class="card-body">
                        <!-- awal tabel -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Akmal12</td>
                                    <td>Siswa</td>
                                    <td>Akmal</td>
                                    <td>
                                        <a href="edit.php?id=1" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus.php?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- akhir tabel -->
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