<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("P","cm","A4");

$pdf->SetMargins(1,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/kop.png',1,0.6,15,1.5); 
$pdf->Line(1,2.2,20,2.2);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,2.3,20,2.3);   
$pdf->SetLineWidth(0);

$awl=$_GET['tgl_awal'];
$ahr=$_GET['tgl_ahir'];
$pdf->ln(1.7);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0.7,'D A T A   T A B U N G A N   S A N T R I',0,1,'C');
$pdf->Cell(0,0.7,$awl . ' s.d. ' . $ahr,0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0.7, 0.7, 'No', 1, 0, 'C');
$pdf->Cell(2, 0.7, 'Tanggal', 1, 0, 'C');
$pdf->Cell(1.8, 0.7, 'NIS', 1, 0, 'C');
$pdf->Cell(5.5, 0.7, 'Nama Santri', 1, 0, 'C');
$pdf->Cell(2, 0.7, 'Nama Wali', 1, 0, 'C');
$pdf->Cell(2, 0.7, 'Debit', 1, 0, 'C');
$pdf->Cell(2, 0.7, 'Kredit', 1, 0, 'C');
$pdf->Cell(3, 0.7, 'Admin', 1, 1, 'C');

$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from tabungan where tgl between '$awl' and '$ahr' order by tgl");
while($lihat=mysqli_fetch_assoc($query)){
$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.7, 0.7, $no,1, 0, 'C');
	$pdf->Cell(2, 0.7, $lihat['tgl'],1, 0, 'C');
	$pdf->Cell(1.8, 0.7, $lihat['nis'],1, 0, 'C');
	$pdf->Cell(5.5, 0.7, substr($lihat['nama'], 0, 20), 1, 0,'L');
	$pdf->Cell(2, 0.7, substr($lihat['wali'], 0, 10), 1, 0,'L');
	$pdf->Cell(2, 0.7, number_format($lihat['debit'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.7, number_format($lihat['kredit'],0,'',','), 1, 0,'R');
	$pdf->Cell(3, 0.7, $lihat['admin'], 1, 1,'R');
	$no++;
}

$pdf->ln(0.25);
$pdf->SetFont('Arial','B',8);
$tot=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(debit) as dbt, sum(kredit) as kdt from tabungan where tgl between '$awl' and '$ahr' ");
while($see=mysqli_fetch_assoc($tot)){
	$pdf->Cell(12, 0.8, '', 0, 0,'C');
	$pdf->Cell(2, 0.8, number_format($see['dbt'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($see['kdt'],0,'',','), 1, 0,'R');
	$jml = $see['dbt'] - $see['kdt'];
	$pdf->Cell(3, 0.8, number_format($jml,0,'',','), 1, 1,'R');
}

$pdf->Output("bank history ". $awl . "-" . $ahr .".pdf","I");

?>
