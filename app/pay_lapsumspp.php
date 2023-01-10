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


$per=$_GET['thn'];
$thn=$per+1;
$pdf->ln(2.2);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0.7,'REKAP INFAQ BULANAN SANTRI PERIODE ' .$per,0,1,'C');
$pdf->Cell(0,0.7,'Update '.date("d M Y"),0,1,'C');
$pdf->ln(0.5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0.7, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(1.8, 0.8, 'NIS', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama Santri', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Jul ' . $per, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Aug ' . $per, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Sep ' . $per, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Oct ' . $per, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Nov ' . $per, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Dec ' . $per, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Jan ' . $thn, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Feb ' . $thn, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Mar ' . $thn, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Apr ' . $thn, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'May ' . $thn, 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Jun ' . $thn, 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Total', 1, 1, 'C');
$pdf->SetFont('Arial','',8);
$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE ket_santri='-' and left(nis,2) <= right('$per',2) order by nama");
while($lihat=mysqli_fetch_assoc($query)){
	$ni=$lihat['nis'];
	$pdf->Cell(0.7, 0.8, $no, 1, 0, 'C');
	$pdf->Cell(1.8, 0.8, $ni,1, 0, 'C');
	$pdf->Cell(5, 0.8, substr($lihat['nama'], 0, 30), 1, 0,'L');

$jml=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(bln='Jul-$per', spp, 0)) as jul, sum(if(bln='Aug-$per', spp, 0)) as aug, sum(if(bln='Sep-$per', spp, 0)) as sep, sum(if(bln='Oct-$per', spp, 0)) as oct, sum(if(bln='Nov-$per', spp, 0)) as nov, sum(if(bln='Dec-$per', spp, 0)) as des, sum(if(bln='Jan-$thn', spp, 0)) as jan, sum(if(bln='Feb-$thn', spp, 0)) as feb, sum(if(bln='Mar-$thn', spp, 0)) as mar, sum(if(bln='Apr-$thn', spp, 0)) as apr, sum(if(bln='May-$thn', spp, 0)) as may, sum(if(bln='Jun-$thn', spp, 0)) as jun from bayaran where nis ='$ni' ");
while($see=mysqli_fetch_array($jml)){
	$pdf->Cell(1.5, 0.8, number_format($see['jul'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['aug'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['sep'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['oct'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['nov'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['des'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['jan'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['feb'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['mar'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['apr'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['may'],0,'',','), 1, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($see['jun'],0,'',','), 1, 0,'R');
	$jum = $see['jul'] + $see['aug'] + $see['sep'] + $see['oct'] + $see['nov'] + $see['des'] + $see['jan'] + $see['feb'] + $see['mar'] + $see['apr'] + $see['may'] + $see['jun'] ;
	$pdf->Cell(2, 0.8, number_format($jum,0,'',','), 1, 1,'R');
	$no++;
	
	//$tot=sum($jum);
	//$pdf->Cell(25.5, 0.8, '', 0, 0, 'C');
	//$pdf->Cell(2, 0.8, $tot, 0, 0, 'C');
	
}
}

$pdf->SetFont('Arial','B',8);
$ijml=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(bln='Jul-$per', spp, 0)) as jul, sum(if(bln='Aug-$per', spp, 0)) as aug, sum(if(bln='Sep-$per', spp, 0)) as sep, sum(if(bln='Oct-$per', spp, 0)) as oct, sum(if(bln='Nov-$per', spp, 0)) as nov, sum(if(bln='Dec-$per', spp, 0)) as des, sum(if(bln='Jan-$thn', spp, 0)) as jan, sum(if(bln='Feb-$thn', spp, 0)) as feb, sum(if(bln='Mar-$thn', spp, 0)) as mar, sum(if(bln='Apr-$thn', spp, 0)) as apr, sum(if(bln='May-$thn', spp, 0)) as may, sum(if(bln='Jun-$thn', spp, 0)) as jun from bayaran");
while($se=mysqli_fetch_array($ijml)){
	$pdf->Cell(7.5, 0.8, '', 0, 0, 'C');
	$pdf->Cell(1.5, 0.8, number_format($se['jul'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['aug'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['sep'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['oct'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['nov'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['des'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['jan'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['feb'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['mar'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['apr'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['may'],0,'',','), 0, 0,'R');
	$pdf->Cell(1.5, 0.8, number_format($se['jun'],0,'',','), 0, 0,'R');
	$jum = $se['jul'] + $se['aug'] + $se['sep'] + $se['oct'] + $se['nov'] + $se['des'] + $se['jan'] + $se['feb'] + $se['mar'] + $se['apr'] + $se['may'] + $se['jun'] ;
	$pdf->Cell(2, 0.8, number_format($jum,0,'',','), 0, 1,'R');
	
}

$pdf->Output("pay summary " .date("dmy") .".pdf","I");
?>