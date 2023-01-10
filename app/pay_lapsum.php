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

//$per=$_GET['period'];
$pdf->ln(2.2);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0.7,'REKAP INFAQ PENDAFTARAN DAN BULANAN SANTRI',0,1,'C');
$pdf->Cell(0,0.7,'Update '.date("d M Y"),0,1,'C');
$pdf->ln(0.5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0.7, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'NIS', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama Santri', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Nama Wali', 1, 0, 'C');
$pdf->Cell(2.3, 0.8, 'No. Telp', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Daftar', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Bangunan', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Pendidikan', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Seragam', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'SPP', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Makan', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Asrama', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Jumlah', 1, 1, 'C');

$pdf->SetFont('Arial','',8);
$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE ket_santri<>'-' order by nama");
while($lihat=mysqli_fetch_assoc($query)){
	$ni=$lihat['nis'];
	$pdf->Cell(0.7, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(1.5, 0.8, $ni,1, 0, 'C');
	$pdf->Cell(5, 0.8, substr($lihat['nama'], 0, 30), 1, 0,'L');
	$pdf->Cell(3, 0.8, substr($lihat['ket_wali'], 0, 20), 1, 0,'L');
	$pdf->Cell(2.3, 0.8, $lihat['tlp'], 1, 0,'C');
	
$jml=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $ni .", daftar, 0)) as dft, sum(if(nis=". $ni .", bangunan, 0)) as bgn, sum(if(nis=". $ni .", pendidikan, 0)) as pdd, sum(if(nis=". $ni .", seragam, 0)) as srg, sum(if(nis=". $ni .", spp, 0)) as sp, sum(if(nis=". $ni .", makan, 0)) as mkn, sum(if(nis=". $ni .", lain, 0)) as lin, sum(if(nis=". $ni .", jumlah, 0)) as jm from bayaran");
while($see=mysqli_fetch_assoc($jml)){
	$jum=$see['jm'];
	$pdf->Cell(1.5, 0.8, number_format($see['dft'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($see['bgn'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($see['pdd'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($see['srg'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['sp'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($see['mkn'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($see['lin'],0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($jum,0,'',','), 1, 1,'R');
	$no++;
	
	//$tot=sum($jum);
	//$pdf->Cell(25.5, 0.8, '', 0, 0, 'C');
	//$pdf->Cell(2, 0.8, $tot, 0, 0, 'C');
	
}
}

$pdf->SetFont('Arial','B',8);
$tot=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(daftar) as dft, sum(bangunan) as bgn, sum(pendidikan) as pdd, sum(seragam) as srg, sum(spp) as sp, sum(makan) as mkn, sum(lain) as lin, sum(jumlah) as jml from bayaran");
while($se=mysqli_fetch_assoc($tot)){
	$pdf->Cell(12.5, 0.8, '', 0, 0,'C');
	$pdf->Cell(1.5, 0.8, number_format($se['dft'],0,'',','), 0, 0,'R');
	$pdf->Cell(2, 0.8, number_format($se['bgn'],0,'',','), 0, 0,'R');
	$pdf->Cell(2, 0.8, number_format($se['pdd'],0,'',','), 0, 0,'R');
	$pdf->Cell(2, 0.8, number_format($se['srg'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['sp'],0,'',','), 0, 0,'R');
	$pdf->Cell(2, 0.8, number_format($se['mkn'],0,'',','), 0, 0,'R');
	$pdf->Cell(2, 0.8, number_format($se['lin'],0,'',','), 0, 0,'R');
	$pdf->Cell(2, 0.8, number_format($se['jml'],0,'',','), 0, 1,'R');
	
}

$pdf->Output("pay summary " .date("dmy") .".pdf","I");
?>