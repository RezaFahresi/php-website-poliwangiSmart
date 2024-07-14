<?php
$servername = "localhost";
$username = "root";  // sesuaikan dengan username MySQL Anda
$password = "";      // sesuaikan dengan password MySQL Anda
$dbname = "poliwangi_smart_testing";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan data dari form
$jurusan = $_POST['jurusan'];
$kategori = $_POST['kategori'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$deskripsi = $_POST['deskripsi'];
$tindakan = $_POST['tindakan'];
$tanggal = $_POST['tanggal'];

// Menghandle file upload
$uploadDir = 'uploads/';
$buktiFiles = [];
if (!empty($_FILES['bukti']['name'][0])) {
    foreach ($_FILES['bukti']['name'] as $key => $name) {
        $tmp_name = $_FILES['bukti']['tmp_name'][$key];
        $uploadFile = $uploadDir . basename($name);
        if (move_uploaded_file($tmp_name, $uploadFile)) {
            $buktiFiles[] = $uploadFile;
        }
    }
}
$bukti = implode(',', $buktiFiles);

// Menyiapkan dan menjalankan pernyataan SQL untuk memasukkan data
$sql = "INSERT INTO pengaduan (jurusan, kategori, email, phone, deskripsi, bukti, tindakan, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $jurusan, $kategori, $email, $phone, $deskripsi, $bukti, $tindakan, $tanggal);

if ($stmt->execute()) {
    echo "Data has been submitted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup pernyataan dan koneksi
$stmt->close();
$conn->close();
?>
