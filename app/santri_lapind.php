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
$pdf->Cell(0,0.7,'D A T A    S A N T R I',0,1,'C');
$pdf->Cell(0,0.7,'Periode ' . ($y2) . '-' . ($y2+1) ,0,1,'C');

$pdf->ln(1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0.75, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'NIS', 1, 0, 'C');
$pdf->Cell(3.75, 0.8, 'Nama', 1, 0, 'C');
$pdf->Cell(0.75, 0.8, 'LP', 1, 0, 'C');
$pdf->Cell(1.25, 0.8, 'Kls', 1, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Kelahiran', 1, 0, 'C');
$pdf->Cell(8.75, 0.8, 'Alamat', 1, 0, 'C');
$pdf->Cell(2.5, 0.8, 'Wali', 1, 0, 'C');
$pdf->Cell(2.25, 0.8, 'Telp', 1, 0, 'C');
$pdf->Cell(2.5, 0.8, 'Pekerjaan', 1, 1, 'C');
$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas<>'XXX' order by kelas, nama");
while($lihat=mysqli_fetch_array($query)){
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.75, 0.7, $no,1,0, 'C');
	$pdf->Cell(1.5, 0.7, $lihat['nis'],1,0, 'C');
	$pdf->Cell(3.75, 0.7, substr($lihat['nama'],0,20) . "-",1,0, 'L');
	$pdf->Cell(0.75, 0.7, substr($lihat['kelamin'],0,1),1, 0, 'C');
	$pdf->Cell(1.25, 0.7, $lihat['kelas'],1, 0, 'C');
	$pdf->Cell(3.5, 0.7, $lihat['tmp_lahir'] . ", " . $lihat['tgl_lahir'], 1, 0,'L');
	$pdf->Cell(8.75, 0.7, $lihat['alamat'] .", ".$lihat['kec'] .", ".$lihat['kab'], 1, 0,'L');
	$pdf->Cell(2.5, 0.7, substr($lihat['ket_wali'],0,10) . "-", 1, 0,'L');
	$pdf->Cell(2.25, 0.7, $lihat['tlp'], 1, 0,'L');
	$pdf->Cell(2.5, 0.7, $lihat['kerja'], 1, 1,'L');
	$no++;
}

$pdf->Output("data santri.pdf","I");

?>

