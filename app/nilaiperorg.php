<?php include 'header.php';	?>

<main class="content">
	<div class="container-fluid p-0">
		
		<h3 class="display-6"><span class=""></span>  Data Nilai Akhir</h3>
		<div class="d-md-flex justify-content-between">
			<!-- <button class="btn btn-primary col-md-2" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Nilai</button> -->
			<a class="btn mb-2" href="nilai"><span data-feather="arrow-left"></span>  Kembali</a>
		
			<form action="" method="get">
				<div class="input-group">
					<label class="input-group-text" for="kls"><span data-feather="search"></span></label>
					<select name="santri" id="santri" class="form-control" onchange="changeValue(this.value)">
						<option>.. Santri ..</option>
						<?php 
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas<>'XXX' order by nama");
						$jsArray = "var sant = new Array();\n";        
						while($b=mysqli_fetch_array($brg)){
						echo '<option value="' . $b['nis'] . '">' . $b['nis'] ." - ". $b['nama'] . '</option>';
						$jsArray .= "sant['" . $b['nis'] . "'] = {nama:'" . addslashes($b['nama']) . "',kelas:'".addslashes($b['kelas']) . "'};\n";
						}
						?>			
					</select>
					<div class="form-group">
						<input name="kls" id="kls" type="hidden" class="form-control" readonly="yes">
					</div>	
					<script type="text/javascript">    
						<?php echo $jsArray; ?>  
						function changeValue(santri){  
							document.getElementById('kls').value = sant[nis].kelas;
							};  
					</script>
					<select type="submit" name="smt" class="form-control"">
						<option>.. Smt ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct smt from nilai order by smt");
						while($p=mysqli_fetch_array($pil)){
							?>
							<option><?php echo $p['smt'] ?></option>
							<?php
						}
						?>			
					</select>
					<select type="submit" name="thn" class="form-control" onchange="this.form.submit()">
						<option>.. Thn ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct thn from nilai order by thn");
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

		<?php 
		if(isset($_GET['thn'])){
			$mtr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['santri']);
			$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
			$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
			$tg="nilai_lapalrpt?smt=$smt&thn=$thn";
			$tg1="santri_lapbio?thn=$thn";
			$tg2="nilai_lapindex?smt=$smt&thn=$thn";
		}else{
			$tg="nilai_lapalrpt";
			$tg1="santri_lapbio";
			$tg2="nilai_lapindex";
		}
		?>


		<!-- View Table Data nilai -->
		<div class="card mt-3">
			<div class="card-header d-md-flex justify-content-between">
				<h5 class="card-title">
					<?php 
					if(isset($_GET['thn'])){
						echo "Data Penilaian Tahun ". $thn." Semester ". $smt;
					?>
				</h5>
				<div class="btn-group float-end">
					<a style="margin-bottom:10px" href="<?php echo $tg ?>" target="_blank" class="btn btn-success pull-right">Rapot</a>
					<a style="margin-bottom:10px" href="<?php echo $tg2 ?>" target="_blank" class="btn btn-success pull-right">Index</a>
					<a style="margin-bottom:10px" href="<?php echo $tg1 ?>" target="_blank" class="btn btn-success pull-right">Biodata</a>
				</div>
				<?php 
					}else{
						echo "Data Penilaian Per Santri</h5>";
					}
				?>
			</div>
			<div class="card-body">
				<table class="table table-hover">
					<tr>
						<th class="d-none d-md-table-cell">No</th>
						<th class="d-none d-md-table-cell">Nama</th>
						<th class="d-none d-md-table-cell">Kelas</th>
						<td>Pelajaran</td>			
						<td>NA</td>
						<td class="d-none d-lg-table-cell">Deskripsi</td>		
						<td></td>
					</tr>
					<?php 
					$per_hal=30;
					$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from nilai");
					$jum=mysqli_num_rows($jumlah_record);
					$halaman=ceil($jum / $per_hal);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $per_hal;
					
					if(isset($_GET['thn'])){
						$nis=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['santri']);
						$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
						$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from nilai where thn='$thn' and smt='$smt' and nis='$nis' order by materi");
					}else{
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from nilai order by no desc limit $start, $per_hal");
					}
					while($b=mysqli_fetch_array($brg)){
					?>
					<tr>
						<td class="d-none d-md-table-cell"><?php echo $b['no'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['nama'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['kls'] ?></td>
						<td><?php echo $b['materi'] ?></td>
						<td><?php echo $b['angka'] ?></td>
						<td class="d-none d-lg-table-cell"><?php echo $b['desk'] ?></td>
						<td>
						<?php 
						if(isset($_GET['thn'])){
						?>
							<a href="#" type="button" class="btn btn-warning btn-md" data-bs-toggle="modal" data-bs-target="#EModal<?php echo $b['no']; ?>"><span data-feather="edit"></span></a>
							<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='nilai_delete?no=<?php echo $b['no']; ?>materi=<?php echo $b['materi']; ?>&smt=<?php echo $b['smt']; ?>&thn=<?php echo $b['thn']; ?>' }" class="btn btn-danger"><span data-feather="trash"></span></a>
							<a href="nilai_laprapot?nis=<?php echo $b['nis']; ?>&tahun=<?php echo $b['thn']; ?>&semester=<?php echo $b['smt']; ?>"  target="_blank"  class="btn btn-success d-none d-lg-inline-block"><span data-feather='printer'></span></a>
						</td>
						<!-- Modal Edit Entry-->
						<div class="modal fade" id="EModal<?php echo $b['no']; ?>" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="staticBackdropLabel">Edit Data Nilai</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<?php
									$no=$b['no'];
									$query_edit = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai WHERE no='$no'");
									while ($row = mysqli_fetch_array($query_edit)) {  
									?>
									<div class="modal-body">
										<form role="form" action="nilaiperorg_update" method="post">
											<input type="hidden" name="no" value="<?php echo $row['no']; ?>">
											<div class="form-group">
												<input name="ni" type="hidden" class="form-control" value="<?php echo $row['nis']; ?>">
												<label><?php echo $row['nis']; ?> -- <?php echo $row['nama']; ?> -- <?php echo $row['kls']; ?></label> 
											</div>
											<div class="form-group">
												<label>Tahun</label>
												<input name="thn" type="text" class="form-control" value="<?php echo $row['thn']; ?>" readonly="yes">
											</div>
											<div class="form-group">
												<label>Semester</label> 
												<input name="smt" type="text" class="form-control" value="<?php echo $row['smt']; ?>" readonly="yes">
											</div>
											<div class="form-group">
												<label>Pelajaran</label>   
												<input name="mtr" type="text" class="form-control" value="<?php echo $row['materi']; ?>" readonly="yes">
											</div>
											<div class="form-group">
												<label>Edit Nilai Akhir</label>
												<input name="na" type="text" class="form-control" value="<?php echo $row['angka']; ?>">
											</div>	
											<div class="form-group">
												<label>Edit Deskripsi</label>
												<textarea name="desk" type="text" class="form-control" rows="7"><?php echo $row['desk']; ?></textarea>
											</div>	
											<div class="modal-footer">  
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Save</button>
											</div>
										</form>
									</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
						<?php
						}
						?>
					</tr>
					<?php 
					}
					?>
				</table>
			</div>
			<!-- Pagination -->
			<?php
			if(!isset($_GET['kls'])){ ?>
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
		</div>
	</div>
</main>
