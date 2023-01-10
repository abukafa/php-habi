<?php 
include 'config.php';
$nis=$_POST['nis'];
$nama=$_POST['nama'];
$thn=$_POST['thn'];
$ket=$_POST['ket'];
$spp=$_POST['spp'];
$makan=$_POST['makan'];
$asrama=$_POST['asrama'];
$daftar=$_POST['daftar'];
$bangunan=$_POST['bangunan'];
$pendidikan=$_POST['pendidikan'];
$seragam=$_POST['seragam'];

mysqli_query($GLOBALS["___mysqli_ston"], "insert into exception values(NULL, '$nis', '$nama', '$thn', '$ket', '$daftar', '$bangunan', '$pendidikan', '$seragam','$spp', '$makan', '$asrama')")or die(mysqli_error($GLOBALS["___mysqli_ston"]));


header("location:exc");
?>
