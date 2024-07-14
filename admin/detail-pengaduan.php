<?php
session_start();
if(!isset($_SESSION["user"])){
    if($_SESSION['role'] != 'admin'){
    header("Location: ../login/login-admin.php");
    }
}
require '../database/conn.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT *, DATE_FORMAT(tanggal, '%d/%m/%Y') AS formatted_date FROM pengaduan WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data pengaduan tidak ditemukan.";
        exit;
    }
} else {
    echo "ID pengaduan tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/poliwangi.png">
    <title>Dashboard - Poliwangi SMART</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer" id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="index">POLIWANGI SMART</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav sidebar-menu" id="exampleAccordion">
                <li class="sidebar-profile nav-item" data-toggle="tooltip" data-placement="right" title="Admin">
                    <div class="profile-main">
                        <p class="image">
                            <img alt="image" src="images/avatar.png" width="80">
                            <span class="status"><i class="fa fa-circle text-success"></i></span>
                        </p>
                        <p>
                            <span class=""><?= $_SESSION['user'] ?></span><br>
                            <span class="user" style="font-family: monospace;">Super Admin</span>
                        </p>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="index.php">
                        <i class="fa fa-fw fa-dashboard"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                    <ul class="sidenav-second-level collapse" id="collapseComponents">
                        <li>
                            <a href="cards">Cards</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="../login/logout.php">
                        <i class="fa fa-fw fa-sign-out"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">My Dashboard</li>
            </ol>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Detail Pengaduan
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <tr>
                            <th>Nama</th>
                            <td><?= $row['nama_pengadu'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $row['email_pengadu'] ?></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td><?= $row['nomor_telepon'] ?></td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td><?= $row['jurusan'] ?></td>
                        </tr>
                        <tr>
                            <th>Laporan</th>
                            <td><?= $row['deskripsi_pengaduan'] ?></td>
                        </tr>
                        <tr>
                            <th>Tindakan</th>
                            <td><?= $row['tindakan_diinginkan'] ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td><?= $row['formatted_date'] ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?= $row['status'] ?></td>
                        </tr>
                    </table>
                    <?php if ($row['status'] == 'pending') { ?>
                        <form action="" method="post">
                            <input type="hidden" name="id_pengaduan" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-success" name="action" value="approve">Terima</button>
                            <button type="submit" class="btn btn-danger" name="action" value="reject">Tolak</button>
                        </form>
                    <?php } ?>
                </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
    </div>
        <!-- /.content-wrapper-->
        <footer class="sticky-footer">
            <div class="container">
                <div class="text-center">
                    <small>Copyright © Poliwangi SMART 2024</small>
                </div>
            </div>
        </footer>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="../login/login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Page level plugin JavaScript-->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/sb-admin-datatables.js"></script>
    </div>
</body>
</html>