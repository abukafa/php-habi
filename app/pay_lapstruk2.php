<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("P","mm",array(147, 58));

$pdf->SetMargins(1,0,0,0);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/logo.png',18.5,2,20,12.5); 

$pdf->ln(15);
$pdf->SetFont('Arial','',6.5);
$pdf->Cell(55, 5,'HOMESCHOOLING ALQURAN BINA INSANI',"B",1, 'C');
$pdf->Cell(55, 5,'Cikoneng - Ciamis - Jawa Barat',"0",0, 'C');

$no=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['no']);
$det=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bayaran where no='$no'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($lihat=mysqli_fetch_array($det)){
$fak=$lihat['no'];
$fak=sprintf('%04d' , $fak);
$pdf->ln(7);
$pdf->SetFont('Arial','',12);
$pdf->Cell(55, 5,'STRUK PEMBAYARAN',0,1, 'C');
$pdf->ln(2);
$pdf->SetFont('Arial','',8);
$pdf->Cell(27.5, 5,'No Faktur : ' . $fak,"T,B",0, 'C');
$pdf->Cell(27.5, 5,'Tgl : ' . $lihat['tgl'],"T,B",1, 'C');
$pdf->Cell(55, 5,'NIS : ' . $lihat['nis'],0,1, 'C');
$pdf->Cell(55, 5, $lihat['nama'],0,1, 'C');
$pdf->Cell(55, 5,'Wali : ' . $lihat['wali'], "B", 1, 'C');
$pdf->Cell(55, 5, 'DAFTAR ULANG ' . $lihat['thn'],"B",1, 'C');
$pdf->Cell(27, 5,'Pendaftaran' ,0,0, 'L');
$pdf->Cell(1, 5,' : Rp.',0,0, 'L');
$pdf->Cell(27, 5,number_format($lihat['daftar']),0,1, 'R');
$pdf->Cell(27, 5,'Bangunan' ,0,0, 'L');
$pdf->Cell(1, 5,' : Rp.',0,0, 'L');
$pdf->Cell(27, 5,number_format($lihat['bangunan']),0,1, 'R');
$pdf->Cell(27, 5,'Pendidikan' ,0,0, 'L');
$pdf->Cell(1, 5,' : Rp.',0,0, 'L');
$pdf->Cell(27, 5,number_format($lihat['pendidikan']),0,1, 'R');
$pdf->Cell(27, 5,'Seragam' ,"B",0, 'L');
$pdf->Cell(1, 5,' : Rp.',"B",0, 'L');
$pdf->Cell(27, 5,number_format($lihat['seragam']),"B",1, 'R');
$pdf->Cell(55, 5, 'BULAN ' . $lihat['bln'],"B",1, 'C');
$pdf->Cell(27, 5,'SPP' ,0,0, 'L');
$pdf->Cell(1, 5,' : Rp.',0,0, 'L');
$pdf->Cell(27, 5,number_format($lihat['spp']),0,1, 'R');
$pdf->Cell(27, 5,'Makan' ,0,0, 'L');
$pdf->Cell(1, 5,' : Rp.',0,0, 'L');
$pdf->Cell(27, 5,number_format($lihat['makan']),0,1, 'R');
$pdf->Cell(27, 5,'Lain-lain' ,"B",0, 'L');
$pdf->Cell(1, 5,' : Rp.',"B",0, 'L');
$pdf->Cell(27, 5,number_format($lihat['lain']),"B",1, 'R');
$pdf->Cell(27, 5,'TOTAL' ,"B",0, 'L');
$pdf->Cell(1, 5,' : Rp.',"B",0, 'L');
$pdf->Cell(27, 5,number_format($lihat['jumlah']),"B",1, 'R');
$pdf->MultiCell(55, 5, ucwords(Terbilang($lihat['jumlah'])) . " Rupiah", 0, 'C');

$pdf->ln(1);
$pdf->Cell(55, 5,'SIMPAN TANDA TERIMA INI',0,1, 'C');
$pdf->Cell(55, 5,'SBG BUKTI PEMBAYARAN YANG SAH',"B",1, 'C');

$pdf->Cell(27.5, 5,'', 0, 0, 'C');
$pdf->Cell(27.5, 5,'Admin : ' . $lihat['admin'] , 0, 1, 'R');

$pdf->Output("struk". substr($lihat['nama'],0,3) . $fak .".pdf","I");
}
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

