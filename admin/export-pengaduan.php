<?php
session_start();
require '../database/conn.php';
require('fpdf/fpdf.php');

// Ambil data dari database
$sql = "SELECT *, DATE_FORMAT(tanggal, '%d/%m/%Y') AS formatted_date FROM pengaduan";
$result = $conn->query($sql);

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('images/poliwangi.png',10,6,30);
        $this->SetFont('Arial','B',12);
        // Title
        $this->Cell(0,10,'Data Pengaduan',0,1,'C');
        $this->Ln(30);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Table with data
    function BasicTable($header, $data, $widths)
    {
        // Header
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($widths[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();

        // Data
        foreach($data as $row)
        {
            for ($i = 0; $i < count($row); $i++) {
                $this->Cell($widths[$i], 6, $row[$i], 1);
            }
            $this->Ln();
        }
    }
}

// Instantiation of inherited class
$pdf = new PDF('L', 'mm', 'A4'); // 'L' for Landscape orientation
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$header = array('No', 'Nama', 'Email', 'Telpon', 'Jurusan', 'Laporan', 'Tindakan', 'Tanggal', 'Status');
$data = [];

if ($result->num_rows > 0) {
    $no = 1; // Initialize row number
    while($row = $result->fetch_assoc()) {
        $status = $row['status'] == 'pending' ? 'Pending' : ($row['status'] == 'approve' ? 'Diterima' : 'Ditolak');
        $data[] = [
            $no, // Add row number
            $row['nama_pengadu'],
            $row['email_pengadu'],
            $row['nomor_telepon'],
            $row['jurusan'],
            $row['deskripsi_pengaduan'],
            $row['tindakan_diinginkan'],
            $row['formatted_date'],
            $status
        ];
        $no++; // Increment row number
    }
}

// Calculate the maximum width for each column
$widths = [];
foreach ($header as $col) {
    $widths[] = $pdf->GetStringWidth($col) + 6; // Initial width based on header
}

foreach ($data as $row) {
    for ($i = 0; $i < count($row); $i++) {
        $widths[$i] = max($widths[$i], $pdf->GetStringWidth($row[$i]) + 6);
    }
}

$pdf->BasicTable($header, $data, $widths);
$pdf->Output();
?>
