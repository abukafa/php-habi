<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("P","mm",array(3276, 58));

$pdf->SetMargins(1,0,0,0);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/kop.png',18.5,5,20,12.5); 

$pdf->ln(18);
$pdf->SetFont('Arial','',6.5);
$pdf->Cell(55, 5,'HOMESCHOOLING ALQURAN BINA INSANI',"B",1, 'C');
$pdf->Cell(55, 5,'Cikoneng - Ciamis - Jawa Barat',"0",0, 'C');
$pdf->ln(10);

$nis=$_GET['nis'];
$pdf->ln(0.75);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,5,'MUTASI TABUNGAN',0,1,'R');
$pdf->SetFont('Arial','B',8);
$santri=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where nis =" . $nis );
while($lih=mysqli_fetch_assoc($santri)){
$pdf->Cell(55,5,'Nomor Induk : ' . $nis,0,1,'R');
$pdf->Cell(55,5,'Nama : ' . $lih['nama'],0,1,'R');
$pdf->Cell(55,5,'Wali : ' . $lih['ket_wali'],0,1,'R');
}
$pdf->ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(5, 5, 'No', 1, 0, 'C');
$pdf->Cell(16, 5, 'Tgl', 1, 0, 'C');
$pdf->Cell(17, 5, 'Debit', 1, 0, 'C');
$pdf->Cell(17, 5, 'Kredit', 1, 1, 'C');

$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from tabungan where nis =" . $nis . "order by tgl asc");
while($lihat=mysqli_fetch_assoc($query)){
	$pdf->Cell(5, 5, $no,1,0, 'C');
	$pdf->Cell(16, 5, $lihat['tgl'],1, 0, 'C');
	$pdf->Cell(17, 5, number_format($lihat['debit'],0,'',','), 1, 0,'R');
	$pdf->Cell(17, 5, number_format($lihat['kredit'],0,'',','), 1, 1,'R');
	$no++;
}
$pdf->SetFont('Arial','B',8);
$tot=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $nis .", debit, 0)) as dbt, sum(if(nis=". $nis .", kredit, 0)) as kdt from tabungan");
while($see=mysqli_fetch_assoc($tot)){
	$pdf->Cell(21, 5, '', 0, 0,'C');
	$pdf->Cell(17, 5, number_format($see['dbt'],0,'',','), 1, 0,'R');
	$pdf->Cell(17, 5, number_format($see['kdt'],0,'',','), 1, 1,'R');
	$jml = $see['dbt'] - $see['kdt'];
	$pdf->Cell(55, 5, number_format($jml,0,'',','), 0, 1,'R');
}

$pdf->Output("struk.pdf","I");

?>

