<?php 
include 'config.php';
$thn=$_POST['thn'];
$smt=$_POST['smt'];
$nis=$_POST['nis'];
$nama=$_POST['nama'];
$kls=$_POST['kelas'];
$mtr=$_POST['mtr'];
$na=$_POST['na'];
$desk=addslashes($_POST['desk']);

mysqli_query($GLOBALS["___mysqli_ston"], "insert into nilai values('', '$thn','$smt','$nis','$nama','$kls','$mtr','$na','$desk')");
header("location:nilai");
 ?>