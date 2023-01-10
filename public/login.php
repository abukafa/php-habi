<!DOCTYPE html>
<html>
<head>
<?php
error_reporting(0);
session_start();
if(isset($_SESSION['uname'])){
	header("location:../app/dasboard");
	exit;
}
include 'navbar.php';
?>
<style>
	.form-signin {
		width: 100%;
		max-width: 330px;
		padding: 15px;
		margin: auto;
	}
	.form-signin input[type="text"] {
		margin-bottom: -1px;
		border-bottom-right-radius: 0;
		border-bottom-left-radius: 0;
	}
	.form-signin input[type="password"] {
		margin-bottom: 10px;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}
</style>
</head>
<body>	
	<div class="form-signin text-center mt-5">  
		<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan'] == "gagal"){
				echo "<div style='margin-bottom:-55px' class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-warning-sign'></span>  Login gagal.. Coba lagi ya..</div>";
			}
		}
		?>
		<form action="login_act.php" method="post">
			<!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
			<h1 class="h3 m-3 fw-normal">Login to Admin</h1>
			<div class="form-floating">
				<input type="text" class="form-control" id="floatingInput" placeholder="Username" name="uname" autocomplete="off">
				<label for="floatingInput">Username</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pass">
				<label for="floatingPassword">Password</label>
			</div>
			<button class="w-100 btn btn-lg btn-dark mt-3" type="submit">Sign in</button>
			<span data-feather="alert-triangle" class="mt-5 mb-1 text-danger"></span>
			<p class="mb-3 text-danger">Menu ini hanya untuk Admin</p>
		</form>
	</div>
</body>
</html>