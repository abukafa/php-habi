<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("P","cm","A4");
$nis=$_GET['id'];
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where nis=" . $nis);

$pdf->SetMargins(1,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/kop.png',1,0.6,20,2); 
$pdf->Line(1,2.7,20,2.7);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,2.8,20,2.8);   
$pdf->SetLineWidth(0);

$pdf->ln(2.2);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(19,0.7,"D A T A   S A N T R I",0,10,'C');
$pdf->ln(0.3);

$no=1;
$nis=$_GET['id'];
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where nis=" . $nis);
while($lihat=mysqli_fetch_array($query)){

if(file_exists('../public/foto/'. $lihat['panggilan'] . '.jpg')){
	$pdf->Image('../public/foto/'. $lihat['panggilan'] . '.jpg',1.3,5,3,4.5);
 }else{
	$pdf->Image('../public/foto/no.png',1.3,5.5,3,4);
}

$pdf->SetFont('Arial','',10);
$pdf->Cell(4, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, 'Nomor Induk', 0, 0, 'L');
$pdf->Cell(12, 0.8,": " . $lihat['nis'],0, 1, 'L');
$pdf->Cell(4, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, 'Nama Lengkap', 0, 0, 'L');
$pdf->Cell(12, 0.8,": " . $lihat['nama'],0, 1, 'L');
$pdf->Cell(4, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, 'Nama Panggilan', 0, 0, 'L');
$pdf->Cell(12, 0.8,": " . $lihat['panggilan'],0, 1, 'L');
$pdf->Cell(4, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, 'Jenis Kelamin', 0, 0, 'L');
$pdf->Cell(12, 0.8,": " . $lihat['kelamin'], 0, 1,'L');
$pdf->Cell(4, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, 'Kelas', 0, 0, 'L');
$pdf->Cell(12, 0.8,": " . $lihat['kelas'], 0, 1,'L');
$pdf->Cell(4, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, 'Tempat Tgl Lahir', 0, 0, 'L');
$pdf->Cell(12, 0.8,": " . $lihat['tmp_lahir'] . ",  pada Tanggal " . $lihat['tgl_lahir'], 0, 1,'L');
$pdf->Cell(4, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, 'Status Keluarga', 0, 0, 'L');
$pdf->Cell(12, 0.8,": " . $lihat['status_kel'] . ",  Anak ke " . $lihat['anak_ke'] . "  dari  " . $lihat['jml_sdr'] . " Bersaudara ", 0, 1,'L');
$pdf->ln(0.25);
$pdf->Cell(19, 1, 'ALAMAT LENGKAP', 1, 1, 'C');
$pdf->Cell(19, 0.8,$lihat['alamat'] ."  " . $lihat['dusun'], 0, 1,'C');
$pdf->Cell(19, 0.8,"Desa. " . $lihat['desa'] . "  Kec. " . $lihat['kec'] . "  Kab. " . $lihat['kab'] . "  Kode pos. " . $lihat['kpos'], 0, 1,'C');
$pdf->ln(0.25);
$pdf->Cell(9.5, 1, 'BAKAT DAN MINAT',1,0, 'C');
$pdf->Cell(9.5, 1, 'KETERANGAN FISIK', 1, 1, 'C');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Hobi', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['hobi'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Tinggi Badan', 0, 0, 'L');
$pdf->Cell(6.5, 0.8,": " . $lihat['tinggi'] . " cm", 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Olah raga yg disuka', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['olah_raga'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Berat Badan', 0, 0, 'L');
$pdf->Cell(6.5, 0.8,": " . $lihat['berat'] . " Kg", 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Pelajaran yg disuka', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " , 0, 0,'L');
$pdf->Cell(3, 0.8, 'Jarak ke Sekolah', 0, 0, 'L');
$pdf->Cell(6.5, 0.8,": " . $lihat['jarak'], 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Prestasi yg diraih', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['prestasi'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Waktu tempuh', 0, 0, 'L');
$pdf->Cell(6.5, 0.8,": " . $lihat['waktu'], 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Cita-cita', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['cita'], 0, 1,'L');
$pdf->ln(0.25);
$pdf->Cell(19, 1, 'DATA ORANG TUA/ WALI', 1, 1, 'C');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Nama Ayah', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['ayah'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Nama Ibu', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['ibu'], 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Tempat Lahir', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['tmp_ayah'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Tempat Lahir', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['tmp_ibu'], 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Tanggal Lahir', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['tgl_ayah'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Tanggal Lahir', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['tgl_ibu'], 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Pendidikan terakhir', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['pend_ayah'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Pendidikan akhir', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['pend_ibu'], 0, 1,'L');
$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Keterangan', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['ket_ayah'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Keterangan', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['ket_ibu'], 0, 1,'L');
$pdf->ln(0.25);
$pdf->Cell(0.5, 0.8, '', 'L,T', 0, 'C');
$pdf->Cell(3.5, 0.8, 'Wali', 'T', 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['ket_wali'], 'T', 0,'L');
$pdf->Cell(3, 0.8, 'Pekerjaan', 'T', 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['kerja'], 'T,R', 1,'L');
$pdf->Cell(0.5, 0.8, '', 'L', 0, 'C');
$pdf->Cell(3.5, 0.8, 'Telepon', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['tlp'], 0, 0,'L');
$pdf->Cell(3, 0.8, 'Keterangan', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['hubungan_wali'], 'R', 1,'L');
$pdf->Cell(0.5, 0.8, '', 'L,B', 0, 'C');
$pdf->Cell(3.5, 0.8, 'Alamat', 'B', 0, 'L');
$pdf->Cell(15, 0.8,": " . $lihat['alamat_wali'], 'R,B', 1,'L');
$pdf->ln(0.25);

$pdf->Cell(0.5, 0.8, '', 0, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Catatan', 0, 0, 'L');
$pdf->Cell(6, 0.8,": " . $lihat['ket_santri'], 0, 1,'L');

$no++;


$pdf->Output($lihat['nama']. ".pdf","I");
}
?>

