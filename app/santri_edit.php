<?php 
include 'header.php';
?>

<main class="content">
	<div class="container p-0">
		<h3 class="display-6"><span class=""></span>Edit Santri</h3>
		<div class="d-flex justify-content-between">
			<a class="btn" href="santri"><span data-feather="arrow-left"></span>Kembali</a>
		</div>
		<div class="card mt-3">
			<div class="card-header">
				<div class="card-title">
					Data Santri
				</div>
			</div>
			<div class="card-body">
				<form action="santri_update.php" method="post">
					<div class="row">
						<div class="col-sm-6 col-lg-4 mb-2">
							<?php 
							$nis=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
							$det=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where nis='$nis'")or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							while($d=mysqli_fetch_array($det)){
							?>
							<label class="form-label text-primary"><strong>Nomor Induk</strong></label>
							<input type="text" class="form-control" name="id" value="<?php echo $d['nis'] ?>" readonly=yes>		
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Nama Panggilan</label>
							<input type="text" class="form-control" name="panggilan" value="<?php echo $d['panggilan'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Nama Lengkap</label>
							<input type="text" class="form-control" name="nama" value="<?php echo $d['nama'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Jenis Kelamin</label>
							<select class="form-select" name="kelamin">
								<option><?php echo $d['kelamin'] ?></option>
								<option>Laki-laki</option>
								<option>Perempuan</option>
							</select>	
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Kelas</label>
							<select name="kelas" type="text" class="form-control">
								<option value="<?php echo $d['kelas'] ?>"><?php echo $d['kelas'] ?></option>
								<option>Awal 1</option>		
								<option>Awal 2</option>		
								<option>Awal 3</option>		
								<option>Qonuni</option>		
								<option>Qonuni 1</option>		
								<option>Qonuni 2</option>		
								<option>Qonuni 3</option>
								<option>XXX</option>
							</select>
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Tempat Lahir</label>
							<input type="text" class="form-control" name="tmp_lahir" value="<?php echo $d['tmp_lahir'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Tanggal Lahir</label>
							<input type="text" class="form-control" name="tgl_lahir" value="<?php echo $d['tgl_lahir'] ?>" id="tgl_lahir" autocomplete="off">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Anak ke</label>
							<div class="input-group">
								<input type="text" class="form-control" name="anak_ke" value="<?php echo $d['anak_ke'] ?>">
								<input type="text" class="form-control" name="jml_sdr" value="<?php echo $d['jml_sdr'] ?>">
							</div>
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Status Keluarga</label>
							<select name="status_kel" type="text" class="form-control">
								<option value="<?php echo $d['status_kel'] ?>"><?php echo $d['status_kel'] ?></option>
								<option>Saudara Kandung</option>		
								<option>Saudara Tiri</option>		
								<option>Saudara Angkat</option>		
							</select>
						</div>
						
						<div class="mt-4"></div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label text-primary"><strong>Alamat</strong></label>
							<input type="text" class="form-control" name="alamat" value="<?php echo $d['alamat'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Dusun</label>
							<input type="text" class="form-control" name="dusun" value="<?php echo $d['dusun'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Desa</label>
							<input type="text" class="form-control" name="desa" value="<?php echo $d['desa'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Kecamatan</label>
							<input type="text" class="form-control" name="kec" value="<?php echo $d['kec'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Kabupaten</label>
							<input type="text" class="form-control" name="kab" value="<?php echo $d['kab'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Kode Pos</label>
							<input type="text" class="form-control" name="kpos" value="<?php echo $d['kpos'] ?>">
						</div>

						<div class="mt-4"></div>
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label text-primary"><strong>Hobi Anak</strong></label>
							<input type="text" class="form-control" name="hobi" value="<?php echo $d['hobi'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Olah raga yg disukai</label>
							<input type="text" class="form-control" name="olah_raga" value="<?php echo $d['olah_raga'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Cita-cita</label>
							<input type="text" class="form-control" name="cita" value="<?php echo $d['cita'] ?>">
						</div>	
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label">Tinggi (cm) | Berat (kg)</label>
							<div class="input-group">
								<input type="text" class="form-control" name="tinggi" value="<?php echo $d['tinggi'] ?>">
								<input type="text" class="form-control" name="berat" value="<?php echo $d['berat'] ?>">
							</div>
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Jarak (km)</label>
							<input type="text" class="form-control" name="jarak" value="<?php echo $d['jarak'] ?>">
						</div>	
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label">Waktu tempuh</label>
							<input type="text" class="form-control" name="waktu" value="<?php echo $d['waktu'] ?>">
						</div>	

						<div class="mt-4"></div>
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label text-primary"><strong>Nama Ayah</strong></label>
							<input type="text" class="form-control" name="ayah" value="<?php echo $d['ayah'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Tempat Tanggal Lahir </label>
							<div class="input-group">
								<input type="text" class="form-control" name="tmp_ayah" value="<?php echo $d['tmp_ayah'] ?>">
								<input type="text" class="form-control" name="tgl_ayah" value="<?php echo $d['tgl_ayah'] ?>" id="tgl_ayah" autocomplete="off">
							</div>
						</div>	
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label">Pendidikan akhir | Ket.</label>
							<div class="input-group">
								<input type="text" class="form-control" name="pend_ayah" value="<?php echo $d['pend_ayah'] ?>">
								<input type="text" class="form-control" name="ket_ayah" value="<?php echo $d['ket_ayah'] ?>">
							</div>
						</div>	
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label">Nama Ibu</label>
							<input type="text" class="form-control" name="ibu" value="<?php echo $d['ibu'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Tempat Lahir</label>
							<div class="input-group">
								<input type="text" class="form-control" name="tmp_ibu" value="<?php echo $d['tmp_ibu'] ?>">
								<input type="text" class="form-control" name="tgl_ibu" value="<?php echo $d['tgl_ibu'] ?>" id="tgl_ibu" autocomplete="off">
							</div>
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label">Pendidikan akhir | Ket.</label>
							<div class="input-group">
								<input type="text" class="form-control" name="pend_ibu" value="<?php echo $d['pend_ibu'] ?>">
								<input type="text" class="form-control" name="ket_ibu" value="<?php echo $d['ket_ibu'] ?>">
							</div>
						</div>	
						<div class="col-sm-6 col-lg-4 mb-2">		
							<label class="form-label">Wali</label>
							<input type="text" class="form-control" name="ket_wali" value="<?php echo $d['ket_wali'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Alamat Wali</label>
							<input type="text" class="form-control" name="alamat_wali" value="<?php echo $d['alamat_wali'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">No. Telepon</label>
							<input type="text" class="form-control" name="tlp" value="<?php echo $d['tlp'] ?>">
						</div>	
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Pekerjaan</label>
							<input type="text" class="form-control" name="kerja" value="<?php echo $d['kerja'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Penghasilah perbulan</label>
							<select name="salary" type="text" class="form-control">
								<option><?php echo $d['salary'] ?></option>
								<option>Tidak ada</option>		
								<option>< 1.000.000</option>		
								<option>> 1.000.000</option>		
								<option>> 3.000.000</option>
								<option>> 5.000.000</option>
							</select>
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Hubungan dg anak</label>
							<input type="text" class="form-control" name="hubungan_wali" value="<?php echo $d['hubungan_wali'] ?>">
						</div>	
						<div class="col-sm-6 col-lg-4 mb-2">	
							<label class="form-label">Prestasi anak</label>
							<input type="text" class="form-control" name="prestasi" value="<?php echo $d['prestasi'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Penyakit Khusus</label>
							<input type="text" class="form-control" name="penyakit" value="<?php echo $d['penyakit'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<label class="form-label">Catatan</label>
							<input type="text" class="form-control" name="ket_santri" value="<?php echo $d['ket_santri'] ?>">
						</div>
						<div class="col-sm-6 col-lg-4 mb-2">
							<input type="submit" class="btn btn-primary" value="Simpan">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>
<?php 
}
?>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
$(function() {
    $('#tgl_lahir').datepicker({ 
    autoclose: true,
    todayHighlight: true,
    format : 'yyyy-mm-dd' 
    });
});
$(function() {
    $('#tgl_ayah').datepicker({ 
    autoclose: true,
    todayHighlight: true,
    format : 'yyyy-mm-dd' 
    });
});
$(function() {
    $('#tgl_ibu').datepicker({ 
    autoclose: true,
    todayHighlight: true,
    format : 'yyyy-mm-dd' 
    });
});
</script>
