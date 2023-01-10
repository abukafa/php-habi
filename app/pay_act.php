<?php 
session_start();
include 'config.php';
$tgl=$_POST['tgl'];
$date=date_create($tgl);
$period=date_format($date, 'M Y');
$nis=$_POST['nis'];
$nama=$_POST['nama'];
$wali=$_POST['ayah'];
$thn=$_POST['tahun'];
$daftar=$_POST['daftar'];
$bangunan=$_POST['bangunan'];
$pendidikan=$_POST['pendidikan'];
$seragam=$_POST['seragam'];
$bln=$_POST['bln'];
$spp=$_POST['spp'];
$makan=$_POST['makan'];
$lain=$_POST['lain'];
$ket=$_POST['ket'];
$jumlah=$daftar + $bangunan + $pendidikan + $seragam + $spp + $makan + $lain;

$use=$_SESSION['uname'];
$nm=mysqli_query($GLOBALS["___mysqli_ston"], "select name from admin where uname='$use'");
while($name=mysqli_fetch_array($nm)){
$admin= addslashes($name['name']);

mysqli_query($GLOBALS["___mysqli_ston"], "insert into bayaran values('','$tgl', '$period', '$nis', '$nama','$wali','$thn','$daftar','$bangunan', '$pendidikan', '$seragam', '$bln', '$spp', '$makan', '$lain', '$ket', '$jumlah', '$admin')")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
header("location:pay");
}
?>
