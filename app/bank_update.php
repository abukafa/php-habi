<?php 
session_start();
include 'config.php';
$no=$_POST['no'];
$tgl=$_POST['tgl'];
$date=date_create($tgl);
$period=date_format($date, 'M Y');
$nis=$_POST['nis'];
$nama=$_POST['nama'];
$wali=$_POST['wali'];
$dbt=$_POST['debit'];
$kdt=$_POST['kredit'];
$ket=$_POST['ket'];

$use=$_SESSION['uname'];
$nm=mysqli_query($GLOBALS["___mysqli_ston"], "select name from admin where uname='$use'");
while($name=mysqli_fetch_array($nm)){
$admin=$name['name'];

mysqli_query($GLOBALS["___mysqli_ston"], "update tabungan set tgl='$tgl', period='$period', nis='$nis', nama='$nama', wali='$wali', debit='$dbt', kredit='$kdt', ket='$ket', admin='$admin' where no='$no' ");
header("location:bank");
}
?>
