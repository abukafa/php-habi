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

$thn=$_GET['thn'];
$smt=$_GET['smt'];
	$ajr= $thn + 1;
	if ($smt == 1){
		$sem = 'GANJIL';
		}
		else{
		$sem = 'GENAP';
		}		
$pdf->ln(2.5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0.5,'I N D E X    N I L A I',0,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,0.5,'Periode '. $thn ." - ". $ajr ,0,1,'C');
$pdf->Cell(0,0.5,'Semester '. $sem ,0,1,'C');

$pdf->ln(1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(1, 1.6, 'NO', 1, 0, 'C');
$pdf->Cell(5.5, 1.6, 'Nama', 1, 0, 'C');
$pdf->Cell(1.5, 1.6, 'Kelas', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Muatan Khusus', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Murofaqot', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Penunjang', 1, 0, 'C');
$pdf->Cell(1.5, 1.6, 'Rata-rata', 1, 1, 'C');
$pdf->ln(-0.8);
$pdf->Cell(1, 0.8, '', 0, 0, 'C');
$pdf->Cell(5.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(1.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(1, 0.8, 'Pmh', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Skp', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Tlq', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Tfd', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Tsn', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Ktb', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Thd', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Ibd', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Bca', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Bht', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Sai', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Sos', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Hds', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Ksh', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Arb', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Eng', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Olr', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Lfs', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, '', 0, 1, 'C');
$pdf->ln(0.1);
$no=1;
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where kelas<>'XXX' order by kelas, nama");
while($lihat=mysqli_fetch_array($query)){
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1, 0.7, $no,1,0, 'C');
	$pdf->Cell(5.5, 0.7, ' ' . $lihat['nama'],1, 0, 'L');
	$pdf->Cell(1.5, 0.7, $lihat['kelas'],1, 0, 'C');
	$nis=$lihat['nis'];
	$nil=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(left(materi, 4)='1.1.', angka, 0)) as '11', sum(if(left(materi, 4)='1.2.', angka, 0)) as '12', sum(if(left(materi, 4)='1.3.', angka, 0)) as '13', sum(if(left(materi, 4)='1.4.', angka, 0)) as '14', sum(if(left(materi, 4)='1.5.', angka, 0)) as '15', sum(if(left(materi, 4)='1.6.', angka, 0)) as '16', sum(if(left(materi, 4)='2.1.', angka, 0)) as '21', sum(if(left(materi, 4)='2.2.', angka, 0)) as '22', sum(if(left(materi, 4)='2.3.', angka, 0)) as '23', sum(if(left(materi, 4)='2.4.', angka, 0)) as '24', sum(if(left(materi, 4)='2.5.', angka, 0)) as '25', sum(if(left(materi, 4)='2.6.', angka, 0)) as '26', sum(if(left(materi, 4)='3.1.', angka, 0)) as '31', sum(if(left(materi, 4)='3.2.', angka, 0)) as '32', sum(if(left(materi, 4)='3.3.', angka, 0)) as '33', sum(if(left(materi, 4)='3.4.', angka, 0)) as '34', sum(if(left(materi, 4)='3.5.', angka, 0)) as '35', sum(if(left(materi, 4)='3.6.', angka, 0)) as '36' from nilai where nis='$nis' and smt='$smt' and thn='$thn'");
					if($nil === false) {
						die(mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				while($nl=mysqli_fetch_array($nil)){
	$pdf->Cell(1, 0.7, $nl['11'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['12'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['13'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['14'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['15'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['16'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['21'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['22'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['23'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['24'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['25'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['26'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['31'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['32'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['33'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['34'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['35'], 1, 0,'C');
	$pdf->Cell(1, 0.7, $nl['36'], 1, 0,'C');
}
	$nilai=mysqli_query($GLOBALS["___mysqli_ston"], "select AVG(angka) as avgnil from nilai where nis='$nis' and smt='$smt' and thn='$thn' order by avgnil");
					if($nilai === false) {
						die(mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				while($n=mysqli_fetch_array($nilai)){
	$pdf->Cell(1.5, 0.7, number_format($n['avgnil'],2), 1, 1,'C');
	$no++;
}
}

$pdf->Output("Index.pdf","I");
?>
