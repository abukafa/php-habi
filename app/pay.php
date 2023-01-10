<?php include 'header.php';	?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Pembayaran</h3>
		<div class="d-md-flex justify-content-between">
			<button class="btn btn-primary col-md-2 mb-2" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Transaksi</button>
			<a class="btn" href="beban"><span data-feather="arrow-left"></span> Data Beban</a>

			<!-- Filter Data Bayaran -->
			<form action="" method="get">
				<div class="input-group col-md-5 col-md-offset-7">
					<label class="input-group-text" for="tgl_ahir"><span data-feather="calendar"></span></label>
					<!-- <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span> -->
					<select type="submit" name="tgl_awal" class="form-control">
						<option>.. Tgl Awal ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct tgl from bayaran order by tgl desc");
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
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct tgl from bayaran order by tgl desc");
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
			$prd=date("M-Y", strtotime($ahr));
			$mon=date("m");
			$yer=date("Y", strtotime($ahr));
			if( $mon >= 7 ){
				$yr=date("Y");
			}else{
				$yr=date("Y")-1;
			}
			$tg="pay_laphis?tgl_awal=$awl&tgl_ahir=$ahr";
			$tg2="pay_lapsumspp?thn=$yer";
			$tg4="pay_lapout?thn='$yr'";
			$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from bayaran where tgl between '$awl' and '$ahr'");
		}else{
			$tg="pay_laphis";
			$tg2="pay_lapsumspp";
			$tg4="pay_lapout";
			$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from bayaran");
		}
			$per_hal=30;
			$jum=mysqli_num_rows($jumlah_record);
			$halaman=ceil($jum / $per_hal);
			$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
			$start = ($page - 1) * $per_hal;

		?>


		<!-- View Table Data Bayaran -->
		<div class="card mt-3">
			<div class="card-header d-xl-flex justify-content-between">
				<h5 class="card-title">
				<?php 
				if(isset($_GET['tgl_ahir'])){
					echo $jum ." Pembayaran Tanggal ". $_GET['tgl_awal']." s.d. ". $_GET['tgl_ahir'] . "</h5>";
				?>
				<div class="btn-group float-end">
					<a href="<?= $tg4 ?>" target="_blank" class="btn btn-success">Outstanding</a>
					<a href="<?= $tg2 ?>" target="_blank" class="btn btn-success">Summary</a>
					<a href="<?= $tg ?>" target="_blank" class="btn btn-success">History</a>
				</div>
				<?php 
				}else{
					echo "Data Pembayaran Santri</h5>";
					echo "<a class='btn btn-primary' href='pay_tag'>Pencarian</a>";
				}
				?>
			</div>
			<div class="card-body">
				<table class="table table-hover">
					<tr>
						<th class="d-none d-md-table-cell">No</th>
						<th>Tanggal</th>
						<th>NIS</th>
						<th class="d-none d-md-table-cell">Nama</th>
						<th class="d-none d-lg-table-cell">Tahun</th>			
						<th class="d-none d-lg-table-cell">Bulan</th>			
						<th class="d-none d-lg-table-cell">Keterangan</th>
						<th>jumlah</th>
						<th>Opsi</th>
					</tr>
					<?php 
					if(isset($_GET['tgl_ahir'])){
						$awl=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_awal']);
						$ahr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_ahir']);
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bayaran where tgl between '$awl' and '$ahr' order by tgl");
					}else{
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bayaran order by no desc limit $start, $per_hal");
					}
					$no=1;
					while($b=mysqli_fetch_array($brg)){
						?>
						<tr>
							<td class="d-none d-md-table-cell"><?php echo $b['no'] ?></td>
							<td><?php echo $b['tgl'] ?></td>
							<?php	
							$nis=$b['nis'];
							$yer=$b['thn'];
							$tg="pay_laptag?nis='$nis'&yer='$yer'"; ?>
							<td><a href="<?php echo $tg ?>"   target="_blank" ><?php echo $b['nis'] ?></a></td>
							<td class="d-none d-md-table-cell"><?php echo substr($b['nama'], 0, 20) ?></td>
							<td class="d-none d-lg-table-cell"><?php echo $b['thn'] ?></td>
							<td class="d-none d-lg-table-cell"><?php echo $b['bln'] ?></td>				
							<td class="d-none d-lg-table-cell"><?php echo $b['ket'] ?></td>
							<td align="right"><?php echo number_format($b['jumlah'],0,'',','); ?></td>	
							<td>		
								<a href="pay_edit?no=<?php echo $b['no']; ?>" class="btn btn-warning"><span data-feather='edit'></span></a>
								<a href="pay_lapstruk2?no=<?php echo $b['no']; ?>"  target="_blank"  class="d-none d-md-inline-block btn btn-success"><span data-feather='printer'></span></a>
								<?php 
								if($u['uinfo'] == 'Superuser'){
								?>
								<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='pay_delete?no=<?php echo $b['no']; ?>' }" class="btn btn-danger"><span data-feather='trash'></span></a>
								<?php 
								}
								?>
							</td>
						</tr>
						<?php 
					}
					$tg="pay_laptag";
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
					<input type="hidden" class="form-control" name="taw" value="<?php echo $awl; ?>">
					<input type="hidden" class="form-control" name="tah" value="<?php echo $ahr; ?>">
					<button type="submit" name="Export-bayaran" class="btn btn-success button-loading" data-loading-text="Loading..."><span class='glyphicon glyphicon-download'></span>  Export</button>
					<!-- <form action="function" method="post" name="upload_excel" enctype="multipart/form-data"> -->
					<div class="input-group">
						<label class="col-lg-8 control-label" for="filebutton"></label>
						<input class="form-control" type="file" accept=".csv" name="file" id="file">
						<button type="submit" id="submit" name="Import-bayaran" class="btn btn-success button-loading" data-loading-text="Loading...">
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
				<h5 class="modal-title" id="staticBackdropLabel">Transaksi Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
				<div class="modal-body">				
					<form action="pay_act" method="post">	
						<div class="form-group mb-2">
							<label class="form-label">Tanggal</label>
							<input name="tgl" type="text" class="form-control" id="tgl" autocomplete="off">
						</div>			
						<div class="form-group mb-2">
							<label class="form-label">Nomor Induk Santri</label>								
							<select name="nis" id="nis" class="form-control" onchange="changeValue(this.value)">
							<option value=0>-Pilih-</option>
								<?php 
								$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where kelas<>'XXX' order by nama");
								$jsArray = "var sant = new Array();\n";        
								while($b=mysqli_fetch_array($brg)){
								echo '<option value="' . $b['nis'] . '">' . $b['nis'] ." - ". $b['nama'] . '</option>';
								$jsArray .= "sant['" . $b['nis'] . "'] = {nama:'" . addslashes($b['nama']) . "',ket_wali:'".addslashes($b['ket_wali']) . "'};\n";
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
							<input name="ayah" type="text" class="form-control" id="ayah" readonly="yes">
						</div>	

						<script type="text/javascript">    
						<?php echo $jsArray; ?>  
						function changeValue(nis){  
						document.getElementById('nama').value = sant[nis].nama;
						document.getElementById('ayah').value = sant[nis].ket_wali;
						};  
						</script>
										
						<?php $mynum = 1234.56; ?>
						
						<div class="form-group mb-2">
							<label class="form-label">Periode Tahun Pembayaran</label>
							<!--input name="tahun" type="text" class="form-control" value="-"-->
							
							<select name="tahun" class="form-control" value="-">
							<option value="-">Tahun - Harus diisi</option>
							<?php
								for($i=2017; $i<=date('Y')+2; $i++){
								echo"<option value='$i'> $i </option>";
								}
								?>
							</select>
							
						</div>	
						<div class="form-group mb-2">
							<label class="form-label">Pendaftaran</label>
							<input name="daftar" id="daftar" type="text" class="form-control" value="0" > <!--onkeyup="this.value=numbe(this.value);"-->
						</div>
						<div class="form-group mb-2">
							<label class="form-label">Infaq Bangunan</label>
							<input name="bangunan" id="bangunan" type="text" class="form-control" value="0" autocomplete="off">
						</div>	
						<div class="form-group mb-2">
							<label class="form-label">Infaq Pendidikan</label>
							<input name="pendidikan" id="pendidikan" type="text" class="form-control" value="0" autocomplete="off">
						</div>			
						<div class="form-group mb-2">
							<label class="form-label">Seragam</label>
							<input name="seragam" id="seragam" type="text" class="form-control" value="0" autocomplete="off">
						</div>	
						<div class="form-group mb-2">
							<label class="form-label">Keterangan Bulan (unt Pembayaran SPP Bulanan)</label>
							<select name="bln" type="text" class="form-control" value="-" >
							<option value="-">Bulan</option>
								<?php
								$bulan=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
								$jlh_bln=count($bulan);
									for($i=2017; $i<=date('Y')+2; $i++){
								for($c=0; $c<$jlh_bln; $c+=1){
										echo"<option value=$bulan[$c]-$i> $bulan[$c]-$i </option>";
										}
									}
								?>
							</select>		
						</div>	
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
							<input name="lain" type="text" class="form-control" autocomplete="off" value="0" >
						</div>			
						<div class="form-group mb-2">
							<label class="form-label">Keterangan</label>
							<input name="ket" type="text" class="form-control" autocomplete="off" value="-" >
						</div>			
						<div class="form-group mb-2">
							<label class="form-label"></label>
							<input name="jumlah" id="jumlah" type="hidden" class="form-control" readonly="yes">
						</div>
						
						<script>
						function numbe(nStr){
						nStr += '';
						x = nStr.split('.');
						x1 = x[000];
						x2 = x.length > 1 ? '.' + x[1] : '';
						var rgx = /(\d+)(\d{3})/;
						while (rgx.test(x1)) {
							x1 = x1.replace(rgx, '$1' + ',' + '$2');
						}
						return x1 + x2;
						}
						</script>
						
						<script type="text/javascript">    
						document.getElementById("jumlah").addeventlistener("clickValue", show_sum);
						function show_sum(){
						var df = document.getElementById("daftar").value
						var bg = document.getElementById("bangunan").value
						var pd = document.getElementById("pendidikan").value
						var sr = document.getElementById("seragam").value
						document.getElementById("jumlah").value = df + bg + pd + sr ;
						};  
						</script>
						
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
