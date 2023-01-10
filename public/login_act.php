<?php 
session_start();
include '../app/config.php';
$uname=$_POST['uname'];
$pass=$_POST['pass'];
$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from admin where uname='$uname'");
if(mysqli_num_rows($query)==1){
	$row = mysqli_fetch_assoc($query);
	if(password_verify($pass, $row["pass"])){
		$_SESSION['uname']=$uname;
		header("location:../app/dasboard");
	}else{
		header("location:login?pesan=gagal")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
}else{
	header("location:login?pesan=gagal")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	// mysql_error();
}
// echo $pas;
 ?>