<?php 
session_start();
include 'config.php';
$no=$_GET['no'];
$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from finance where no= '$no' ");
	while($b=mysqli_fetch_array($brg)){
		
$inv=$b['inv'];
$tgl=$b['tgl'];
$period=$b['period'];
$akun=$b['akun'];
$vend=$b['vendor'];
$urai=$b['uraian'];
$ket=$b['ket'];
$dbt=$b['debit'];
$kdt=$b['kredit'];
} 

$use=$_SESSION['uname'];
$nm=mysqli_query($GLOBALS["___mysqli_ston"], "select name from admin where uname='$use'");
while($name=mysqli_fetch_array($nm)){
$admin=$name['name'];

mysqli_query($GLOBALS["___mysqli_ston"], "insert into trash_finance values('', '$inv', '$tgl', '$period', '$akun', '$vend','$urai','$ket', '$dbt', '$kdt', '$admin')")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
mysqli_query($GLOBALS["___mysqli_ston"], "delete from finance where no='$no'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
header("Location:finance_add?tgl=". $tgl ."&vend=". $vend ."&ket=". $ket ."&inv=". $inv);

 ?>
