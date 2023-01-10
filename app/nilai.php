<?php include 'header.php';	?>

<main class="content">
	<div class="container-fluid p-0">
		
		<h3 class="display-6"><span class=""></span>Penilaian</h3>
		<div class="d-md-flex justify-content-between">
			<button class="btn btn-primary col-md-2 mb-2" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Nilai</button>
			<a class="btn" href="nilaiperorg"><span data-feather="arrow-left"></span>  Data Personal</a>
			
			<!-- Filter Data Santri -->
			<form action="" method="get">
				<div class="input-group">
					<label class="input-group-text" for="kls"><span data-feather="search"></span></label>
					<select type="submit" name="materi" class="form-control">
						<option>.. Pelajaran ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct materi from nilai order by materi");
						while($p=mysqli_fetch_array($pil)){
							?>
							<option><?php echo $p['materi'] ?></option>
							<?php
						}
						?>			
					</select>
					<select type="submit" name="smt" class="form-control">
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
			$mtr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['materi']);
			$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
			$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
			$tg="nilai_lapalrpt?smt=$smt&thn=$thn";
			$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from nilai where thn='$thn' and smt='$smt' and materi='$mtr'");
			
		}else{
			$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from nilai");
			$tg="nilai_lapalrpt";
		}
			$per_hal=30;
			$jum=mysqli_num_rows($jumlah_record);
			$halaman=ceil($jum / $per_hal);
			$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
			$start = ($page - 1) * $per_hal;
			
		?>

		<!-- View Table Data nilai -->
		<div class="card mt-3">
			<div class="card-header d-md-flex justify-content-between">
				<h5 class="card-title">
				<?php 
				if(isset($_GET['thn'])){
					echo $jum ." Data (". $mtr .") ". $thn." Smt ". $smt;
				?>
				</h5>
				<a style="margin-bottom:10px" href="<?php echo $tg ?>" target="_blank" class="btn btn-success pull-right">All Rapot</a>
				<?php 
				}else{
					echo 'Data Penilaian Per Pelajaran</h5>';
				}
				?>
			</div>
			<div class="card-body">
				<table class="table table-hover">
					<tr>
						<th class="d-none d-md-table-cell">No</th>
						<th class="d-none d-md-table-cell">NIS</th>
						<th>Nama</th>
						<th class="d-none d-md-table-cell">Kelas</th>
						<th class="d-none d-md-table-cell">Pelajaran</th>			
						<th>NA</th>
						<th class="d-none d-lg-table-cell">Deskripsi</th>		
						<th></th>
					</tr>
					<?php 
					if(isset($_GET['thn'])){
						$mtr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['materi']);
						$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
						$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from nilai where thn='$thn' and smt='$smt' and materi='$mtr' order by kls, nama");
					}else{
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from nilai order by no desc limit $start, $per_hal");
					}
					while($b=mysqli_fetch_array($brg)){
						?>
					<tr>
						<td class="d-none d-md-table-cell"><?php echo $b['no'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['nis'] ?></td>
						<td><?php echo $b['nama'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['kls'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['materi'] ?></td>
						<td><?php echo $b['angka'] ?></td>
						<td class="d-none d-lg-table-cell"><?php echo $b['desk'] ?></td>
						<td>
						<?php 
						if(isset($_GET['thn'])){
						?>
							<a href="#" type="button" class="btn btn-warning btn-md" data-bs-toggle="modal" data-bs-target="#EModal<?php echo $b['no']; ?>"><span data-feather="edit"></span></a>
							<a href="nilai_laprapot?nis=<?php echo $b['nis']; ?>&tahun=<?php echo $b['thn']; ?>&semester=<?php echo $b['smt']; ?>"  target="_blank"  class="btn btn-success d-none d-lg-inline-block"><span data-feather='printer'></span></a>
							<?php 
                            if($u['uinfo'] == 'Superuser'){
                            ?>
							<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='nilai_delete?no=<?php echo $b['no']; ?>materi=<?php echo $b['materi']; ?>&smt=<?php echo $b['smt']; ?>&thn=<?php echo $b['thn']; ?>' }" class="btn btn-danger"><span data-feather="trash"></span></a>
							<?php 
							}
							?>
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
										<form role="form" action="nilai_update" method="post">
											<input type="hidden" name="no" value="<?php echo $row['no']; ?>">
											<div class="form-group mb-2">
												<label class="form-label"><?php echo $row['nis']; ?> -- <?php echo $row['nama']; ?> -- <?php echo $row['kls']; ?></label> 
											</div>
											<div class="form-group mb-2">
												<label class="form-label">Tahun</label>
												<input name="thn" type="text" class="form-control" value="<?php echo $row['thn']; ?>" readonly="yes">
											</div>
											<div class="form-group mb-2">
												<label class="form-label">Semester</label> 
												<input name="smt" type="text" class="form-control" value="<?php echo $row['smt']; ?>" readonly="yes">
											</div>
											<div class="form-group mb-2">
												<label class="form-label">Pelajaran</label>   
												<input name="mtr" type="text" class="form-control" value="<?php echo $row['materi']; ?>" readonly="yes">
											</div>
											<div class="form-group mb-2">
												<label class="form-label">Edit Nilai Akhir</label>
												<input name="na" type="text" class="form-control" value="<?php echo $row['angka']; ?>">
											</div>	
											<div class="form-group mb-2">
												<label class="form-label">Edit Deskripsi</label>
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
						</div>

						<?php
						}
						?>
					</tr>
					<?php 
					}
					?>
				</table>

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
				
				<!-- Import & Export data -->
				<div class="d-flex justify-content-between">
					<button type="submit" name="Export-nilai" class="btn btn-success button-loading" data-loading-text="Loading..."><span class='glyphicon glyphicon-download'></span>  Export</button>
					<!-- <form action="function" method="post" name="upload_excel" enctype="multipart/form-data"> -->
					<div class="input-group">
						<label class="col-lg-8 control-label" for="filebutton"></label>
						<input class="form-control" type="file" accept=".csv" name="file" id="file">
						<button type="submit" id="submit" name="Import-nilai" class="btn btn-success button-loading" data-loading-text="Loading...">
							<span data-feather="upload"></span> Import
						</button>
					</div>
					<!-- </form> -->
				</div>


				<!-- Export data -->
				<?php
				if(isset($_GET['thn'])){
					$mtr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['materi']);
					$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
					$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
				?>
				<form class="form-horizontal" action="function" method="post" name="upload_excel" enctype="multipart/form-data">
					<table class="table">
						<td><div class="form-group mb-2">
								<input type="hidden" class="form-control" name="taw" value="<?php echo $awl; ?>" >
								<input type="hidden" class="form-control" name="tah" value="<?php echo $ahr; ?>">
								<label class="col-md-9 control-label" >Download CSV file</label>
							<div class="col-md-1.2">
								<button type="submit" id="submit" name="Export-nilai" class="btn btn-success button-loading" data-loading-text="Loading..."><span class='glyphicon glyphicon-download'></span>  Export</button>
							</div>
						</td>
					</table>
				</form>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</main>

<!-- modal input -->
<div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Tambah Nilai Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">				
					<form action="nilai_act" method="post">	
						<div class="form-group mb-2">
							<label class="form-label">Tahun</label>
							<select name="thn" class="form-control" type="text">
								<option value="">.. Pilih ..</option>
								<option value="<?php echo date('Y')-1 ?>"><?php echo date('Y')-1 ?></option>
								<option value="<?php echo date('Y') ?>"><?php echo date('Y') ?></option>
								<option value="<?php echo date('Y')+1 ?>"><?php echo date('Y')+1 ?></option>
							</select>
						</div>			
						<div class="form-group mb-2">
							<label class="form-label">Semester</label>
							<select name="smt" class="form-control" type="text">
								<option value="">...</option>
								<option value=1>Smt 1 - Ganjil</option>
								<option value=2>Smt 2 - Genap</option>
							</select>
						</div>			
						<div class="form-group mb-2">
							<label class="form-label">Nomor Induk Santri</label>								
							<select name="nis" id="nis" class="form-control" onchange="changeValue(this.value)">
							 <option value=0>...</option>
								<?php 
								$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas<>'XXX' order by nama");
								$jsArray = "var sant = new Array();\n";        
								while($b=mysqli_fetch_array($brg)){
								echo '<option value="' . $b['nis'] . '">' . $b['nis'] ." ". $b['nama'] . '</option>';
								$jsArray .= "sant['" . $b['nis'] . "'] = {nama:'" . addslashes($b['nama']) . "',kelas:'".addslashes($b['kelas']) . "'};\n";
								}
								?>
							</select>
						</div>				
						<div class="form-group mb-2">
							<label class="form-label">Nama</label>
							<input name="nama" type="text" class="form-control" id="nama" readonly="yes">
						</div>	
						<div class="form-group mb-2">
							<label class="form-label">Kelas</label>
							<input name="kelas" type="text" class="form-control" id="kelas" readonly="yes">
						</div>	

						<script type="text/javascript">    
						<?php echo $jsArray; ?>  
						function changeValue(nis){  
						document.getElementById('nama').value = sant[nis].nama;
						document.getElementById('kelas').value = sant[nis].kelas;
						};  
						</script>
						<div class="form-group mb-2">
							<label class="form-label">Materi Pelajaran</label>
							<select name="mtr" class="form-control" type="text">
								<option value="">...</option>
								<option value="1.1. IMAN : Pemahaman">IMAN : Pemahaman</option>
								<option value="1.2. IMAN : Sikap">IMAN : Sikap</option>
								<option value="1.3. ALQURAN : Talaqqi">ALQURAN : Talaqqi</option>
								<option value="1.4. ALQURAN : Tahfidz">ALQURAN : Tahfidz</option>
								<option value="1.5. ALQURAN : Tahsin">ALQURAN : Tahsin</option>
								<option value="1.6. ALQURAN : Kitabah">ALQURAN : Kitabah</option>
								<option value="2.1. TAUHID">TAUHID</option>
								<option value="2.2. PRAKTEK IBADAH">PRAKTEK IBADAH</option>
								<option value="2.3. BACA TULIS">BACA TULIS</option>
								<option value="2.4. BERHITUNG">BERHITUNG</option>
								<option value="2.5. SAINS">SAINS</option>
								<option value="2.6. SOSIAL">SOSIAL</option>
								<option value="3.1. HADITS">HADITS</option>
								<option value="3.2. KISAH">KISAH</option>
								<option value="3.3. BAHASA ARAB">BAHASA ARAB</option>
								<option value="3.4. BAHASA INGGRIS">BAHASA INGGRIS</option>
								<option value="3.5. OLAH RAGA">OLAH RAGA</option>
								<option value="3.6. LIFE SKILL">LIFE SKILL</option>
							</select>
						</div>
						<div class="form-group mb-2">
							<label class="form-label">Nilai Akhir</label>
							<input name="na" type="text" class="form-control" value="-" autocomplete="off">
						</div>	
						<div class="form-group mb-2">
							<label class="form-label">Deskripsi</label>
							<textarea name="desk" type="text" class="form-control" value="-" autocomplete="off" rows="7"></textarea>
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
</div>