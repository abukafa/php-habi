<?php include 'header.php';	

function createRandomPassword() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {
		$num = rand() % 33;
		$tmp = substr($chars, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}
$finalcode='FC-'.createRandomPassword();
?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Keuangan</h3>
		<div class="d-md-flex justify-content-between">
			<!-- <button class="btn btn-primary col-md-2" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Santri</button> -->
			<a href="finance_add?tgl=&vend=&ket=&inv=<?php echo $finalcode ?>" class="btn btn-primary mb-2">Tambah Transaksi</a>
			<form action="" method="get">
				<div class="input-group col-md-5 col-md-offset-7">
					<label class="input-group-text" id="basic-addon1"><span data-feather="search"></span></label>
					<select type="submit" name="tgl_awal" class="form-control">
						<option>.. Tgl Awal ..</option>
						<?php 
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct tgl from finance order by tgl desc");
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
						$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct tgl from finance order by tgl desc");
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
	</div>
	<?php 
	if(isset($_GET['tgl_ahir'])){
		$awl=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_awal']);
		$ahr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_ahir']);
		$period=date("M Y", strtotime($ahr));
		$tg="finance_lapper?period='$period'";
		$tg1="finance_laphis?tgl_awal=$awl&tgl_ahir=$ahr";
		$tg2="finance_lapsum?tgl_ahir=$ahr";
		$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT distinct inv from finance where tgl between '$awl' and '$ahr'");
		$record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from finance where tgl between '$awl' and '$ahr'");
	}else{
		$tg="finance_lapper";
		$tg1="finance_laphis";
		$tg2="finance_lapsum";
		$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT distinct inv from finance");
		$record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from finance");
	}
		$per_hal=30;
		$jum=mysqli_num_rows($jumlah_record);
		$item=mysqli_num_rows($record);
		$halaman=ceil($jum / $per_hal);
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
		$start = ($page - 1) * $per_hal;
	?>

	<!-- View Table Data Pembuangan -->
	<div class="card mt-3">
		<div class="card-header d-xl-flex justify-content-between">
			<h5 class="card-title">
			<?php 
			if(isset($_GET['tgl_ahir'])){
				echo $jum ." Transaksi (". $item ." Item) di Tanggal ". $_GET['tgl_awal']." s.d. ". $_GET['tgl_ahir'];
			?>
			</h5>
			<div class="btn-group float-end">
				<a href="<?php echo $tg2 ?>" target="_blank" class="btn btn-success">Allocation</a>
				<a href="<?php echo $tg1 ?>" target="_blank" class="btn btn-success">Report</a>
				<a href="<?php echo $tg ?>" target="_blank" class="btn btn-success">Periodic</a>
			</div>
			<?php 
			}else{
				echo 'Data Pembukuan</h5>';
			}
			?>
		</div>
		<div class="card-body">
			<table class="table">
				<tr>
					<th class="d-none d-md-table-cell">No</th>
					<th>Invoice</th>
					<th class="d-none d-md-table-cell">Period</th>
					<th class="d-none d-xl-table-cell">Keterangan</th>
					<th class="text-end">Item</th>
					<th class="text-end">Amount</th>
					<th>Opsi</th>
				</tr>
				<?php 
				if(isset($_GET['tgl_ahir'])){
					$awl=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_awal']);
					$ahr=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['tgl_ahir']);
					$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct inv, period, ket from finance where tgl between '$awl' and '$ahr' order by no desc");
				}else{
					$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct inv, period, ket from finance order by no desc limit $start, $per_hal");
				}
				$no=1;
				while($b=mysqli_fetch_array($brg)){
					$invo=$b['inv'];
					?>
					<tr>
						<td class="d-none d-md-table-cell"><?php echo $no ?></td>
						<td><?php echo $invo ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['period'] ?></td>
						<td class="d-none d-xl-table-cell"><?php echo $b['ket'] ?></td>
						<?php
						$dat=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from finance where inv='$invo' ");
						$query=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(inv='$invo', debit, 0)) as dbt, sum(if(inv='$invo', kredit, 0)) as krd from finance");
						while($que=mysqli_fetch_array($query)){
						$amon = $que['krd'] - $que['dbt'];
						$data=mysqli_num_rows($dat); 
							?>
							<td class="text-end"><?php echo number_format($data,0,'',',') ?></td>
							<td class="text-end"><?php echo number_format($amon,0,'',',') ?></td>
						<?php
						}
						?>
						<td>		
							<a href="finance_add?tgl=&vend=&ket=&inv=<?php echo $b['inv'] ?>" class="btn btn-warning"><span data-feather="edit"></span></a>
							<a href="fin_lapstruk?inv=<?php echo $b['inv']; ?>"  target="_blank"  class="d-none d-md-inline-block btn btn-success"><span data-feather="printer"></span></a>
						</td>
					</tr>
					<?php 
				$no++;
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
				<input type="hidden" class="form-control" name="taw" value="<?php echo $awl; ?>">
				<input type="hidden" class="form-control" name="tah" value="<?php echo $ahr; ?>">
				<button type="submit" name="Export-finance" class="btn btn-success button-loading" data-loading-text="Loading...">Export</button>
				<!-- <form action="function" method="post" name="upload_excel" enctype="multipart/form-data"> -->
				<div class="input-group">
					<label class="col-lg-8 control-label" for="filebutton"></label>
					<input class="form-control" type="file" accept=".csv" name="file" id="file">
					<button type="submit" id="submit" name="Import-finance" class="btn btn-success button-loading" data-loading-text="Loading...">
						<span data-feather="upload"></span> Import
					</button>
				</div>
				<!-- </form> -->
			</div>
		</div>
	</div>
</main>

<script type="text/javascript">
	$(document).ready(function(){
		$("#tgl").datepicker({dateFormat : 'yy-mm-dd'});							
	});
</script>
