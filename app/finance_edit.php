<?php 
include 'header.php';

$id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['no']);
$inv=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['inv']);
$det=mysqli_query($GLOBALS["___mysqli_ston"], "select * from finance where no='$id'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($d=mysqli_fetch_array($det)){
?>	

<main class="content">
	<div class="container p-0">
		<h3 class="display-6"><span class=""></span>Edit Item</h3>
		<div class="d-flex justify-content-between">
			<a class="btn" href="finance_add?tgl=&vend=&ket=&inv=<?php echo $inv ?>"><span data-feather="arrow-left"></span>Kembali</a>
		</div>
		<div class="card mt-3">
			<div class="card-header">
				<div class="card-title">Item Transaksi</div>
				<div class="card-body">
					<form action="finance_update" method="post">
						<table class="table">
							<tr>
								<td></td>
								<td><input type="hidden" name="no" value="<?php echo $d['no'] ?>"></td>
							</tr>
							<tr>
								<td>Invoice</td>
								<td><input type="text" class="form-control" name="inv" value="<?php echo $d['inv'] ?>" readonly=yes></td>
							</tr>
							<tr>
								<td>Date</td>
								<td><input type="text" class="form-control" name="tgl" id="tgl" value="<?php echo $d['tgl'] ?>" autocomplete="off"></td>
							</tr>
							<tr>
								<td>Vendor</td>
								<td><input type="text" class="form-control" name="vendor" value="<?php echo $d['vendor'] ?>" ></td>
							</tr>
							<tr>
								<td>Remark</td>
								<td><input type="text" class="form-control" name="ket" value="<?php echo $d['ket'] ?>"></td>
							</tr>
							<tr>
								<td>Account</td>
								<td><select name="akun" class="form-control">
									<option selected="selected"><?php echo $d['akun'] ?></option>
											<option value="-">--Akun--</option>
											<option value="000221">000221 - Biaya Administrasi</option>
											<option value="000222">000222 - Biaya Pembangunan</option>
											<option value="000223">000223 - Biaya Pendidikan</option>
											<option value="000224">000224 - Biaya Seragam</option>
											<option value="000225">000225 - Biaya Pembinaan</option>
											<option value="000226">000226 - Biaya Dapur</option>
											<option value="000227">000227 - Biaya Operasional</option>
											<option value="000228">000228 - Biaya Asrama</option>
											<option value="777199">777199 - Pemasukan</option>
									</select></td>
							</tr>
							<tr>
								<td>Description</td>
								<td><input type="text" class="form-control" name="uraian" value="<?php echo $d['uraian'] ?>" ></td>
							</tr>
							
							<?php
							if (substr($d['akun'], 0, 3) == 777){
								?>
								<tr>
									<td>Amount</td>
									<td><input type="text" class="form-control" name="amon" value="<?php echo $d['debit'] ?>"></td>
								</tr>
							<?php
							}else{
								?>
								<tr>
									<td>Amount</td>
									<td><input type="text" class="form-control" name="amon" value="<?php echo $d['kredit'] ?>"></td>
								</tr>
					
							<?php
							}
							?>
								<tr>
									<td>Admin</td>
									<td><input type="admin" class="form-control" name="admin" value="<?php echo $d['admin'] ?>" readonly="yes"></td>
								</tr>
							
								<td></td>
								<td><input type="submit" class="btn btn-info" value="Simpan"></td>
							</tr>
						</table>
					</form>
					<?php 
					}
					?>
				</div>
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

