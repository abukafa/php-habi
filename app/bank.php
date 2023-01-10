<?php include 'header.php';	?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Tabungan</h3>
		<div class="d-md-flex justify-content-between">
			<button class="btn btn-primary col-md-2 mb-2" data-bs-toggle="modal" data-bs-target="#myModal">Menabung</button>
			<form action="" method="get">
				<div class="input-group col-md-5 col-md-offset-7">
					<label class="input-group-text" for="tgl_ahir"><span data-feather="calendar"></span></label>
					<select type="submit" name="tgl_awal" class="form-control">
						<option>.. Tgl Awal ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct tgl from tabungan order by tgl desc");
						while($p=mysqli_fetch_array($pil)){
							?>
							<option><?php echo $p['tgl'] ?></option>
							<?php
						}
						?>			
					</select>
					<select type="submit" name="tgl_ahir" class="form-control" onchange="this.form.submit()">
						<option>.. Tgl Ahir ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct tgl from tabungan order by tgl desc");
						while($p=mysqli_fetch_array($pil)){
							?>
							<option><?php echo $p['tgl'] ?></option>
							<?php
						}
						?>			
					</select>
				</div>
			</form>
		</div>
		<?php 
		if(isset($_GET['tgl_ahir'])){
			$awl=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_awal']);
			$ahr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_ahir']);
			$tg="bank_laphis?tgl_awal=$awl&tgl_ahir=$ahr";
			$tg3="bank_lapsum";
			$tg4="bank_lapday?period='$ahr'";
		}else{
			$tg="bank_laphis";
			$tg3="bank_lapsum";
			$tg4="bank_lapday";
		}
		?>

		
		<div class="card mt-3">
			<div class="card-header d-xl-flex justify-content-between">
				<h5 class="card-title">
				<?php 
				if(isset($_GET['tgl_ahir'])){
					echo "Data Tanggal ". $_GET['tgl_awal']." s.d. ". $_GET['tgl_ahir']."</h5>";
				?>
				<div class="btn-group">
					<a href="<?php echo $tg3 ?>" target="_blank" class="btn btn-success">Summary</a>
					<a href="<?php echo $tg ?>" target="_blank" class="btn btn-success">History</a>
					<a href="<?php echo $tg4 ?>" target="_blank" class="btn btn-success">Daily</a>
				</div>
				<?php 
				}else{
					echo "Data Tabungan</h5>";
				}
				?>
				</h5>
			</div>	
			<div class="card-body">
				<table class="table">
					<tr>
						<th class="d-none d-md-table-cell">No</th>
						<th>Tanggal</th>
						<th class="d-none d-md-table-cell">NIS</th>
						<th>Nama</th>
						<td>Debit</td>			
						<td class="d-none d-md-table-cell">Kredit</td>
						<td class="d-none d-md-table-cell">Saldo</td>		
						<td>Opsi</td>
					</tr>
					<?php 
					$per_hal=30;
					$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from tabungan");
					$jum=mysqli_num_rows($jumlah_record);
					$halaman=ceil($jum / $per_hal);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $per_hal;
					
					if(isset($_GET['tgl_ahir'])){
						$awl=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_awal']);
						$ahr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_ahir']);
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from tabungan where tgl between '$awl' and '$ahr' order by tgl");
					}else{
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from tabungan order by no desc limit $start, $per_hal");
					}
					while($b=mysqli_fetch_array($brg)){
						?>
						<tr>
							<td class="d-none d-md-table-cell"><?php echo $b['no'] ?></td>
							<td class="d-none d-md-table-cell"><?php echo $b['tgl'] ?></td>
							<td><a href="bank_lapown?nis='<?php echo $b['nis']; ?>'"   target="_blank" ><?php echo $b['nis'] ?></a></td>
							
							<td><?php echo substr($b['nama'], 0, 20) ?></td>
							<td align="right"><?php echo number_format($b['debit'],0,'',','); ?></td>		
							<td align="right" class="d-none d-md-table-cell"><?php echo number_format($b['kredit'],0,'',','); ?></td>
							
							<?php
							$nis=$b['nis'];
							$tot=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $nis .", debit, 0)) as dbt, sum(if(nis=". $nis .", kredit, 0)) as kdt from tabungan");
							while($see=mysqli_fetch_assoc($tot)){
								$jml = $see['dbt'] - $see['kdt'];
								?>
								<td align="right" class="d-none d-md-table-cell"><?php echo number_format($jml,0,'',','); ?></td>
							
							<?php
							}
							?>
							<td>		
								<a href="bank_edit?no=<?php echo $b['no']; ?>" class="btn btn-warning"><span data-feather='edit'></span></a>				
								<a href="bank_lapstruk?no=<?php echo $b['no']; ?>"  target="_blank"  class="d-none d-md-inline-block btn btn-success"><span data-feather='printer'></span></a>
							</td>
						</tr>
						<?php 
					}
					?>
					
				</table>

				<!-- Pagination -->
				<?php
				if(!isset($_GET['tgl_ahir'])){ ?>
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
					if(isset($_GET['tgl_ahir'])){
						$awl=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_awal']);
						$ahr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_ahir']);
					}
					?>
					<input type="hidden" class="form-control" name="taw" value="<?php echo $awl; ?>" >
					<input type="hidden" class="form-control" name="tah" value="<?php echo $ahr; ?>">
					<button type="submit" name="Export-tabungan" class="btn btn-success button-loading" data-loading-text="Loading..."><span class='glyphicon glyphicon-download'></span>  Export</button>
					<!-- <form action="function" method="post" name="upload_excel" enctype="multipart/form-data"> -->
					<div class="input-group">
						<label class="col-lg-8 control-label" for="filebutton"></label>
						<input class="form-control" type="file" accept=".csv" name="file" id="file">
						<button type="submit" id="submit" name="Import-tabungan" class="btn btn-success button-loading" data-loading-text="Loading...">
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
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Input Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">				
				<form action="bank_act" method="post">	
					<div class="form-group mb-2">
						<label class="form-label">Tanggal</label>
						<input name="tgl" id="tgl" type="text" class="form-control" autocomplete="off">
					</div>			
					<div class="form-group mb-2">
						<label class="form-label">Nomor Induk Santri</label>								
						<select name="nis" id="nis" class="form-control" onchange="changeValue(this.value)">
							<option value=0>-Pilih-</option>
							<?php 
							$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri");
							$jsArray = "var sant = new Array();\n";        
							while($b=mysqli_fetch_array($brg)){
							echo '<option value="' . $b['nis'] . '">' . $b['nis'] ." ". $b['nama'] . '</option>';
							
							$jml=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $b['nis'] .", debit, 0)) as dbt, sum(if(nis=". $b['nis'] .", kredit, 0)) as kdt from tabungan");
							while($s=mysqli_fetch_assoc($jml)){

							$jsArray .= "sant['" . $b['nis'] . "'] = {nama:'" . addslashes($b['nama']) . "',ket_wali:'".addslashes($b['ket_wali']) . "',dbt:'".addslashes($s['dbt']) . "',kdt:'".addslashes($s['kdt']) . "'};\n";
							}
							}
							?>
						</select>
					</div>				
					<div class="form-group mb-2">
						<label class="form-label">Nama</label>
						<input name="nama" type="text" class="form-control" id="nama" readonly="yes">
					</div>	
					<div class="form-group mb-2">
						<label class="form-label">Nama Wali</label>
						<input name="wali" type="text" class="form-control" id="wali" readonly="yes">
					</div>				
					<div class="form-group mb-2">
						<label class="form-label">Saldo</label>
						<input name="saldo" id="saldo" type="text" class="form-control" autocomplete="off" readonly="yes" >
					</div>	
					<div class="form-group mb-2">
						<label class="form-label">Debit</label>
						<input name="debit" id="debit" type="text" class="form-control" value="0" autocomplete="off">
					</div>			
					<div class="form-group mb-2">
						<label class="form-label">Kredit</label>
						<input name="kredit" id="kredit" type="text" class="form-control" value="0" autocomplete="off">
					</div>	
					<div class="form-group mb-2">
						<label class="form-label">Keterangan</label>
						<input name="ket" type="text" class="form-control" autocomplete="off" value="-" >
					</div>		

					<script type="text/javascript">    
					<?php echo $jsArray; ?>  
					function changeValue(nis){  
					document.getElementById('nama').value = sant[nis].nama;
					document.getElementById('wali').value = sant[nis].ket_wali;
					document.getElementById('saldo').value = sant[nis].dbt-sant[nis].kdt;
					};  
					</script>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
$(function() {
    $('#tgl').datepicker({ 
    autoclose: true,
    todayHighlight: true,
    format : 'yyyy-mm-dd' 
    });
});
</script>
