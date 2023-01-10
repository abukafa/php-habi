<?php 
include 'config.php';
$no=$_GET['no'];
$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bayaran where no= '$no' ");
	while($b=mysqli_fetch_array($brg)){
		
session_start();
include 'config.php';
$tgl=$b['tgl'];
$date=date_create($tgl);
$period=date_format($date, 'M Y');
$nis=$b['nis'];
$nama=$b['nama'];
$wali=$b['wali'];
$thn=$b['thn'];
$daftar=$b['daftar'];
$bangunan=$b['bangunan'];
$pendidikan=$b['pendidikan'];
$seragam=$b['seragam'];
$bln=$b['bln'];
$spp=$b['spp'];
$makan=$b['makan'];
$lain=$b['lain'];
$ket=$b['ket'];
$jumlah=$daftar + $bangunan + $pendidikan + $seragam + $spp + $makan + $lain;

$use=$_SESSION['uname'];
$nm=mysqli_query($GLOBALS["___mysqli_ston"], "select name from admin where uname='$use'");
while($name=mysqli_fetch_array($nm)){
$admin=$name['name'];

mysqli_query($GLOBALS["___mysqli_ston"], "insert into trash_pay values('$no','$tgl', '$period', '$nis', '$nama','$wali','$thn','$daftar','$bangunan', '$pendidikan', '$seragam', '$bln', '$spp', '$makan', '$lain', '$ket', '$jumlah', '$admin')")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
header("location:pay");
}
	}
mysqli_query($GLOBALS["___mysqli_ston"], "delete from bayaran where no='$no'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
header("location:pay");

 ?>
