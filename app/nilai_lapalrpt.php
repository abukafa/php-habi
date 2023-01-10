<?php
include 'config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("P","cm", array(21.5, 33));
$santri=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas<>'XXX' order by kelas, nama");
while($lih=mysqli_fetch_assoc($santri)){
	
$pdf->SetMargins(1.25,2,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../assets/img/kop.png',1.25,0.6,20,2); 
$pdf->Line(1.27,2.7,20.25,2.7);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1.25,2.8,20.25,2.8);   
$pdf->SetLineWidth(0);

$thn=$_GET['thn'];
$smt=$_GET['smt'];

$nis=$lih['nis'];
	$ajr= $thn + 1;
	if ($smt == 1){
		$sem = 'GANJIL';
		}
		else{
		$sem = 'GENAP';
		}		
$pdf->ln(1.5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,0.5,'LAPORAN HASIL BELAJAR SANTRI',0,1,'C');
$pdf->Cell(0,0.5,'TAHUN AJARAN '. $thn ." - ". $ajr ,0,1,'C');
$pdf->Cell(0,0.5,'SEMESTER '. $sem ,0,1,'C');

	$ta=substr($thn,2,2);
	$tw=substr($nis,0,2);
	$t = $ta - $tw ;
	$kl=substr($nis,3,1) + $t ;
	$pdf->ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(2.5,0.6,'Nomor Induk',0,0,'L');
	$pdf->Cell(2,0.6,': ' . $nis,0,1,'L');
	$pdf->Cell(2.5,0.6,'Nama',0,0,'L');
	$pdf->Cell(2,0.6,': ' . $lih['nama'],0,1,'L');
	$pdf->Cell(2.5,0.6,'Kelas',0,0,'L');
	$pdf->Cell(2,0.6,': ' . $kl . ' - Level '. $lih['kelas'],0,1,'L');

$pdf->ln(0.25);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(19, 1, 'MUATAN KHUSUS', 0, 1, 'R');
$pdf->ln(0.25);
$pdf->Cell(5.5, 1, 'PELAJARAN', 1, 0, 'C');
$pdf->Cell(13.5, 1, 'PENILAIAN', 1, 1, 'C');
$thn=$_GET['thn'];
$smt=$_GET['smt'];
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from nilai where nis = '$nis' and thn='$thn' and smt ='$smt' and left(materi,1) = '1' order by materi");
while($nil=mysqli_fetch_assoc($query)){
	$cellWidth=12; //lebar sel
	$cellHeight=0.7; //tinggi sel satu baris normal
	if($pdf->GetStringWidth($nil['desk']) < $cellWidth){
		$line=1;
	}else{
		$textLength=strlen($nil['desk']);	//total panjang teks
		$errMargin=3;		//margin kesalahan lebar sel, untuk jaga-jaga
		$startChar=0;		//posisi awal karakter untuk setiap baris
		$maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
		$textArray=array();	//untuk menampung data untuk setiap baris
		$tmpString="";		//untuk menampung teks untuk setiap baris (sementara)
		while($startChar < $textLength){ //perulangan sampai akhir teks
			while( 
			$pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
			($startChar+$maxChar) < $textLength ) {
				$maxChar++;
				$tmpString=substr($nil['desk'],$startChar,$maxChar);
			}
			$startChar=$startChar+$maxChar;
			array_push($textArray,$tmpString);
			$maxChar=0;
			$tmpString='';
		}
		$line=count($textArray);
	}
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(5.5,($line * $cellHeight),substr($nil['materi'], 4 ,strlen($nil['materi'])),1,0,'L'); //sesuaikan ketinggian dengan jumlah garis
	$pdf->Cell(1.5,($line * $cellHeight),$nil['angka'],1,0,'C'); //sesuaikan ketinggian dengan jumlah garis
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->MultiCell($cellWidth,$cellHeight,$nil['desk'],0);
	$pdf->SetXY($xPos , $yPos);
    $pdf->Cell($cellWidth,($line * $cellHeight),'',1,1); //sesuaikan ketinggian dengan jumlah garis
}

$pdf->SetMargins(1.25,2,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ln(0.25);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(19, 1, 'MUROFAQOT', 0, 1, 'R');
$pdf->ln(0.25);
$pdf->Cell(5.5, 1, 'PELAJARAN', 1, 0, 'C');
$pdf->Cell(13.5, 1, 'PENILAIAN', 1, 1, 'C');
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from nilai where nis = '$nis' and thn='$thn' and smt ='$smt' and left(materi,1) = '2' order by materi");
while($nil=mysqli_fetch_assoc($query)){
    $cellWidth=12; //lebar sel
	$cellHeight=0.7; //tinggi sel satu baris normal
	if($pdf->GetStringWidth($nil['desk']) < $cellWidth){
		$line=1;
	}else{
		$textLength=strlen($nil['desk']);	//total panjang teks
		$errMargin=3;		//margin kesalahan lebar sel, untuk jaga-jaga
		$startChar=0;		//posisi awal karakter untuk setiap baris
		$maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
		$textArray=array();	//untuk menampung data untuk setiap baris
		$tmpString="";		//untuk menampung teks untuk setiap baris (sementara)
		while($startChar < $textLength){ //perulangan sampai akhir teks
			while( 
			$pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
			($startChar+$maxChar) < $textLength ) {
				$maxChar++;
				$tmpString=substr($nil['desk'],$startChar,$maxChar);
			}
			$startChar=$startChar+$maxChar;
			array_push($textArray,$tmpString);
			$maxChar=0;
			$tmpString='';
		}
		$line=count($textArray);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(5.5,($line * $cellHeight),substr($nil['materi'], 4 ,strlen($nil['materi'])),1,0,'L'); //sesuaikan ketinggian dengan jumlah garis
	$pdf->Cell(1.5,($line * $cellHeight),$nil['angka'],1,0,'C'); //sesuaikan ketinggian dengan jumlah garis
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->MultiCell($cellWidth,$cellHeight,$nil['desk'],0);
	$pdf->SetXY($xPos , $yPos);
    $pdf->Cell($cellWidth,($line * $cellHeight),'',1,1); //sesuaikan ketinggian dengan jumlah garis
}

$pdf->SetMargins(1.25,2,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ln(0.25);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(19, 1, 'MUATAN PENUNJANG', 0, 1, 'R');
$pdf->ln(0.25);
$pdf->Cell(5.5, 1, 'PELAJARAN', 1, 0, 'C');
$pdf->Cell(13.5, 1, 'PENILAIAN', 1, 1, 'C');
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from nilai where nis = '$nis' and thn='$thn' and smt ='$smt' and left(materi,1) = '3' order by materi");
while($nil=mysqli_fetch_assoc($query)){
    $cellWidth=12; //lebar sel
	$cellHeight=0.7; //tinggi sel satu baris normal
	if($pdf->GetStringWidth($nil['desk']) < $cellWidth){
		$line=1;
	}else{
		$textLength=strlen($nil['desk']);	//total panjang teks
		$errMargin=3;		//margin kesalahan lebar sel, untuk jaga-jaga
		$startChar=0;		//posisi awal karakter untuk setiap baris
		$maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
		$textArray=array();	//untuk menampung data untuk setiap baris
		$tmpString="";		//untuk menampung teks untuk setiap baris (sementara)
		while($startChar < $textLength){ //perulangan sampai akhir teks
			while( 
			$pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
			($startChar+$maxChar) < $textLength ) {
				$maxChar++;
				$tmpString=substr($nil['desk'],$startChar,$maxChar);
			}
			$startChar=$startChar+$maxChar;
			array_push($textArray,$tmpString);
			$maxChar=0;
			$tmpString='';
		}
		$line=count($textArray);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(5.5,($line * $cellHeight),substr($nil['materi'], 4 ,strlen($nil['materi'])),1,0,'L'); //sesuaikan ketinggian dengan jumlah garis
	$pdf->Cell(1.5,($line * $cellHeight),$nil['angka'],1,0,'C'); //sesuaikan ketinggian dengan jumlah garis
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->MultiCell($cellWidth,$cellHeight,$nil['desk'],0);
	$pdf->SetXY($xPos , $yPos);
    $pdf->Cell($cellWidth,($line * $cellHeight),'',1,1); //sesuaikan ketinggian dengan jumlah garis
}

$query=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(angka) as jum, count(angka) as num from nilai where nis='$nis' and thn='$thn' and smt ='$smt' ");
while($s=mysqli_fetch_array($query)){
	if( $s['jum'] > 0 && $s['num'] > 0 ){
		$rata = $s['jum'] / $s['num'] ;
	}else{
		$rata = 0 ;
	}
	
	if ($rata < 50){
		$ket="Perlu Bimbingan dan Perhatian...!";
	}elseif($rata < 70){
		$ket="Perlu ditingkatkan...!";
	}elseif($rata < 90){
		$ket="Tetap Semangat...!";
	}else{
		$ket="Pertahankan...!";
	}
	$pdf->ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5.5, 1, 'NILAI RATA - RATA', "T,B,L", 0, 'C');
	$pdf->Cell(1.5, 1, number_format($rata,2) , "T,B", 0, 'L');
	$pdf->Cell(12, 1, $ket , "T,B,R", 1, 'C');
}
$pdf->ln(0.5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(9.5, 1, 'CATATAN WALI SANTRI', 1, 0, 'C');
$pdf->Cell(9.5, 1, 'CATATAN WALI KELAS', 1, 1, 'C');
$pdf->Cell(9.5, 3, '', 1, 0, 'C');
$pdf->Cell(9.5, 3, '', 1, 1, 'C');

$pdf->ln(1);
$pdf->Cell(13, 0.6,'', 0, 0, 'C');
$pdf->Cell(6, 0.6,"Ciamis, ". date("d M Y"), 0, 1, 'C');
$pdf->Cell(6, 0.6,'Wali Santri', 0, 0, 'C');
$pdf->Cell(7, 0.6,'', 0, 0, 'C');
$pdf->Cell(6, 0.6,'Wali Kelas', 0, 1, 'C');
$pdf->Cell(6, 2,'', "B", 0, 'C');
$pdf->Cell(7, 2,'', 0, 0, 'C');
$pdf->Cell(6, 2,'', "B", 0, 'C');
$pdf->ln(1);
}
$pdf->Output("Raport $thn-S$smt.pdf","I");
?>
