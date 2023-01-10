<?php 
include 'header.php';
?>

<main class="content">
	<div class="container p-0">
		<h3 class="display-6"><span class=""></span>Edit Item</h3>
		<div class="d-flex justify-content-between">
			<a class="btn" href="bank"><span data-feather="arrow-left"></span>Kembali</a>
		</div>
		<div class="card mt-3">
			<div class="card-header">
				<div class="card-title">
					Item Tabungan
				</div>
			</div>
			<div class="card-body">
				<?php
				$id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['no']);
				$det=mysqli_query($GLOBALS["___mysqli_ston"], "select * from tabungan where no='$id'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($d=mysqli_fetch_array($det)){
				?>					
				<form action="bank_update" method="post">
					<table class="table">
						<tr>
							<td></td>
							<td><input type="hidden" name="no" value="<?php echo $d['no'] ?>"></td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td><input type="text" class="form-control" name="tgl" id="tgl" value="<?php echo $d['tgl'] ?>"></td>
						</tr>
						<tr>
							<td>NIS</td>
							<td><input type="text" class="form-control" name="nis" value="<?php echo $d['nis'] ?>" readonly="yes"></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td><input type="text" class="form-control" name="nama" value="<?php echo $d['nama'] ?>" readonly="yes"></td>
						</tr>
						<tr>
							<td>Nama Wali</td>
							<td><input type="text" class="form-control" name="wali" value="<?php echo $d['wali'] ?>" readonly="yes"></td>
						</tr>
						<tr>
							<td>Debit</td>
							<td><input type="text" class="form-control" name="debit" value="<?php echo $d['debit'] ?>"></td>
						</tr>
						<tr>
							<td>Kredit</td>
							<td><input type="text" class="form-control" name="kredit" value="<?php echo $d['kredit'] ?>"></td>
						</tr>
						<tr>
							<td>Keterangan</td>
							<td><input name="ket" type="text" class="form-control" value="<?php echo $d['ket'] ?>"></td>
						</tr>
							<tr>
								<td>Admin</td>
								<td><input type="admin" class="form-control" name="amon" value="<?php echo $d['admin'] ?>" readonly="yes"></td>
							</tr>
							<td></td>
							<td><input type="submit" class="btn btn-primary" value="Simpan"></td>
						</tr>
					</table>
				</form>
				<?php 
				}
				?>
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
</script>