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

$y=$_GET['thn'];
$yr = substr($y,1,4);
$pdf->ln(2.2);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0.7,'PAYMENT OUTSTANDING PERIODE ' . $yr,0,1,'C');
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

$no=1;
$query1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE left(nis,2)<=right($yr,2) and ket_santri='-' order by left(nis,2), nama");
while($lihat=mysqli_fetch_array($query1)){
	$ni=$lihat['nis'];
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.7, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(1.5, 0.8, $ni,1, 0, 'C');
	$pdf->Cell(5, 0.8, substr($lihat['nama'], 0, 30), 1, 0,'L');
	$pdf->Cell(3, 0.8, substr($lihat['ket_wali'], 0, 20), 1, 0,'L');
	$pdf->Cell(2.3, 0.8, $lihat['tlp'], 1, 0,'C');
	
$query2=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $ni .", daftar, 0)) as dft, sum(if(nis=". $ni .", bangunan, 0)) as bgn, sum(if(nis=". $ni .", pendidikan, 0)) as pdd, sum(if(nis=". $ni .", seragam, 0)) as srg, sum(if(nis=". $ni .", spp, 0)) as sp, sum(if(nis=". $ni .", makan, 0)) as mkn, sum(if(nis=". $ni .", lain, 0)) as lin, sum(if(nis=". $ni .", jumlah, 0)) as jm from bayaran where thn=" . $y ."and nis =" . $ni);
while($see=mysqli_fetch_array($query2)){

$date = date("Y-m-d");	//tgl sekarang
$y = $_GET['thn'];		//tgl yang diipilih
$yr = substr($y,1,4);
$taun = substr($y,1,4) . '-07-01';
$tahr = substr($y,1,4)+1 . '-06-30';
$timeStart = strtotime("$taun");
if ( $date > $tahr ){
	$timeEnd = strtotime("$tahr");
}else{
	$timeEnd = strtotime("$date");
}
// Menambah bulan ini + semua bulan pada tahun sebelumnya
$numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
// menghitung selisih bulan
$numBulan += date("m",$timeEnd)-date("m",$timeStart);
	
$query3=mysqli_query($GLOBALS["___mysqli_ston"], "select * from exception where thn=" . $y ."and nis =" . $ni);
while($exc=mysqli_fetch_array($query3)){	

$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from beban where thn=" . $y ."and nis =" . $ni);
while($leh=mysqli_fetch_array($query)){

	$tdft=$leh['daftar']-($see['dft']+$exc['daftar']);
	$tbgn=$leh['bangunan']-($see['bgn']+$exc['bangunan']);
	$tpdd=$leh['pendidikan']-($see['pdd']+$exc['pendidikan']);
	$tsrg=$leh['seragam']-($see['srg']+$exc['seragam']);
	$tspp=($numBulan*$leh['spp'])-($see['sp']+$exc['spp']);
	$tmkn=($numBulan*$leh['makan'])-($see['mkn']+$exc['makan']);
	$tlin=($numBulan*$leh['asrama'])-($see['lin']+$exc['asrama']);
	$tjml=$tdft+$tbgn+$tpdd+$tsrg+$tspp+$tmkn+$tlin;	
	
	$pdf->Cell(1.5, 0.8, number_format($tdft,0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($tbgn,0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($tpdd,0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($tsrg,0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($tspp,0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($tmkn,0,'',','), 1, 0,'R');
	$pdf->Cell(2, 0.8, number_format($tlin,0,'',','), 1, 0,'R');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(2, 0.8, number_format($tjml,0,'',','), 1, 1,'R');
	$no++;
		
}	
}	
}	
}

$pdf->Output("outstanding ". date("dmy") .".pdf","I");
?>
