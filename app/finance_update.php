<?php 
session_start();
include 'config.php';
$no=$_POST['no'];
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

mysqli_query($GLOBALS["___mysqli_ston"], "update finance set inv='$inv', tgl='$tgl', period='$period', akun='$akun', vendor='$vend', uraian='$urai', ket='$ket', debit='$dbt', kredit='$kdt', admin='$admin' where no='$no' ");
header("Location:finance_add?tgl=". $tgl ."&vend=". $vend ."&ket=". $ket ."&inv=". $inv);
}
?>
