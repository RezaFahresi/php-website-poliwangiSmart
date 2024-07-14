<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: ../../login/login-user.php");
}
require '../../database/conn.php';

if (isset($_POST['submit'])){
    $jurusan = $_POST['jurusan'];
    $kategori_pengaduan = $_POST['kategori_pengaduan'];
    $nama_pengadu = $_SESSION['user'];
    $email_pengadu = $_POST['email_pengadu'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $deskripsi_pengaduan = $_POST['deskripsi_pengaduan'];
    $tindakan_diinginkan = $_POST['tindakan_diinginkan'];

    if ($_FILES['bukti_pendukung']['name']) {
        $file_name = uniqid() . $_FILES['bukti_pendukung']['name'];
        $file_temp = $_FILES['bukti_pendukung']['tmp_name'];
        $file_size = $_FILES['bukti_pendukung']['size'];
        $file_type = $_FILES['bukti_pendukung']['type'];

        $upload_dir = '../../bukti/';
        $target_file = $upload_dir . basename($file_name);

        if (move_uploaded_file($file_temp, $target_file)) {
            $bukti_pendukung = $target_file;
        } else {
            echo "Gagal mengupload file.";
            exit();
        }
    } else {
        $bukti_pendukung = null;
    }

    $sql = "INSERT INTO pengaduan (jurusan, kategori_pengaduan, nama_pengadu, email_pengadu, nomor_telepon, deskripsi_pengaduan, bukti_pendukung, tindakan_diinginkan)
        VALUES ('$jurusan', '$kategori_pengaduan', '$nama_pengadu', '$email_pengadu', '$nomor_telepon', '$deskripsi_pengaduan', '$file_name', '$tindakan_diinginkan')";

    if ($conn->query($sql) === TRUE) {
        $pesan = "Data pengaduan berhasil disimpan.";
        header("Location: ../status/index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poliwangi Smart</title>
    <link rel="icon" href="../src/logo/logo.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;900&display=swap" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark"
        style="background: linear-gradient(90deg, #005AE0, #003f87);font-family: Merriweather, serif;
            font-weight: 900;
            font-style: normal;">
        <div class="container-md">
            <a class="navbar-brand" href="#">
                <img src="../src/logo/logo.png" alt="" width="60">
            </a>
            <a class="navbar-brand" href="../index.php">Poliwangi Smart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Formulir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../status/index.php">Status</a>
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
    <!-- NAVBAR -->

    <!-- Formulir -->

    <div class="container-md g-5 py-5" style="font-family: Merriweather, serif;
            font-weight: 400;
            font-style: normal;">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Formulir pengaduan</h3>
            <?php if (isset($pesan)): ?>
            <div class="alert alert-success" role="alert">
                <?= $pesan ?>
            </div>
            <?php endif; ?>
            <h4 class="mb-10">Jurusan</h4>
            <select class="form-select mb-3" required name="jurusan" aria-label="Default select example">
                <option selected>Pilih Jurusan</option>
                <option value="Tehnik Bisnis dan Informatika">Tehnik Bisnis dan Informatika</option>
                <option value="Tehnik Mesin">Tehnik Mesin</option>
                <option value="Tehnik Sipil">Tehnik Sipil</option>
                <option value="Tehnik Pertanian">Tehnik Pertanian</option>
                <option value="Pariwisata">Pariwisata</option>
            </select>
            <h4 class="mb-10">Kategori Pengaduan</h4>
            <select class="form-select mb-3" required name="kategori_pengaduan" aria-label="Default select example">
                <option selected>Pilih Kategori</option>
                <option value="Fasilitas Kampus">Fasilitas Kampus</option>
                <option value="Teknologi Informasi">Teknologi Informasi</option>
                <option value="Keamanan dan Keselamatan">Keamanan dan Keselamatan</option>
                <option value="Lainya">Lainya</option>
            </select>
            <h4>Informasi Pribadi</h4>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" required name="email_pengadu" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" required name="nomor_telepon" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Nomor Telepon</label>
            </div>
            <h4>Deskripsi Pengaduan</h4>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" required name="deskripsi_pengaduan"
                    id="floatingTextarea2" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Deskripsi</label>
            </div>
            <h4>Bukti Pendukung</h4>
            <div class="mb-3 mb-3">
                <label for="formFileMultiple" class="form-label">Upload Bukti dengan format jpeg</label>
                <input class="form-control" type="file" required name="bukti_pendukung" id="formFileMultiple" multiple>
            </div>
            <h4>Tindakan yang Diinginkan</h4>
            <div class="form-floating mb-3">
                <textarea class="form-control" required name="tindakan_diinginkan" placeholder="Leave a comment here"
                    id="floatingTextarea2" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Deskripsi</label>
            </div>
            <div class="button mb-3">
                <button type="submit" name="submit" class="btn btn-outline-primary btn-lg"
                    id="laporButton">Lapor!</button>
            </div>
        </form>
    </div>

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
                                <a href="#" style="color :white;">Formulir</a>
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
    <script>
        document.getElementById('laporButton').addEventListener('click', function() {
            var myModal = new bootstrap.Modal(document.getElementById('laporModal'));
            myModal.show();
        });
    </script>
</body>

</html>