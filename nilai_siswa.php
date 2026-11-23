<?php
session_start();
require_once 'koneksi.php';

// Ambil NIS siswa
$nis = $_GET['nis'] ?? '63837348';

// Ambil data siswa
$stmt = mysqli_prepare($koneksi,
    "SELECT * FROM siswa WHERE nis = ?"
);

mysqli_stmt_bind_param($stmt, "s", $nis);
mysqli_stmt_execute($stmt);

$result_siswa = mysqli_stmt_get_result($stmt);
$siswa = mysqli_fetch_assoc($result_siswa);

if (!$siswa) {
    die("Data siswa tidak ditemukan.");
}

$id_siswa = $siswa['id'];

// Ambil daftar nilai
$query = mysqli_query($koneksi, "
    SELECT * FROM nilai
    WHERE siswa_id = '$id_siswa'
    ORDER BY id ASC
");

// Hitung rata-rata nilai
$query_rata = mysqli_query($koneksi, "
    SELECT AVG(nilai_akhir) AS rata_rata
    FROM nilai
    WHERE siswa_id = '$id_siswa'
");

$data_rata = mysqli_fetch_assoc($query_rata);
$rata_rata = $data_rata['rata_rata'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Nilai Siswa</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
    body {
        background: #ffffff;
        font-family: Arial, sans-serif;
        color: #292929;
    }

    .judul {
        text-align: center;
        margin-top: 15px;
        margin-bottom: 35px;
    }

    .judul h1 {
        font-size: 34px;
        font-weight: 600;
    }

    .identitas h2 {
        font-size: 29px;
        margin-top: 20px;
    }

    .identitas p {
        font-size: 21px;
        margin-bottom: 15px;
    }

    .card-custom {
        background: white;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 30px;
        margin: 25px 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .rata-rata {
        text-align: center;
    }

    .rata-rata h3 {
        font-size: 28px;
    }

    .rata-rata h1 {
        font-size: 55px;
        margin-top: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        min-width: 650px;
    }

    th, td {
        padding: 15px !important;
        vertical-align: middle;
    }

    @media(max-width: 576px) {
        .judul h1 {
            font-size: 30px;
        }

        .identitas h2 {
            font-size: 25px;
        }

        .identitas p {
            font-size: 19px;
        }

        .card-custom {
            padding: 20px;
            margin: 20px 10px;
        }
    }
</style>
</head>

<body>

<div class="container-fluid">

    <!-- IDENTITAS SISWA -->
    <div class="judul">

        <h1>Nilai Siswa</h1>

        <div class="identitas">

            <h2>
                <?= htmlspecialchars($siswa['nama']); ?>
            </h2>

            <p>
                NIS: <?= htmlspecialchars($siswa['nis']); ?>
            </p>

            <p>
                Kelas: <?= htmlspecialchars($siswa['kelas']); ?>
            </p>

        </div>

    </div>


    <!-- RATA-RATA NILAI -->
    <div class="card-custom rata-rata">

        <h3>Rata-rata Nilai</h3>

        <h1>
            <?= number_format((float)$rata_rata, 0); ?>
        </h1>

    </div>


    <!-- DAFTAR NILAI -->
    <div class="card-custom">

        <h2 class="mb-4">Daftar Nilai</h2>

        <div class="table-responsive">

            <table id="tabelNilai"
                   class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>KKM</th>
                        <th>Pengetahuan</th>
                        <th>Keterampilan</th>
                        <th>Nilai Akhir</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;

                while ($data = mysqli_fetch_assoc($query)) {
                ?>

                    <tr>
                        <td><?= $no++; ?></td>

                        <td>
                            <?= htmlspecialchars($data['mata_pelajaran']); ?>
                        </td>

                        <td><?= $data['kkm']; ?></td>

                        <td><?= $data['pengetahuan']; ?></td>

                        <td><?= $data['keterampilan']; ?></td>

                        <td><?= $data['nilai_akhir']; ?></td>
                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {

    $('#tabelNilai').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50],

        language: {
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            search: "Cari:",
            zeroRecords: "Tidak ada data tersedia",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
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
