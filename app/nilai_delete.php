<?php 
include 'config.php';
$no=$_GET['no'];
$thn=$_GET['thn'];
$smt=$_GET['smt'];
$mtr=$_GET['materi'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from nilai where no='$no'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
header("Location:nilai");
 ?>