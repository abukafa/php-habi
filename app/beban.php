<?php
include 'header.php';
?>
<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>  Data Beban</h3>
		<div class="d-md-flex justify-content-between">
			<button class="btn btn-primary col-md-2 mb-2" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Data</button>
			<div class="btn-group">
				<a class="btn" href="pay"><span data-feather="arrow-left"></span>Kembali</a>
				<a class="btn" href="exc"><span data-feather="arrow-left"></span>Exception</a>
			</div>
			<form action="" method="get">
				<div class="input-group col-md-5 col-md-offset-7">
					<label class="input-group-text" for="thn"><span data-feather="calendar"></span></label>
					<select type="submit" name="thn" class="form-control" onchange="this.form.submit()">
						<option>.. Tahun ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct thn from beban order by thn desc");
						while($p=mysqli_fetch_array($pil)){
							?>
							<option><?php echo $p['thn'] ?></option>
							<?php
						}
						?>			
					</select>
				</div>
			</form>
		</div>
	</div>


	<!-- View Table Data Beban -->
	<div class="card mt-3">
		<div class="card-header d-md-flex justify-content-between">
			<h5 class="card-title">	
			<?php 
			if(isset($_GET['thn'])){
				echo "Data Beban Tahun ". $_GET['thn'];
			}else{
				echo "Data Beban Administrasi";
			}
			?>
			</h5>
		</div>
		<div class="card-body">
			<table class="table table-hover">
				<tr>
					<th>No</th>
					<th>NIS</th>
					<th class="d-none d-md-table-cell">Nama</th>
					<th class="d-none d-md-table-cell">Tahun</th>
					<th class="d-none d-md-table-cell">Keterangan</th>
					<td class="text-end">Bulanan</td>
					<td class="text-end">Tahunan</td>
				</tr>
				<?php 
				if(isset($_GET['thn'])){
					$tah=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
					$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from beban where thn = '$tah' order by no desc");
				}else{
					$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from beban");
					$per_hal=20;
					$jum=mysqli_num_rows($jumlah_record);
					$halaman=ceil($jum / $per_hal);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $per_hal;
					$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from beban order by no limit $start, $per_hal");
				}
				$no=1;
				while($b=mysqli_fetch_array($brg)){
					$thn=$b['daftar']+$b['bangunan']+$b['pendidikan']+$b['seragam'];
					$bln=$b['spp']+$b['makan']+$b['asrama'];
				?>
				<tr>
					<td><a href="beban_edit?no=<?php echo $b['no']; ?>"><?php echo $b['no'] ?></a></td>
					<td><?php echo $b['nis'] ?></td>
					<td class="d-none d-md-table-cell"><?php echo $b['nama'] ?></td>
					<td class="d-none d-md-table-cell"><?php echo $b['thn'] ?></td>
					<td class="d-none d-md-table-cell"><?php echo $b['ket'] ?></td>
					<td class="text-end"><?php echo number_format($bln,0,'',',') ?></td>
					<td class="text-end"><?php echo number_format($thn,0,'',',') ?></td>
				</tr>		
				<?php 
				}
				?>
			</table>

			<!-- Pagination -->
			<?php
			if(!isset($_GET['thn'])){ ?>
				<div class="text-center"><?php echo $jum; ?> Records in <?php echo $halaman; ?> pages </div>
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
	
			<!-- Import & Export data -->
			<div class="d-flex justify-content-between">
				<?php
				if(isset($_GET['thn'])){
					$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
				?>
				<input type="hidden" class="form-control" name="tah" value="<?php echo $thn; } ?>">
				<button type="submit" name="Export-beban" class="btn btn-success button-loading" data-loading-text="Loading..."><span class='glyphicon glyphicon-download'></span>  Export</button>
				<!-- <form action="function" method="post" name="upload_excel" enctype="multipart/form-data"> -->
				<div class="input-group">
					<label class="col-lg-8 control-label" for="filebutton"></label>
					<input class="form-control" type="file" accept=".csv" name="file" id="file">
					<button type="submit" id="submit" name="Import-beban" class="btn btn-success button-loading" data-loading-text="Loading...">
						<span data-feather="upload"></span> Import
					</button>
				</div>
				<!-- </form> -->
			</div>
		</div>
	</div>
</main>

<!-- modal input -->
<div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Tambah Data Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="beban_act" method="post">
					<div class="form-group mb-2">
							<label class="form-label">Nomor Induk Santri</label>								
							<select name="nis" id="nis" class="form-control" onchange="changeValue(this.value)">
							<option value=0>-Pilih-</option>
								<?php 
								$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where kelas<>'XXX' order by nama");
								$jsArray = "var sant = new Array();\n";        
								while($b=mysqli_fetch_array($brg)){
								echo '<option value="' . $b['nis'] . '">' . $b['nis'] . " - ". $b['nama'] . '</option>';
								$jsArray .= "sant['" . $b['nis'] . "'] = {nama:'" . addslashes($b['nama']) . "',kelas:'".addslashes($b['kelas']) . "',ket_wali:'".addslashes($b['ket_wali']) . "',ayah:'".addslashes($b['ayah']) . "'};\n";
								}
								?>
							</select>
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Nama Santri</label>
						<input name="nama" id="nama" type="text" class="form-control" readonly="yes">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Kelas</label>
						<input name="kls" id="kls" type="text" class="form-control" readonly="yes">
					</div>
					<div class="form-group mb-2">
						<label class="form-label">Tahun</label>
							<select name="thn" class="form-control" value="-">
							<option value="-">.. Tahun ..</option>
							<?php
								for($i=2017; $i<=date('Y')+2; $i++){
								echo"<option value='$i'> $i </option>";
								}
								?>
							</select>
						<div class="form-group mb-2">
							<label class="form-label">Keterangan</label>
							<input name="ket" type="text" class="form-control" autocomplete="off" value="-" >
						</div>
					</div>
					
						<script type="text/javascript">    
						<?php echo $jsArray; ?>  
						function changeValue(nis){  
						document.getElementById('nama').value = sant[nis].nama;
						document.getElementById('kls').value = sant[nis].kelas;
						};  
						</script>
								
						<div class="form-group mb-2">
							<label class="form-label">SPP</label>
							<input name="spp" type="text" class="form-control" autocomplete="off" value="0" >
						</div>
						<div class="form-group mb-2">
							<label class="form-label">Uang Makan</label>
							<input name="makan" type="text" class="form-control" autocomplete="off" value="0" >
						</div>	
						<div class="form-group mb-2">
							<label class="form-label">Asrama</label>
							<input name="asrama" type="text" class="form-control" autocomplete="off" value="0" >
						</div>		
						<div class="form-group mb-2">
							<label class="form-label">Pendaftaran</label>
							<input name="daftar" type="text" class="form-control" autocomplete="off" value="0" >
						</div>		
					<div class="form-group mb-2">
						<label class="form-label">Bangunan</label>
						<input name="bangunan" type="text" class="form-control" value="0" >
					</div>	
					<div class="form-group mb-2">
							<label class="form-label">Pendidikan</label>
							<input name="pendidikan" type="text" class="form-control" value="0" > <!--onkeyup="this.value=numbe(this.value);"-->
						</div>
						<div class="form-group mb-2">
							<label class="form-label">Seragam</label>
							<input name="seragam" type="text" class="form-control" value="0" autocomplete="off">
						</div>	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
