<?php 
session_start();
include 'config.php';
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

mysqli_query($GLOBALS["___mysqli_ston"], "insert into tabungan values(NULL, '$tgl', '$period', '$nis', '$nama','$wali','$dbt','$kdt','$ket', '$admin')")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
header("location:bank");
}
?>
