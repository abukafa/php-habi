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
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55, 4, "TRANSAKSI" ,0,1, 'C');
$pdf->SetFont('Arial','',7);
$pdf->Cell(55, 4, date("d/m/Y g:i a") ,0,1, 'C');

$inv=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['inv']);
$det=mysqli_query($GLOBALS["___mysqli_ston"], "select * from finance where inv='$inv'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($lihat=mysqli_fetch_array($det)){

$no=1;
$pdf->Cell(14, 4,$lihat['tgl'],0,0, 'L');
$pdf->Cell(10, 4,$lihat['akun'],0,0, 'L');
$pdf->Cell(27.5, 4,$lihat['vendor'],0,1, 'L');
$pdf->Cell(27.5, 4,$lihat['uraian'],0,0, 'L');
$tot = $lihat['kredit'] - $lihat['debit'];
$pdf->Cell(27.5, 4, number_format($tot,0,'',','),0,1,'R');
$no++;
}
$de=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(kredit) as kdt, sum(debit) as dbt from finance where inv='$inv'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($lih=mysqli_fetch_array($de)){

$pdf->ln(3);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(27.5, 5,'Total',"T",0, 'L');
$to = $lih['kdt'] - $lih['dbt'];
$pdf->Cell(27.5, 5, number_format($to,0,'',','),"T",1,'R');
$pdf->MultiCell(55, 5, ucwords(Terbilang($to)) . " Rupiah", 0, 'R');
}

$pdf->ln(5);
$pdf->SetFont('Arial','',7);
$pdf->Cell(55, 3,'SIMPAN TANDA TERIMA INI',0,1, 'C');
$pdf->Cell(55, 5,'SBG BUKTI TRANSAKSI YANG SAH',"B",1, 'C');
$pdf->Cell(55, 5,'TERIMA KASIH',0,1, 'C');

$pdf->ln(1);
$pdf->Cell(27.5, 5,'', 0, 0, 'C');
$pdf->Cell(27.5, 5,'Penerima', 0, 1, 'R');
$pdf->ln(5);
$pdf->Cell(27.5, 5,'', 0, 0, 'C');
$pdf->Cell(27.5, 5, '' , "B", 0, 'R');

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