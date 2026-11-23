
<?php
$nama = $_SESSION['nama'] ?? 'Admin';
$role = $_SESSION['role'] ?? 'admin';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.navbar-custom {
    background: #f8f9fc;
    padding: 12px 22px;
    width: 100%;
}

.navbar-custom .navbar-brand {
    font-size: 25px;
    color: #222;
}

.navbar-custom .nav-link {
    color: #555;
    font-size: 17px;
    padding: 12px 0;
}

.navbar-custom .nav-link:hover {
    color: #198754;
}

.navbar-custom .dropdown-menu {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px 0;
}

.navbar-custom .dropdown-item {
    padding: 12px 20px;
}

.navbar-custom .dropdown-item:hover {
    background: #f1f3f5;
}

.navbar-custom .navbar-collapse {
    display: none !important;
}

.navbar-custom .navbar-collapse.show {
    display: block !important;
}

.navbar-custom .dropdown-menu {
    display: none;
}

.navbar-custom .dropdown-menu.show {
    display: block;
}

.navbar-toggler {
    border: 1px solid #aaa;
    padding: 8px 12px;
}

.search-box {
    display: flex;
    gap: 10px;
    margin: 12px 0;
}

.search-box input {
    min-width: 0;
    padding: 12px;
}

.akun {
    margin-top: 10px;
}

@media (min-width: 992px) {
    .navbar-custom .navbar-collapse {
        display: flex !important;
    }
}

@media (max-width: 991px) {
    .navbar-custom .navbar-nav {
        width: 100%;
    }

    .navbar-custom .nav-link {
        padding: 12px 0;
    }

    .navbar-custom .dropdown-menu {
        width: 100%;
    }

    .search-box {
        width: 100%;
    }

    .search-box input {
        flex: 1;
    }

    .akun {
        margin-bottom: 10px;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-custom">

    <div class="container-fluid">

        <a class="navbar-brand" href="index.php">
            Navbar
        </a>

        <button class="navbar-toggler"
                type="button"
                id="tombolNavbar"
                aria-label="Buka menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="navbar-collapse" id="menuNavbar">

            < class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Home
                    </a>
                </li>

                <!-- USER -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       data-menu="user">
                        User
                    </a>

                    <ul class="dropdown-menu" id="dropdown-user">

                        <li>
                            <a class="dropdown-item" href="daftar_user.php">
                                Daftar User
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="daftar_user2.php">
                                Daftar User 2
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="tambah_user1.php">
                                Tambah User 1 (Admin)
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="tambah_user2.php">
                                Tambah User 2 (Siswa)
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="tambah_user3.php">
                                Tambah User 3 (Guru)
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- SISWA -->
                <li class="nav-item dropdown">

    <a class="nav-link dropdown-toggle"
       href="#"
       data-menu="siswa">
        Siswa
    </a>

    <ul class="dropdown-menu" id="dropdown-siswa">

        <li>
            <a class="dropdown-item" href="daftar_siswa.php">
                Daftar Siswa
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="tambah_siswa.php">
                Tambah Siswa
            </a>
        </li>

    </ul>
</li>

                <!-- GURU -->
                <li class="nav-item dropdown">

    <a class="nav-link dropdown-toggle"
       href="#"
       data-menu="guru">
        Guru
    </a>

    <ul class="dropdown-menu" id="dropdown-guru">

        <li>
            <a class="dropdown-item" href="daftar_guru.php">
                Daftar Guru
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="tambah_guru.php">
                Tambah Guru
            </a>
        </li>

    </ul>
</li>

                <!-- MAPEL -->
                <li class="nav-item dropdown">

    <a class="nav-link dropdown-toggle"
       href="#"
       data-menu="mapel">
        Mapel
    </a>

    <ul class="dropdown-menu" id="dropdown-mapel">

        <li>
            <a class="dropdown-item" href="daftar_mapel.php">
                Daftar Mapel
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="tambah_mapel.php">
                Tambah Mapel
            </a>
        </li>

    </ul>
</li>

                <!-- MENGAJAR -->
                <li class="nav-item dropdown">

    <a class="nav-link dropdown-toggle"
       href="#"
       data-menu="mengajar">
        Mengajar
    </a>

    <ul class="dropdown-menu" id="dropdown-mengajar">

        <li>
            <a class="dropdown-item" href="daftar_mengajar.php">
                Daftar Mengajar
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="tambah_mengajar.php">
                Tambah Mengajar
            </a>
        </li>

    </ul>
</li>

            <!-- SEARCH -->
            <form class="search-box"
                  action="daftar_user.php"
                  method="GET">

                <input class="form-control"
                       type="search"
                       name="cari"
                       placeholder="Search">

                <button class="btn btn-outline-success">
                    Search
                </button>

            </form>

            <!-- AKUN -->
            <ul class="navbar-nav akun">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       data-menu="akun">

                        <?= htmlspecialchars($nama); ?>
                        (<?= htmlspecialchars($role); ?>)

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end"
                        id="dropdown-akun">

                        <li>
                            <a class="dropdown-item" href="index.php">
                                Dashboard
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger"
                               href="logout.php">
                                Logout
                            </a>
                        </li>

                    </ul>

                </li>

            </ul>

        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const tombol = document.getElementById('tombolNavbar');
    const menu = document.getElementById('menuNavbar');

    // Buka dan tutup hamburger
    tombol.addEventListener('click', function() {
        menu.classList.toggle('show');
    });

    // Buka dan tutup dropdown
    document.querySelectorAll('[data-menu]').forEach(function(link) {

        link.addEventListener('click', function(event) {

            event.preventDefault();

            const nama = this.getAttribute('data-menu');
            const dropdown = document.getElementById('dropdown-' + nama);

            const sedangTerbuka = dropdown.classList.contains('show');

            document.querySelectorAll('.navbar-custom .dropdown-menu')
                .forEach(function(item) {
                    item.classList.remove('show');
                });

            if (!sedangTerbuka) {
                dropdown.classList.add('show');
            }

        });

    });

});
</script>
