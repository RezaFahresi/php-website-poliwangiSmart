<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: ../../login/login-user.php");
}
require '../../database/conn.php';

$id=$_GET['id'];
$sql = "SELECT *, DATE_FORMAT(tanggal, '%d/%m/%Y') AS formatted_date FROM pengaduan WHERE id = $id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Poliwangi Smart</title>
  <link rel="icon" href="../src/logo/logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;900&display=swap" rel="stylesheet">
</head>

<body>

  <!-- NAVBABR -->

  <nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #005AE0, #003f87);font-family: Merriweather, serif;
            font-weight: 900;
            font-style: normal;">
    <div class="container-md">
      <a class="navbar-brand" href="../index.php">
        <img src="../src/logo/logo.png" alt="" width="60">
      </a>
      <a class="navbar-brand" href="#">Poliwangi Smart</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../formulir/index.php">Formulir</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Status</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../kontak/kontak.php">Kontak</a>
          </li>
        </ul>
      </div>
      <div class="dropdown" style=" color: white;">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
          aria-expanded="false" style=" color: white;">
          <img src="../src/img/users.png" alt="users" width="32" height="32" class="rounded-circle">
          <?= $_SESSION['user'] ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="; color: white;">
          <li><a class="dropdown-item" href="../../login/logout.php" style=" color: black;">Sign Out</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- NAVBABR -->

  <!-- Detail Pengaduan -->

  <div class="container-md g-5 py-5" style="font-family: Merriweather, serif;
            font-weight: 400;
            font-style: normal;">
    <h3>Detail Pengaduan</h3>
    <div id="pengaduanDetail">
      <!-- Data detail pengaduan akan diisi di sini -->
      <div class="card-body">
        <h5 class="card-title">Kategori Pengaduan: <?php echo htmlspecialchars($data['kategori_pengaduan']); ?></h5>
        <p class="card-text">Berikut adalah detail pengaduan yang telah dilaporkan:</p>
        <ul class="list-group mb-3">
          <li class="list-group-item"><strong>Jurusan:</strong> <?php echo htmlspecialchars($data['jurusan']); ?></li>
          <li class="list-group-item"><strong>Nama Pengadu:</strong>
            <?php echo htmlspecialchars($data['nama_pengadu']); ?></li>
          <li class="list-group-item"><strong>Email Pengadu:</strong>
            <?php echo htmlspecialchars($data['email_pengadu']); ?></li>
          <li class="list-group-item"><strong>Nomor Telepon:</strong>
            <?php echo htmlspecialchars($data['nomor_telepon']); ?></li>
          <li class="list-group-item"><strong>Deskripsi Pengaduan:</strong>
            <?php echo htmlspecialchars($data['deskripsi_pengaduan']); ?></li>
          <li class="list-group-item"><strong>Tindakan yang Diinginkan:</strong>
            <?php echo htmlspecialchars($data['tindakan_diinginkan']); ?></li>
          <li class="list-group-item"><strong>Tanggal:</strong> <?php echo htmlspecialchars($data['formatted_date']); ?>
          </li>
          <li class="list-group-item"><strong>Status:</strong> <?php echo htmlspecialchars($data['status']); ?></li>
          <?php if (!empty($data['bukti_pendukung'])): ?>
          <li class="list-group-item"><strong>Bukti Pendukung:</strong> <a
              href="/poliwangi_smart/bukti/<?php echo htmlspecialchars($data['bukti_pendukung']); ?>"
              target="_blank">Download</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <!-- Detail Pengaduan -->

  <footer style="background: linear-gradient(90deg, #005AE0, #003f87);font-family: Merriweather, serif;
            font-weight: 300;
            font-style: normal;">
            <div class="container p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4" style="color: white;">
                        <h5 class="mb-3" style="letter-spacing: 2px;">Poliwangi Smart</h5>
                        <p>
                            Selamat datang di layanan pengaduan online Politeknik Negeri Banyuwangi! Sampaikan keluhan,
                            saran, dan
                            masukan Anda dengan mudah dan cepat. Kami siap menangani setiap pengaduan secara profesional
                            demi
                            menciptakan lingkungan kampus yang lebih baik. Mari bersama-sama membangun Poliwangi yang
                            lebih
                            baik!kepuasan Anda. Mari bersama-sama membangun Poliwangi yang lebih baik!
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="mb-3" style="letter-spacing: 2px; color: white;">Menu</h5>
                        <ul class="list-unstyled mb-0" style="color :white;">
                            <li class="mb-1">
                                <a href="../index.php" style="color :white;">Home</a>
                            </li>
                            <li class="mb-1">
                                <a href="../formulir/index.php" style="color :white;">Formulir</a>
                            </li>
                            <li class="mb-1">
                                <a href="../status/index.php" style="color :white;">Status</a>
                            </li>
                            <li>
                                <a href="../kontak/kontak.php" style="color :white;">Kontak</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="mb-1" style="letter-spacing: 2px; color: white;">Jam Layanan</h5>
                        <table class="table" style="color: white; border-color: white;">
                            <tbody>
                                <tr>
                                    <td>Senin - Jum'at:</td>
                                    <td>08:00 WIB - 16:00 WIB</td>
                                </tr>
                                <tr>
                                    <td>Sabtu - Minggu:</td>
                                    <td>08:00 WIB - 10:00 WIB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2); color:white;">
                © 2024 poliwangi : Poliwangi Smart
            </div>
            <!-- Copyright -->
        </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
</body>

</html>