<?php 
session_start();
include 'config.php';

$inv=$_POST['inv'];
$tgl=$_POST['tgl'];
$date=date_create($tgl);
$period=date_format($date, 'M Y');
$akun=$_POST['akun'];
$vend=$_POST['vendor'];
$urai=$_POST['uraian'];
$ket=$_POST['ket'];

if (substr($akun, 0, 3) == 777){
	$dbt=$_POST['amon'];
	$kdt=0;
} 
else {
	$dbt=0;
	$kdt=$_POST['amon'];
}

$use=$_SESSION['uname'];
$nm=mysqli_query($GLOBALS["___mysqli_ston"], "select name from admin where uname='$use'");
while($name=mysqli_fetch_array($nm)){
$admin=$name['name'];

mysqli_query($GLOBALS["___mysqli_ston"], "insert into finance values('', '$inv', '$tgl', '$period', '$akun', '$vend','$urai','$ket', '$dbt', '$kdt', '$admin')")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
header("Location:finance_add?tgl=". $tgl ."&vend=". $vend ."&ket=". $ket ."&inv=". $inv);
}
?>
