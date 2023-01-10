<?php include 'header.php';	?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Transaksi</h3>
		<div class="d-flex justify-content-between">
			<a class="btn" href="finance"><span data-feather="arrow-left"></span>Kembali</a>
		</div>

		<div class="card mt-3">
			<div class="card-header">
				<h5 class="card-title">Input Transaksi</h5>
			</div>
			<div class="card-body">
				<form class="row g-3" action="finance_act" method="post">
					<input type="hidden" class="form-control" name="no" readonly="yes">
					<div class="col-md-4 mb-2">
						<label class="form-label">Invoice</label>
						<input type="text" class="form-control" name="inv" value="<?php echo $_GET['inv']; ?>" readonly="yes">
					</div>
					<div class="col-md-4 mb-2">
						<label class="form-label">Tanggal</label>
						<input type="text" class="form-control" name="tgl" id="tgl" value="<?php echo $_GET['tgl']; ?>" autocomplete="off">
					</div>
					<div class="col-md-4 mb-2">
						<label class="form-label">Vendor</label>
						<input type="text" class="form-control" name="vendor" id="vendor" value="<?php echo $_GET['vend']; ?>">
					</div>
					<div class="col-md-8 mb-2">
						<label class="form-label">Uraian</label>
						<input type="text" class="form-control" name="uraian">
					</div>
					<div class="col-md-4 mb-2">
						<label class="form-label">Jumlah</label>
						<input type="text" class="form-control" name="amon">
					</div>
					<div class="col-md-4 mb-2">
						<label class="form-label">Keterangan</label>
						<input type="text" class="form-control" name="ket" id="ket" value="<?php echo $_GET['ket']; ?>">
					</div>
					<div class="col-md-4 mb-2">
						<label class="form-label">Akun</label>
						<select name="akun" class="form-select">
							<option value="-"></option>
							<option value="000221">000221 - Biaya Administrasi</option>
							<option value="000222">000222 - Biaya Pembangunan</option>
							<option value="000223">000223 - Biaya Pendidikan</option>
							<option value="000224">000224 - Biaya Seragam</option>
							<option value="000225">000225 - Biaya Pembinaan</option>
							<option value="000226">000226 - Biaya Dapur</option>
							<option value="000227">000227 - Biaya Operasional</option>
							<option value="000228">000228 - Biaya Asrama</option>
							<option value="777199">777199 - Pemasukan</option>
						</select>
					</div>
					<div class="col-md-4 mb-2">
						<label class="form-label">Total</label>
						<?php 
						$inv=$_GET['inv'];
						$query=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(debit) as dbt, sum(kredit) as kdt from finance where inv='$inv' ");
						while($t=mysqli_fetch_assoc($query)){
						$total = $t['dbt'] - $t['kdt'];
						?>
						<input type="text" class="form-control" name="total" align="right" value="<?php echo number_format($total,0,'',','); ?>" readonly="yes">
						<?php		
						}
						?>		
					</div>
					<div class="col-md-4 mb-2">
						<input type="submit" class="btn btn-primary" value="Simpan" onclick="readonly()">
						<a href="finance" class="btn btn-secondary"> Selesai</a>
					</div>
				</form>
			</div>
		</div>
	
		<?php
			$jum=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from finance where inv='$inv' ");
			$jum=mysqli_num_rows($jum); 
			echo "<h4 class='text-center'>(". $jum ." item) dalam Satu Transaksi</h4>";
		?>

		<div class="card mt-4">
			<div class="card-header">
				<h5 class="card-title">Rincian Transaksi</h5>
			</div>
			<div class="card-body">
				<table class="table">
					<tr>
						<th class="d-none d-md-table-cell">No</th>
						<th class="d-none d-md-table-cell">Tanggal</th>
						<th>Vendor</th>
						<th class="d-none d-md-table-cell">Akun</th>
						<th>Uraian</th>				
						<th>Debit</th>
						<th>Kredit</th>
						<th>Opsi</th>
					</tr>
						<?php 
						if(isset($_GET['inv'])){
							$inv=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['inv']);
							$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from finance where inv='$inv' order by no desc");
						}else{
							$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from finance order by no desc");
						}
						$no=1;
						while($b=mysqli_fetch_array($brg)){
						?>
					<tr>
						<td class="d-none d-md-table-cell"><?php echo $b['no'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['tgl'] ?></td>
						<td><?php echo $b['vendor'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $b['akun'] ?></td>
						<td><?php echo $b['uraian'] ?></td>
						<td align="right"><?php echo number_format($b['debit'],0,'',','); ?></td>	
						<td align="right"><?php echo number_format($b['kredit'],0,'',','); ?></td>
						<td>
							<a href="finance_edit?inv=<?php echo $b['inv']; ?>&no=<?php echo $b['no']; ?>" class="btn btn-warning"><span data-feather="edit"></span></a>
							<?php 
                            if($u['uinfo'] == 'Superuser'){
                            ?>
							<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='finance_delete?no=<?php echo $b['no']; ?>' }" class="btn btn-danger"><span data-feather="trash"></span></a>
							<?php 
							}
							$no=$no+1;
							}
							?>
						</td>
					</tr>	
				</table>
			</div>
		</div>
	</div>
</main>
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
function readonly()
{
	$('#tgl').attr('readonly', true);
	$('#vendor').attr('readonly', true);
	$('#ket').attr('readonly', true);
} 
</script>