<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(1,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/kop.png',1,0.6,20,2); 
$pdf->Line(1,2.7,28.5,2.7);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,2.8,28.5,2.8);   
$pdf->SetLineWidth(0);

$pdf->ln(2.2);
$pdf->SetFont('Arial','B',14);
$m=date('m');
if ($m >= 07 and $m <= 12) {
$y2=date('Y');
}else{
$y2=date('Y')-1;
}
$pdf->Cell(0,0.7,'DAFTAR HADIR PERTEMUAN WALI SANTRI',0,1,'C');
$pdf->Cell(0,0.7, date('D, d M Y') ,0,1,'C');

$pdf->ln(0.5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0.75, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'NIS', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Nama', 1, 0, 'C');
$pdf->Cell(0.75, 0.8, 'LP', 1, 0, 'C');
$pdf->Cell(1.25, 0.8, 'Kls', 1, 0, 'C');
$pdf->Cell(2.75, 0.8, 'Asal', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'JAM', 1, 0, 'C');
$pdf->SetFillColor(193,229,252);
$pdf->Cell(4.25, 0.8, 'Wali', 1, 0, 'C', 1);
$pdf->Cell(2.25, 0.8, 'Paraf', 1, 0, 'C');
$pdf->Cell(4.25, 0.8, 'Ibu', 1, 0, 'C');
$pdf->Cell(2.25, 0.8, 'Paraf', 1, 1, 'C');
$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas<>'XXX' order by ket_wali");
while($lihat=mysqli_fetch_array($query)){
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.75, 0.7, $no,1,0, 'C');
	$pdf->Cell(1.5, 0.7, $lihat['nis'],1,0, 'C');
	$pdf->Cell(6, 0.7, $lihat['nama'],1,0, 'L');
	$pdf->Cell(0.75, 0.7, substr($lihat['kelamin'],0,1),1, 0, 'C');
	$pdf->Cell(1.25, 0.7, $lihat['kelas'],1, 0, 'C');
	$pdf->Cell(2.75, 0.7, $lihat['kec'],1, 0, 'L');
	$pdf->Cell(1.5, 0.7, '', 1, 0, 'C');
	$pdf->Cell(4.25, 0.7, $lihat['ket_wali'], 1, 0,'L', 1);
	$pdf->Cell(2.25, 0.7, '', 1, 0,'L');
	$pdf->Cell(4.25, 0.7, $lihat['ibu'], 1, 0,'L');
	$pdf->Cell(2.25, 0.7, '', 1, 1,'L');
	$no++;
}

$pdf->Output("data santri.pdf","I");
?>