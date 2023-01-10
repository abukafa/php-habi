<?php 
include 'config.php';
$id=$_POST['id'];
$nama=$_POST['nama'];
$panggil=$_POST['panggilan'];
$klamin=$_POST['kelamin'];
$kls=$_POST['kelas'];
$wali=$_POST['wali'];

mysqli_query($GLOBALS["___mysqli_ston"], "insert into santri values('$id','$nama','$panggil','$klamin','$kls','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','$wali','-','-','-','-','-')");
header("location:santri");
 ?>
 