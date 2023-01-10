<?php 
include 'header.php';
?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Ubah Password</h3>
		<?php 
		if(isset($_GET['pesan'])){
			$pesan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['pesan']);
			if($pesan=="oke"){
				echo "<div class='alert alert-success col-lg-6'>Password telah diubah !</div>";
			}else if($pesan=="tdksama"){
				echo "<div class='alert alert-warning col-lg-6'>Password yang anda masukkan tidak sesuai !</div>";
			}else if($pesan=="gagal"){
				echo "<div class='alert alert-danger col-lg-6'>Password gagal diubah ! Periksa Kembali !</div>";
			}
		}
		?>
		<div class="card col-lg-6">
			<div class="card-body">
			<form action="ganti_pass_act" method="post">
				<div class="form-group mb-2">
					<input name="user" type="text" class="form-control" value="<?php echo $_SESSION['uname']; ?>" readonly="yes">
				</div>
				<div class="form-group mb-2">
					<label class="form-label">Password Lama</label>
					<input name="lama" type="password" class="form-control" placeholder="Password Lama ..">
				</div>
				<div class="form-group mb-2">
					<label class="form-label">Password Baru</label>
					<input name="baru" type="password" class="form-control" placeholder="Password Baru ..">
				</div>
				<div class="form-group mb-4">
					<label class="form-label">Ulangi Password</label>
					<input name="ulang" type="password" class="form-control" placeholder="Ulangi Password ..">
				</div>	
				<div class="form-group mb-2">
					<input type="submit" class="btn btn-primary" value="Simpan">
					<input type="reset" class="btn btn-secondary" value="reset">
				</div>																	
			</form>
			</div>
		</div>
