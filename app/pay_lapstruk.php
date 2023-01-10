<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("L","cm",array(13.75,21));

$pdf->SetMargins(1,0,0,0);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/kop.png',1,0.6,15,1.5); 
$pdf->Line(1,2.2,20,2.2);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,2.3,20,2.3);   
$pdf->SetLineWidth(0);

$pdf->ln(2.5);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(19,0.7,"STRUK PEMBAYARAN",0,1,'C');
$pdf->ln(-0.25);

$no=1;
$no=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['no']);
$det=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bayaran where no='$no'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($lihat=mysqli_fetch_array($det)){
$fak=$lihat['no'];
$fak=sprintf('%04d' , $fak);
$pdf->SetFont('Arial','',10);
$pdf->Cell(3, 0.7, 'No. Faktur : ' . $fak,1,0, 'C');
$pdf->Cell(13, 0.7, '',0,0, 'L');
$pdf->Cell(3, 0.7, 'Tgl : ' . $lihat['tgl'], 1, 1, 'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(6, 0.7, 'Nomor Induk Santri : ' . $lihat['nis'],0,0, 'L');
$pdf->Cell(7, 0.7, 'Nama : ' . $lihat['nama'],0,0, 'C');
$pdf->Cell(6, 0.7, 'Wali : ' . $lihat['wali'], 0, 1, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(9.5, 0.7, 'DAFTAR ULANG ' . $lihat['thn'],1,0, 'C');
$pdf->Cell(9.5, 0.7, 'BULANAN ' . $lihat['bln'], 1, 1, 'C');
$pdf->Cell(0.5, 0.6, '', 0, 0, 'C');
$pdf->Cell(4.5, 0.6, 'Pendaftaran', 0, 0, 'L');
$pdf->Cell(4, 0.6, number_format($lihat['daftar'],0,'',','), 0, 0,'R');
$pdf->Cell(1, 0.6, '', 0, 0, 'C');
$pdf->Cell(4.5, 0.6, 'SPP', 0, 0, 'L');
$pdf->Cell(4, 0.6, number_format($lihat['spp'],0,'',','), 0, 0,'R');
$pdf->Cell(0.5, 0.6, '', 0, 1, 'C');

$pdf->Cell(0.5, 0.6, '', 0, 0, 'C');
$pdf->Cell(4.5, 0.6, 'Infaq Bangunan', 0, 0, 'L');
$pdf->Cell(4, 0.6, number_format($lihat['bangunan'],0,'',','), 0, 0,'R');
$pdf->Cell(1, 0.6, '', 0, 0, 'C');
$pdf->Cell(4.5, 0.6, 'Iuran Makan', 0, 0, 'L');
$pdf->Cell(4, 0.6,number_format($lihat['makan'],0,'',','), 0, 0,'R');
$pdf->Cell(0.5, 0.6, '', 0, 1, 'C');

$pdf->Cell(0.5, 0.6, '', 0, 0, 'C');
$pdf->Cell(4.5, 0.6, 'Infaq Pendidikan', 0, 0, 'L');
$pdf->Cell(4, 0.6, number_format($lihat['pendidikan'],0,'',','), 0, 0,'R');
$pdf->Cell(1, 0.6, '', 0, 0, 'C');
$pdf->Cell(4, 0.6, 'Lain lain', 0, 0, 'L');
$pdf->Cell(4.5, 0.6,number_format($lihat['lain'],0,'',','), 0, 0,'R');
$pdf->Cell(0.5, 0.6, '', 0, 1, 'C');

$pdf->Cell(0.5, 0.6, '', 0, 0, 'C');
$pdf->Cell(4.5, 0.6, 'Iuran Seragam', 0, 0, 'L');
$pdf->Cell(4, 0.6, number_format($lihat['seragam'],0,'',','), 0, 0,'R');
$pdf->Cell(1, 0.6, '', 0, 0, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(8.5, 0.6, 'Ket : ' .$lihat['ket'], 0, 0, 'R');
$pdf->Cell(0.5, 0.6, '', 0, 1, 'C');

$pdf->Cell(19, 0.7,"JUMLAH :   ". number_format($lihat['jumlah'],0,'',','),1,1, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(19, 0.7, ucwords(Terbilang($lihat['jumlah'])) . " Rupiah", 1, 1, 'C');
$no++;


$pdf->Image('../assets/img/jaza.png',9.5,10,2.25,1);

$pdf->SetFont('Arial','',9);
$pdf->Cell(19, 0.3, '', 0, 1, 'C');
$pdf->Cell(9.5, 0.4, '', 0, 0, 'C');
$pdf->Cell(9.5, 0.4,"Ciamis, ".date("d M Y"), 0, 1, 'C');
$pdf->Cell(9.5, 0.4,'Sudah Terima dari', 0, 0, 'C');
$pdf->Cell(9.5, 0.4,'Admin', 0, 1, 'C');

$pdf->ln(1.25);
$pdf->Cell(9.5, 0.5,'', 0, 0, 'C');
$pdf->Cell(9.5, 0.5, $lihat['admin'] , 0, 0, 'C');
}
$pdf->Line(4,11.7,7.5,11.7);
$pdf->Line(13.5,11.7,17,11.7);

$pdf->Output("struk-" . $fak . ".pdf","I");

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

