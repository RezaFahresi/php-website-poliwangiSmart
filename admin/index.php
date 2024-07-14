<?php
session_start();
if(!isset($_SESSION["user"])){
    if($_SESSION['role'] != 'admin'){
        header("Location: ../login/login-admin.php");
    }
}
require '../database/conn.php';

$sql = "SELECT *, DATE_FORMAT(tanggal, '%d/%m/%Y') AS formatted_date FROM pengaduan";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && isset($_POST['id_pengaduan'])) {
        $id_pengaduan = $_POST['id_pengaduan'];
        $action = $_POST['action'];

        if ($action == 'approve') {
            $new_status = 'approve';
        } elseif ($action == 'reject') {
            $new_status = 'reject';
        }

        $update_query = "UPDATE pengaduan SET status = '$new_status' WHERE id = $id_pengaduan";
        if ($conn->query($update_query) === TRUE) {
            echo "Status berhasil diubah.";
            echo "<script>window.location.href = 'index.php'</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
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
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
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

            <!-- DataTables Card-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Data Table Laporan
                    <a href="export-pengaduan.php" class="btn btn-primary float-right" target="_blank">Ekspor PDF</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telpon</th>
                                    <th>Jurusan</th>
                                    <th>Laporan</th>
                                    <th>Tindakan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php if ($result->num_rows > 0) {
                        $i = 1;
                        ?>
                            <tbody>
                                <?php
                        while($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['nama_pengadu'] ?></td>
                                    <td><?= $row['email_pengadu'] ?></td>
                                    <td><?= $row['nomor_telepon'] ?></td>
                                    <td><?= $row['jurusan'] ?></td>
                                    <td><?= $row['deskripsi_pengaduan'] ?></td>
                                    <td><?= $row['tindakan_diinginkan'] ?></td>
                                    <td><?= $row['formatted_date'] ?></td>
                                    <td>
                                        <a href="detail-pengaduan.php?id=<?= $row['id'] ?>"><i
                                                class="fa fa-info-circle"></i></a>
                                        <?php if ($row['status'] == 'pending') { ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_pengaduan" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn btn-success" name="action"
                                                value="approve"><i class="fa fa-check"></i></button>
                                            <button type="submit" class="btn btn-danger" name="action" value="reject"><i
                                                    class="fa fa-times"></i></button>
                                        </form>
                                        <?php } else {
                                    if ($row['status'] == 'approve') {
                                        echo "Diterima";
                                    } elseif ($row['status'] == 'reject') {
                                        echo "Ditolak";
                                    }
                                } ?>
                                    </td>
                                </tr><?php
                            $i++;
                        }
                        ?>
                            </tbody>
                            <?php
                    } else {
                        echo "Tidak ada data pengaduan.";
                    }
                    ?>
                        </table>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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