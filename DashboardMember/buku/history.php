<?php
// Start the session
session_start();

// Check if 'nama' is set in the session, if not, redirect to the login page
if (!isset($_SESSION['nama'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_SESSION['nisn'])) {
    header("Location: ../../login.php");
    exit();
}

require "../../config/config.php";

// Access the NIS from the session
$nisn = $_SESSION['nisn'];

// Assuming $id is the specific value you want to match

$peminjaman = queryReadData("SELECT * FROM peminjaman
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN user ON peminjaman.id_user = user.id
WHERE peminjaman.nisn = '$nisn' and status = '3 '");

// Replace $id with the actual condition you want to use in the WHERE clause
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Book Store Digital</title>
    <link rel="icon" href="../../assets/bookstore.png" type="image/png">
    <!-- Custom fonts for this template -->
    <link href="../../assets2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../assets2/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../assets2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>
    <!-- Topbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand me-0 mx-3" href="../dashboard.php">
                <img src="../../assets/bookstore.png" alt="Avatar Logo" style="width:50px;">
            </a>
            <a class="navbar-brand" href="../dashboard.php" style="font-family: 'Shadows Into Light', cursive; font-size: 150%;">Book Store Digital</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard.php">Daftar Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="daftar_pinjam.php">Daftar Pinjam</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="history.php">History</a>
                    </li>
                </ul>
            </div>

            <div class="dropdown ms-auto" data-bs-theme="primary">
                <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="../../assets/user.png" alt="memberLogo" width="40px">
                </a>
                <ul style="margin-left: -7rem;" class="dropdown-menu position-absolute">
                    <li>
                        <a class="dropdown-item text-center text-secondary" href="#"> <span class="text-capitalize"><?php echo $_SESSION['nama']; ?></span></a>
                        <a class="dropdown-item text-center mb-2" href="#">Siswa</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-center p-2 bg-danger text-light rounded" href="../logout.php">Logout <i class="fa-solid fa-right-to-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="mt-3 alert alert-primary" role="alert">Riwayat History Buku Anda - <span class="fw-bold text-capitalize"><?php echo htmlentities($_SESSION["nama"]); ?></span></div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">History Buku</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Cover</th>
                                <th>Judul Buku</th>
                                <th>Nama Petugas</th>
                                <th>No. Telepon</th>
                                <th>Tgl. Pinjam</th>
                                <th>Tgl. Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; // Nomor urut dimulai dari 1
                            if (isset($peminjaman) && is_array($peminjaman) && count($peminjaman) > 0) {
                                foreach ($peminjaman as $item) :
                            ?>
                                    <tr>
                                        <td align="center"><?php echo $no++ ?></td>
                                        <td align="center">
                                            <img src="../../imgDB/<?= $item['cover']; ?>" alt="" width="70px" height="100px" style="border-radius: 5px;">
                                        </td>
                                        <td><?= $item["judul"]; ?></td>
                                        <td><?= $item["nama"]; ?></td>
                                        <td><?= $item["no_tlp"]; ?></td>
                                        <td align="center"><?= $item["tgl_pinjam"]; ?></td>
                                        <td align="center"><?= $item["tgl_kembali"]; ?></td>
                                    </tr>
                            <?php endforeach;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets2/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets2/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../assets2/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets2/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets2/js/demo/datatables-demo.js"></script>

</body>

</html>