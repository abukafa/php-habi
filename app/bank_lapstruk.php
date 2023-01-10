<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("P","mm",array(327, 58));

$pdf->SetMargins(1,0,0,0);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/logo.png',18.5,5,20,12.5); 

$pdf->ln(18);
$pdf->SetFont('Arial','',6.5);
$pdf->Cell(55, 5,'HOMESCHOOLING ALQURAN BINA INSANI',"B",1, 'C');
$pdf->Cell(55, 5,'Cikoneng - Ciamis - Jawa Barat',"0",0, 'C');
$pdf->ln(7);

$no=$_GET['no'];
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,5,'TABUNGAN',0,1,'C');
$pdf->SetFont('Arial','B',8);
$santri=mysqli_query($GLOBALS["___mysqli_ston"], "select * from tabungan where no =" . $no );
while($lih=mysqli_fetch_assoc($santri)){
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,4,$lih['tgl'],0,1,'C');
$pdf->Cell(55,4,$lih['nis'],0,1,'C');
$pdf->Cell(55,4,$lih['nama'],0,1,'C');
$pdf->ln(3);
$pdf->Cell(12,4,'',0,0,'R');
$pdf->Cell(15,4,'Debit',0,0,'L');
$pdf->Cell(1,4,':',0,0,'C');
$pdf->Cell(15,4, number_format($lih['debit'],0,'',','),0,1,'R');
$pdf->Cell(12,4,'',0,0,'R');
$pdf->Cell(15,4,'Kredit',0,0,'L');
$pdf->Cell(1,4,':',0,0,'C');
$pdf->Cell(15,4, number_format($lih['kredit'],0,'',','),0,1,'R');
$pdf->Cell(12,4,'',0,0,'R');
$pdf->Cell(15,4,'total',"T",0,'L');
$pdf->Cell(1,4,':',"T",0,'C');
$tot = $lih['debit'] - $lih['kredit'];
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4, number_format($tot,0,'',','),"T",1,'R');

if ( $tot > 0 ){
	$pdf->MultiCell(55, 5, ucwords(Terbilang($tot)) . " Rupiah", 0, 'C');
}

$pdf->ln(3);
$nis=$lih['nis'];
$pdf->SetFont('Arial','',8);
$tot=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $nis .", debit, 0)) as dbt, sum(if(nis=". $nis .", kredit, 0)) as kdt from tabungan");
while($see=mysqli_fetch_assoc($tot)){
	$jml = $see['dbt'] - $see['kdt'];
	$pdf->Cell(55,4,'Saldo : '. number_format($jml,0,'',','), 1, 1,'C');

$pdf->ln(3);
$pdf->Cell(55, 5,'SIMPAN TANDA TERIMA INI',0,1, 'C');
$pdf->Cell(55, 5,'SBG BUKTI TRANSAKSI YANG SAH',"B",1, 'C');
$pdf->Cell(55, 5,'TERIMA KASIH',0,1, 'C');

$pdf->Cell(27.5, 5,'', 0, 0, 'C');
$pdf->Cell(27.5, 5,'Admin :', 0, 1, 'R');
$pdf->Cell(27.5, 5,'', 0, 0, 'C');
$pdf->Cell(27.5, 5, $lih['admin'] , 0, 0, 'R');
}
}
$pdf->Output("struk.pdf","I");
function Terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}
?>

