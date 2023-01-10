<?php include 'header.php'; ?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Santri</h3>
		<div class="d-flex justify-content-between">
			<button class="btn btn-primary col-md-2 mb-2" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Santri</button>
			
			<!-- Filter Data Santri -->
			<form action="" method="get">
				<div class="input-group">
					<label class="input-group-text" for="kls"><span data-feather="search"></span></label>
					<select type="submit" id="kls" name="kls" class="form-select" onchange="this.form.submit()">
						<option>.. Pilih ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct kelas from santri order by kelas desc");
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
		
		<!-- View Table Data Santri -->
		<div class="card mt-3">
			<div class="card-header d-md-flex justify-content-between">
				<h5 class="card-title">
					<?php 
					if(isset($_GET['kls'])){
						echo 'Data Santri Kelas '. $_GET['kls'].' Tahun '.date('Y');
						$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
						$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri where kelas='$kls'");
					?>
				</h5>
				<div class="btn-group float-end">
					<a href="santri_lapind" class="btn btn-success" target="_blank">Rekap</a>
					<a href="santri_lapbio" class="btn btn-success" target="_blank">Biodata</a>
					<a href="santri_lapwali" class="btn btn-success" target="_blank">Absensi</a>
					<a href="santri_lapsyah" class="btn btn-success" target="_blank">Syahadah</a>
				</div> 
				<?php 
				}else{
					echo 'Data Santri</h5>';
					$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri");
					$per_hal=20;
					$jum=mysqli_num_rows($jumlah_record);
					$halaman=ceil($jum / $per_hal);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $per_hal;
				}
				?>
			</div>
			<div class="card-body">
				<table class="table table-hover">
					<tr>
						<th class="d-none d-md-table-cell">NIS</th>
						<th>Nama Santri</th>
						<th class="d-none d-md-table-cell">Kelas</th>
						<th class="d-none d-md-table-cell">Kota Asal</th>
						<th class="d-none d-lg-table-cell">Nama Wali</th>
						<th>Opsi</th>
					</tr>
					<?php 
					if(isset($_GET['kls'])){
						$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where kelas = '$kls' order by nis");
					}else{
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri order by kelas, nama limit $start, $per_hal");
					}
					$no=1;
					while($b=mysqli_fetch_array($brg)){
					?>
					<tr>
						<td class="d-none d-md-table-cell"><?php echo $b['nis'] ?></td>
						<td><?php echo $b['nama'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['kelas'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['kab'] ?></td>
						<td class="d-none d-lg-table-cell"><?php echo $b['ket_wali'] ?></td>
						<td>
							<!-- <a href="det_Santri?id=<?php echo $b['nis']; ?>" class="btn btn-info">Detail</a> -->
							<a href="santri_edit?id=<?php echo $b['nis']; ?>" class="btn btn-warning"><span data-feather="edit"></span></a>
							<a href="santri_lapdata?id=<?php echo $b['nis']; ?>"  target="_blank"  class="d-none d-md-inline-block btn btn-success"><span data-feather="printer"></span></a>
							<?php 
                            if($u['uinfo'] == 'Superuser'){
                            ?>
							<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='santri_delete?id=<?php echo $b['nis']; ?>' }" class="btn btn-danger"><span data-feather="trash"></span></a>
							<?php 
							}
							?>
						</td>
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
					<button type="submit" name="Export-santri" class="btn btn-success button-loading" data-loading-text="Loading..."><span class='glyphicon glyphicon-download'></span>  Export</button>
					<!-- <form action="function" method="post" name="upload_excel" enctype="multipart/form-data"> -->
					<div class="input-group">
						<label class="col-lg-8 control-label" for="filebutton"></label>
						<input class="form-control" type="file" accept=".csv" name="file" id="file">
						<button type="submit" id="submit" name="Import-santri" class="btn btn-success button-loading" data-loading-text="Loading...">
							<span data-feather="upload"></span> Import
						</button>
					</div>
					<!-- </form> -->
				</div>
			</div>
		</div>
	</div>
</main>

<!-- modal input -->
<div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Tambah Santri Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="santri_act" method="post">
					<div class="form-group mb-3">
						<label class="form-label">Nomor Induk Santri</label>
						<input name="id" type="text" class="form-control" placeholder="00.0.0.00">
						<small class="text-muted">[00] Tahun, [0] JK, [0] Kls, [00] No. Urut</small>
					</div>
					<div class="form-group mb-3">
						<label class="form-label">Nama Santri</label>
						<input name="nama" type="text" class="form-control" placeholder="diisi dengan Nama Lengkap ..">
					</div>
					<div class="form-group mb-3">
						<label class="form-label">Nama Panggilan</label>
						<input name="panggilan" type="text" class="form-control" placeholder="Nama Panggilan sehari-hari ..">
					</div>
					<div class="form-group mb-3">
						<label class="form-label">Jenis Kelamin</label>
						<select name="kelamin" type="text" class="form-control">
							<option value="">.. Pilih ..</option>
							<option>Laki-laki</option>		
							<option>Perempuan</option>		
						</select>
					</div>
					<div class="form-group mb-3">
						<label class="form-label">Kelas</label>
						<select name="kelas" type="text" class="form-control">
							<option value="">.. Pilih ..</option>
							<option>Awal 1</option>		
							<option>Awal 2</option>		
							<option>Awal 3</option>		
							<option>Qonuni 1</option>		
							<option>Qonuni 2</option>		
							<option>Qonuni 3</option>
						</select>
					</div>	
					<div class="form-group mb-3">
						<label class="form-label">Wali Santri</label>
						<input name="wali" type="text" class="form-control" placeholder="Nama Wali Santri ..">
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