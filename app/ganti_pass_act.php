<?php 
include 'config.php';
$user=$_POST['user'];
$lama=($_POST['lama']);
$baru=$_POST['baru'];
$ulang=$_POST['ulang'];

$cek=mysqli_query($GLOBALS["___mysqli_ston"], "select * from admin where uname='$user'");
if(mysqli_num_rows($cek)==1){
	$row = mysqli_fetch_assoc($cek);
	if(password_verify($lama, $row["pass"])){
		$ba = password_hash($baru, PASSWORD_DEFAULT);
		if($baru==$ulang){
			mysqli_query($GLOBALS["___mysqli_ston"], "update admin set pass='$ba' where uname='$user'");
			header("location:ganti_pass?pesan=oke");
		}else{
			header("location:ganti_pass?pesan=tdksama");
		}
	}else{
		header("location:ganti_pass?pesan=gagal");
	}
}else{
	header("location:ganti_pass?pesan=gagal");
}

 ?>