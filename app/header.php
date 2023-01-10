<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	include 'config.php';
	if(!isset($_SESSION['uname'])){
		header("location:../public/login");
		exit;
	}else{
		$use=$_SESSION['uname'];
		$nm=myquery("select * from admin where uname='$use'");
		$u=$nm[0];
	}
		// while($u=mysqli_fetch_array($nm)){
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <!-- <link href="../../assets/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/emb.png">
    <title> HABI | Admin</title>
	<script src="../assets/js/app.js"></script>
</head>

<body>
	<div class="wrapper">

        <!--  SIDEBAR MENU  ---------------------------------------------------------------------------------------------------------->
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="dasboard">
				<span class="align-middle">HABI Office</span>
			</a>
			<?php 
			// menghilangkan slash (/) di ahir
			$url = rtrim($_SERVER['REQUEST_URI'], '/');
			// memecah URL menjadi array
			$url = explode('/', $url);
            $act = substr($url[3],0,3);
			?> 

				<ul class="sidebar-nav">
					<li class="sidebar-header">
					</li>
					<li class="sidebar-item <?php if($act == 'das'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="dasboard">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
						</a>
					</li>
						<li class="sidebar-item <?php if($act == 'san'){ echo 'active'; } ?>">
							<a class="sidebar-link" href="santri">
								<i class="align-middle" data-feather="user"></i> <span class="align-middle">Data Santri</span>
							</a>
						</li>
						<li class="sidebar-item <?php if($act == 'nil'){ echo 'active'; } ?>">
							<a class="sidebar-link" href="nilai">
								<i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Penilaian</span>
							</a>
						</li>
						<?php 
						if($u['uinfo'] <> 'Penilaian'){
						?>
						<li class="sidebar-item <?php if($act == 'pay'){ echo 'active'; } ?>">
							<a class="sidebar-link" href="pay">
								<i class="align-middle" data-feather="inbox"></i> <span class="align-middle">Pembayaran</span>
							</a>
						</li>
						<li class="sidebar-item <?php if($act == 'fin'){ echo 'active'; } ?>">
							<a class="sidebar-link" href="finance">
								<i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Keuangan</span>
							</a>
						</li>
						<li class="sidebar-item <?php if($act == 'ban'){ echo 'active'; } ?>">
							<a class="sidebar-link" href="bank">
								<i class="align-middle" data-feather="archive"></i> <span class="align-middle">Tabungan</span>
							</a>
						</li>
						<?php 
						}
						?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="logout">
							<i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
        
		<div class="main">

      <!--  SIDEBAR TOGGLE  ---------------------------------------------------------------------------------------------------->
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
				<i class="hamburger align-self-center"></i>
				</a>

        <!--  NAVBAR MENU  --------------------------------------------------------------------------------------------------->
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">

						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
							<i class="align-middle" data-feather="settings"></i>
						</a>
                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
							<img src="../assets/img/emb.png" class="avatar img-fluid rounded-circle me-2">
                            <b><?= $u['name'] ?></b>
						</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="user"><i class="align-middle me-1" data-feather="user"></i> Pengguna</a>
								<?php 
								if($u['uinfo'] <> 'Penilaian'){
								?>
								<a class="dropdown-item" href="ganti_pass"><i class="align-middle me-1" data-feather="settings"></i> Password</a>
								<?php 
								}
								?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="logout"><i class="align-middle me-1" data-feather="log-out"></i> Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
            <?php 
            // }
            ?>
