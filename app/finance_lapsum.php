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

$ahr=$_GET['tgl_ahir'];
$d1=date_create($ahr);
$m=date_format($d1, 'm');
if ($m >= 07 and $m <= 12) {
$y2=date_format($d1, 'Y');
}else{
$y2=date_format($d1, 'Y')-1;
}
$p1=$y2 . '-07-01';
$p2=$y2+1 . '-06-30';
$pdf->ln(2.2);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0.7,'ALOKASI KAS BENDAHARA',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0.7,'Periode ' . ($y2) . '-' . ($y2+1) ,0,1,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(11, 1.6, 'IURAN & INFAQ SANTRI', 1, 0,'C');
$pdf->Cell(2.6, 0.8, 'Daftar', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, 'Bangunan', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, 'Pendidikan', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, 'Seragam', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, 'SPP', 1, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Jumlah', 1, 1, 'C');
$pdf->SetFont('Arial','B',9);
$tot=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(daftar) as dft, sum(bangunan) as bgn, sum(pendidikan) as pdd, sum(seragam) as srg, sum(spp) as sp, sum(makan) as mkn, sum(lain) as lin, sum(jumlah) as jml from bayaran where thn='$y2'");
while($see=mysqli_fetch_assoc($tot)){
	$pdf->Cell(11, 0.8, '', 0, 0,'C');
	$pdf->Cell(2.6, 0.8, number_format($see['dft'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($see['bgn'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($see['pdd'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($see['srg'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($see['sp'],0,'',','), 1, 0,'R');
	$ijml = $see['dft'] + $see['bgn'] + $see['pdd'] + $see['srg'] + $see['sp'];
	$pdf->Cell(3.5, 0.8, number_format($ijml,0,'',','), 1, 1,'R');

$query=mysqli_query($GLOBALS["___mysqli_ston"], "select vendor, sum(if(akun='777199', debit, 0)) as dbt, sum(if(akun='000221', kredit, 0)) as adm, sum(if(akun='000222', kredit, 0)) as pba, sum(if(akun='000223', kredit, 0)) as pdd, sum(if(akun='000224', kredit, 0)) as srg, sum(if(akun='000225', kredit, 0)) as pbi, sum(if(akun='000226', kredit, 0)) as dpr, sum(if(akun='000227', kredit, 0)) as ifq, sum(if(akun='000228', kredit, 0)) as lin from finance where tgl between '$p1' and '$p2'");
while($lih=mysqli_fetch_array($query)){

	
$pdf->ln(0.5);
$pdf->SetFont('Arial','',9);

$pdf->Cell(11, 0.8, 'INFAQ DAN PEMASUKAN LAIN-LAIN ', 1, 0,'C');
$pdf->Cell(16.5, 0.8, number_format($lih['dbt'],0,'',','), 1, 1,'R');

$pdf->ln(0.5);
$pdf->Cell(11, 1.6, 'TOTAL PENGELUARAN', 1, 0,'C');
$pdf->Cell(2.6, 0.8, '000221', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, '000222', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, '000223', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, '000224', 1, 0, 'C');
$pdf->Cell(2.6, 0.8, '000225', 1, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Jumlah', 1, 1, 'C');

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(11, 0.8, '', 0, 0,'C');
	$pdf->Cell(2.6, 0.8, number_format($lih['adm'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($lih['pba'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($lih['pdd'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($lih['srg'],0,'',','), 1, 0,'R');
	$pdf->Cell(2.6, 0.8, number_format($lih['pbi'],0,'',','), 1, 0,'R');
	$jum = $lih['adm'] + $lih['pba'] + $lih['pdd'] + $lih['srg'] + $lih['pbi'];
	$pdf->Cell(3.5, 0.8, number_format($jum, 0, '', ','), 1, 1,'R');

	$pdf->ln(1);
	$pdf->Cell(11, 0.8, 'SALDO AKHIR', 1, 0,'C');
	$dft = $see['dft'] - $lih['adm'];
	$pdf->Cell(2.6, 0.8, number_format($dft,0,'',','), 1, 0,'R');
	$bgn = $see['bgn'] - $lih['pba'];
	$pdf->Cell(2.6, 0.8, number_format($bgn,0,'',','), 1, 0,'R');
	$pdd = $see['pdd'] - $lih['pdd'];
	$pdf->Cell(2.6, 0.8, number_format($pdd,0,'',','), 1, 0,'R');
	$srg = $see['srg'] - $lih['srg'];
	$pdf->Cell(2.6, 0.8, number_format($srg,0,'',','), 1, 0,'R');
	$sp = $see['sp'] - $lih['pbi'];
	$pdf->Cell(2.6, 0.8, number_format($sp,0,'',','), 1, 0,'R');
	$jml = $lih['dbt'] + $ijml - $jum;
	$pdf->Cell(3.5, 0.8, number_format($jml,0,'',','), 1, 1,'R');

}
}

$pdf->ln(1.5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(9.5, 0.5, '', 0, 0, 'C');
$pdf->Cell(8.5, 0.5, '', 0, 0, 'C');
$pdf->Cell(9.5, 0.5,"Ciamis, ".date("d M Y"), 0, 1, 'C');
$pdf->Cell(9.5, 0.5,'Kepala', 0, 0, 'C');
$pdf->Cell(8.5, 0.5, '', 0, 0, 'C');
$pdf->Cell(9.5, 0.5,'Bag. Bendahara', 0, 1, 'C');
$pdf->ln(1.5);
$pdf->Cell(9.5, 0.5,'____________________', 0, 0, 'C');
$pdf->Cell(8.5, 0.5, '', 0, 0, 'C');
$pdf->Cell(9.5, 0.5,'____________________', 0, 1, 'C');

$pdf->Output("alokasi ". date("dmy") .".pdf","I");

?>

