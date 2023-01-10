<?php
include 'config.php';
require('../assets/pdf/fpdf.php');
$pdf = new FPDF("L","cm","A4");
	
	$mon=date("m");
	if( $mon >= 7 ){
		$yr=date("Y");
		$sm=1;
		$pr=date("Y") .'-'.date("Y")+1;
	}else{
		$yr=date("Y")-1;
		$sm=2;
		$pr=date("Y")-1 .'-'.date("Y");
	}
	
$pdf->SetMargins(0.5,0.5,0.5);
$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE RIGHT('$yr',2)-LEFT(nis,2)+MID(nis,4,1)='6' order by nama");
while($l=mysqli_fetch_array($query)){

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('../assets/img/syahadah.jpg',0,0,29.7,21); 
if(file_exists('../public/foto/'. $l['panggilan'] . '.jpg')){
	$pdf->Image('../public/foto/'. $l['panggilan'] . '.jpg',6,14,3,4);
	$pdf->Rect(6,13.7,3,4.5);
 }else{
	$pdf->Image('../public/foto/no.png',6,14,3,4);
 }
$pdf->ln(3.5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(28.7, 2, 'NO : '. substr($l['nis'],-3) .'/HABI-YBI/'. str_pad($yr-2017, 2, '0', STR_PAD_LEFT) .'/'. date('Y'), 0, 1, 'C');
$pdf->ln(0.7);
$pdf->SetFont('Arial','',14);
$pdf->Cell(28.7, 0.7, 'Diberikan kepada :',0,1,'C');
$pdf->SetFont('Arial','',35);
$pdf->Cell(28.7, 2, $l['nama'],0,1,'C');
$pdf->SetFont('Arial','',14);
$pdf->Cell(28.7, 0.7, 'Yang telah menyelesaikan pendidikan dasarnya di',0,1,'C');
$pdf->Cell(28.7, 0.7, 'Homeschooling Alquran Bina Insani (HABI) Cikoneng Ciamis Jawa Barat',0,1,'C');
$pdf->Cell(28.7, 0.7, 'Pada Tahun Ajaran '. $yr .'-'. ($yr+1) ,0,1,'C');
$pdf->ln(0.5);
$pdf->Cell(28.7, 0.7, 'Semoga adab yang dipelajari dapat membimbing',0,1,'C');
$pdf->Cell(28.7, 0.7, 'setiap langkahnya dalam menuntut ilmu',0,1,'C');
$pdf->ln(1);
$pdf->Cell(24, 0.7, 'Ciamis, '. date('d M Y'),0,1,'R');
$pdf->Cell(24, 0.7, 'Kepala HABI',0,1,'R');
$pdf->ln(1.5);
$pdf->Cell(24, 0.7, 'Asep Khoerudin Syahid, A.md',0,1,'R');
$no++;
}

$pdf->Output("syahadah.pdf","I");
?>