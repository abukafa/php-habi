<?php 
session_start();
include 'config.php';

if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    mysqli_query($GLOBALS["___mysqli_ston"], "delete from admin where id='$id'");
}else{
    $nama=$_POST['nama'];
    $uname=$_POST['uname'];
    $ket=$_POST['ket'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    mysqli_query($GLOBALS["___mysqli_ston"], "insert into admin values(NULL, '$nama', '$uname', '$pass', '$ket')")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}

header("location:user");
?>
