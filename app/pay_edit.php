<?php 
include 'header.php';
?>

<main class="content">
	<div class="container p-0">
		<h3 class="display-6"><span class=""></span>Edit Item</h3>
		<div class="d-flex justify-content-between">
			<a class="btn" href="pay"><span data-feather="arrow-left"></span>Kembali</a>
		</div>
		<div class="card mt-3">
			<div class="card-header">
				<div class="card-title">
					Item Pembayaran
				</div>
			</div>
			<div class="card-body">
				<?php
				$id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['no']);
				$det=mysqli_query($GLOBALS["___mysqli_ston"], "select * from bayaran where no='$id'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($d=mysqli_fetch_array($det)){
				?>					
				<form action="pay_update" method="post">
					<table class="table">
						<tr>
							<td></td>
							<td><input type="hidden" name="no" value="<?php echo $d['no'] ?>"></td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td><input type="text" class="form-control" name="tgl" id="tgl" value="<?php echo $d['tgl'] ?>" autocomplete="off"></td>
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
							<td><input type="text" class="form-control" name="ayah" value="<?php echo $d['wali'] ?>" readonly="yes"></td>
						</tr>
						<tr class="text-primary">
							<td class="text-end"><b>PEMBAYARAN</b></td>
							<td><b>DAFTAR ULANG</b></td>
						</tr>
						<tr>
							<td>Tahun</td>
							<td><select name="thn" class="form-control" value="-">
								<option selected="selected"><?php echo $d['thn'] ?></option>
									<?php
										for($i=2017; $i<=date('Y')+2; $i++){
										echo"<option value='$i'> $i </option>";
										}
										?>
									</select></td>
						</tr>
						<tr>
							<td>Pendaftaran</td>
							<td><input type="text" class="form-control" name="daftar" value="<?php echo $d['daftar'] ?>"></td>
						</tr>
						<tr>
							<td>Bangunan</td>
							<td><input type="text" class="form-control" name="bangunan" value="<?php echo $d['bangunan'] ?>"></td>
						</tr>
						<tr>
							<td>Pendidikan</td>
							<td><input name="pendidikan" type="text" class="form-control" value="<?php echo $d['pendidikan'] ?>"></td>
						</tr>
						<tr>
							<td>Seragam</td>
							<td><input name="seragam" type="text" class="form-control" value="<?php echo $d['seragam'] ?>"></td>
						</tr>
						<tr class="text-primary">
							<td class="text-end"><b>PEMBAYARAN</b></td>
							<td><b>SPP BULANAN</b></td>
						</tr>
						<tr>
							<td>Bulan</td>
							<td><select name="bln" type="text" class="form-control">
								<option selected="selected"><?php echo $d['bln'] ?></option>
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
							</td>
							
						</tr>
						<tr>
							<td>SPP</td>
							<td><input name="spp" type="text" class="form-control" value="<?php echo $d['spp'] ?>"></td>
						</tr>
						<tr>
							<td>Uang Makan</td>
							<td><input name="makan" type="text" class="form-control" value="<?php echo $d['makan'] ?>"></td>
						</tr>
						<tr>
							<td>Lain-Lain</td>
							<td><input name="lain" type="text" class="form-control" value="<?php echo $d['lain'] ?>"></td>
						</tr>
						<tr>
							<td>Keterangan</td>
							<td><input name="ket" type="text" class="form-control" value="<?php echo $d['ket'] ?>"></td>
						</tr>
						<tr>
							<td>Admin</td>
							<td><input name="admin" type="text" class="form-control" value="<?php echo $d['admin'] ?>" readonly="yes"></td>
						</tr>
						<tr>
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
