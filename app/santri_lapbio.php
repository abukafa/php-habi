<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("L", "cm", "A5");

$no = 1;
$query = mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas<>'XXX' order by kelas and nama");
while ($lihat = mysqli_fetch_assoc($query)) {


	$pdf->SetMargins(1, 1, 1);
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$pdf->Image('../assets/img/kop.png', 1, 0.6, 20, 2);
	$pdf->Line(1, 2.7, 20, 2.7);
	$pdf->SetLineWidth(0.1);
	$pdf->Line(1, 2.8, 20, 2.8);
	$pdf->SetLineWidth(0);

	$pdf->ln(2.2);
	$pdf->SetFont('Arial', 'B', 14);
	$pdf->Cell(19, 0.7, "B I O D A T A   S A N T R I", 0, 10, 'C');
	$pdf->ln(0.5);

	if (file_exists('../public/foto/' . $lihat['panggilan'] . '.jpg')) {
		$pdf->Image('../public/foto/' . $lihat['panggilan'] . '.jpg', 1.3, 3.7, 4, 6);
	} else {
		$pdf->Image('../public/foto/no.png', 1.3, 3.7, 4, 6);
	}
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(5, 0.8, '', 0, 0, 'C');
	$pdf->Cell(3, 0.8, 'Nomor Induk', 0, 0, 'L');
	$pdf->Cell(0.5, 0.8, ": ", 0, 0, 'C');
	$pdf->Cell(10.5, 0.8, $lihat['nis'], 0, 1, 'L');
	$pdf->Cell(5, 0.8, '', 0, 0, 'C');
	$pdf->Cell(3, 0.8, 'Nama Lengkap', 0, 0, 'L');
	$pdf->Cell(0.5, 0.8, ": ", 0, 0, 'L');
	$pdf->Cell(10.5, 0.8, $lihat['nama'], 0, 1, 'L');
	$pdf->Cell(5, 0.8, '', 0, 0, 'C');
	$pdf->Cell(3, 0.8, 'Jenis Kelamin', 0, 0, 'L');
	$pdf->Cell(0.5, 0.8, ": ", 0, 0, 'L');
	$pdf->Cell(10.5, 0.8, $lihat['kelamin'], 0, 1, 'L');
	$pdf->Cell(5, 0.8, '', 0, 0, 'C');
	$pdf->Cell(3, 0.8, 'Tempat Tgl Lahir', 0, 0, 'L');
	$pdf->Cell(0.5, 0.8, ": ", 0, 0, 'L');
	$pdf->Cell(10.5, 0.8, $lihat['tmp_lahir'] . ", " . $lihat['tgl_lahir'], 0, 1, 'L');
	$pdf->Cell(5, 0.8, '', 0, 0, 'C');
	$pdf->Cell(3, 0.8, 'Wali Santri', 0, 0, 'L');
	$pdf->Cell(0.5, 0.8, ": ", 0, 0, 'L');
	$pdf->Cell(10.5, 0.8, $lihat['ket_wali'], 0, 1, 'L');
	$pdf->Cell(5, 0.8, '', 0, 0, 'C');
	$pdf->Cell(3, 0.8, 'Alamat', 0, 0, 'L');
	$pdf->Cell(0.5, 0.8, ": ", 0, 0, 'L');
	$pdf->MultiCell(10.5, 0.8, $lihat['alamat'] . "  " . $lihat['dusun'] . " Desa. " . $lihat['desa'] . "  Kec. " . $lihat['kec'] . "  Kab. " . $lihat['kab'] . "  Kode pos. " . $lihat['kpos'], 0, 'L');
	$pdf->ln(0.25);
	$pdf->Cell(19, 0.8, 'M I N A T   &   B A K A T', 1, 1, 'C');
	$pdf->Cell(0.5, 0.8, '', 'L', 0, 'C');
	$pdf->Cell(1.5, 0.8, 'Hobi', 0, 0, 'L');
	$pdf->Cell(8, 0.8, ": " . $lihat['hobi'], 0, 0, 'L');
	$pdf->Cell(1.8, 0.8, 'Olah raga', 0, 0, 'L');
	$pdf->Cell(7.2, 0.8, ": " . $lihat['olah_raga'], 'R', 1, 'L');
	$pdf->Cell(0.5, 0.8, '', 'L,B', 0, 'C');
	$pdf->Cell(1.5, 0.8, 'Cita-cita', 'B', 0, 'L');
	$pdf->Cell(17, 0.8, ": " . $lihat['cita'], 'R,B', 1, 'L');

	$no++;
}
$pdf->Output("biodata.pdf", "I");
