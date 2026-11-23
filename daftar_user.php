<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'koneksi.php';

// Ambil semua data user
$sql = "SELECT users.*,
        COALESCE(siswa.nama, guru.nama) AS nama
        FROM users
        LEFT JOIN siswa ON users.id = siswa.user_id
        LEFT JOIN guru ON users.id = guru.user_id
        ORDER BY users.id DESC";

$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$data = [];

while ($baris = mysqli_fetch_assoc($hasil)) {
    $data[] = $baris;
}

function e($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

require_once 'navbar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar User</title>

    <link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            overflow-x: hidden;
        }

        .judul-halaman {
            text-align: center;
            margin: 30px 0;
        }

        .card-user {
            margin: 15px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        #tabelUser {
            width: 100% !important;
            min-width: 750px;
        }

        #tabelUser th,
        #tabelUser td {
            vertical-align: middle;
        }

        .aksi {
            white-space: nowrap;
        }

        @media(max-width: 576px) {
            .card-user {
                margin: 10px;
            }

            .judul-halaman h2 {
                font-size: 27px;
            }
        }
    </style>

</head>

<body>

<div class="container-fluid">

    <div class="judul-halaman">
        <h2>Daftar User</h2>
    </div>

    <div class="card card-user">

        <div class="card-header">
            <h4>Tabel Daftar User</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table id="tabelUser"
                       class="table table-striped table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Nama</th>
                            <th>Created At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php $no = 1; ?>

                    <?php foreach ($data as $baris): ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td><?= e($baris['username']); ?></td>

                            <td>••••••••</td>

                            <td><?= e($baris['role']); ?></td>

                            <td><?= e($baris['nama']); ?></td>

                            <td>
                                <?= e($baris['created_at']); ?>
                            </td>

                            <td class="aksi">

                                <a href="form_edit_user.php?id=<?= (int)$baris['id']; ?>&role=<?= urlencode($baris['role']); ?>"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="aksi_hapus.php?id=<?= (int)$baris['id']; ?>&role=<?= urlencode($baris['role']); ?>"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                   class="btn btn-danger btn-sm">
                                    Hapus
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {

    $('#tabelUser').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50],

        scrollX: true,

        language: {
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            search: "Cari:",
            zeroRecords: "Tidak ada data ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",

            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya"
            }
        }

    });

});
</script>

</body>
</html>

<?php
require_once 'footer.php';
ob_end_flush();
?>
