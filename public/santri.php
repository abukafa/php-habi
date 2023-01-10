<?php 
error_reporting(0);
include_once 'navbar.php';
include_once '../app/config.php';
?>

<main class="content">
	<div class="container">
	<p class="display-6 text-center mb-2">Data Santri</p>
	<p class="h5 text-center mb-3"><?php echo date('D, d M Y') ?></p>
	
	<div class="d-flex mb-3">
		<div class="col-6 col-md-4 col-lg-3">
			<!-- Filter Data Santri -->
			<form action="" method="get">
				<div class="input-group">
					<label class="input-group-text" for="kls"><span data-feather="search"></span></label>
					<select type="submit" id="kls" name="kls" class="form-select" onchange="this.form.submit()">
						<option>.. Pilih ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct kelas from santri order by kelas");
						while($p=mysqli_fetch_array($pil)){
							?>
							<option><?php echo $p['kelas'] ?></option>
							<?php
						}
						?>			
					</select>
				</div>
			</form>
		</div>
	</div>


	<div class="card">
		<div class="card-header">
			<div class="card-body">
				<table class="table table-hover table-strip">
					<tr>
						<th class="d-none d-md-table-cell">NIS</th>
						<th>Nama Santri</th>
						<th class="d-none d-lg-table-cell">Panggilan</th>
						<th>Kelas</th>
						<th class="d-none d-md-table-cell">Kota Asal</th>
						<th class="d-none d-lg-table-cell">Nama Wali</th>
					</tr>
					<?php 
					if(isset($_GET['kls'])){
						$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where kelas = '$kls' order by nis");
					}else{
						$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri");
						$per_hal=20;
						$jum=mysqli_num_rows($jumlah_record);
						$halaman=ceil($jum / $per_hal);
						$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
						$start = ($page - 1) * $per_hal;
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri order by kelas, nama limit $start, $per_hal");
					}
					$no=1;
					while($b=mysqli_fetch_array($brg)){
					?>
					<tr>
						<td class="d-none d-md-table-cell"><?php echo $b['nis'] ?></td>
						<td><?php echo $b['nama'] ?></td>
						<td class="d-none d-lg-table-cell"><?php echo $b['panggilan'] ?></td>
						<td><?php echo $b['kelas'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['kab'] ?></td>
						<td class="d-none d-lg-table-cell"><?php echo $b['ket_wali'] ?></td>
					</tr>		
					<?php 
					}
					?>
				</table>
		
				<!-- Pagination -->
				<?php
				if(!isset($_GET['kls'])){ ?>
					<div class="text-center mt-5"><?php echo $jum; ?> Records in <?php echo $halaman; ?> pages </div>
					<ul class="pagination justify-content-center">			
						<li class="page-item"><a class="page-link" href="?page=1">First</a></li>
						<li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
							<a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>"><<</a>
						</li>
						<li class="page-item disabled"><a class="page-link"><?php echo $page; ?></a></li>
						<li class="page-item <?php if($page >= $halaman){ echo 'disabled'; } ?>">
							<a class="page-link" href="<?php if($page >= $halaman){ echo '#'; } else { echo "?page=".($page + 1); } ?>">>></a>
						</li>	
						<li class="page-item"><a class="page-link" href="?page=<?php echo $halaman ?>">Last</a></li>				
					</ul>
				<?php } ?>

			</div>
		</div>
	</div>
</main>