<?php 
include 'header.php';
?>

<main class="content">
	<div class="container-fluid p-0">
	
	<h3 class="h2 text-center mb-2">Welcome to Database Information System</h3>
	<h5 class="h4 text-center mb-3"><?php echo date('D, d M Y') ?></h5>

	<br>
		<div class="row">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Kls Awal</h5>
						<canvas id="KLSAChart"></canvas>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Jenis Kelamin</h5>
						<canvas id="JKChart"></canvas>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Kls Qonuni</h5>
						<canvas id="KLSQChart"></canvas>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Bayaran</h5>
						<canvas id="PAYChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	
   
	<!-- membuat tabel rekap nilai -->  
	<h3 class="display-6 text-center mb-3">Index Prestasi</h3>

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<form action="" method="get">
						<div class="input-group text-center">
							<td><select type="submit" name="kls" class="form-control" style="width:200px;">
								<option>.. Kelas ..</option>
								<?php 
								$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct kelas from santri order by kelas");
								while($p=mysqli_fetch_array($pil)){
									?>
									<option><?php echo $p['kelas'] ?></option>
									<?php
								}
								?>			
							</select></td>
							<td><select type="submit" name="smt" class="form-control" style="width:200px;">
								<option>.. Semester ..</option>
								<?php 
								$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct smt from nilai order by smt");
								while($p=mysqli_fetch_array($pil)){
									?>
									<option><?php echo $p['smt'] ?></option>
									<?php
								}
								?>			
							</select></td>
							<td><select type="submit" name="thn" class="form-control" style="width:200px;" onchange="this.form.submit()">
								<option>.. Tahun ..</option>
								<?php 
								$pil=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct thn from nilai order by thn");
								while($p=mysqli_fetch_array($pil)){
									?>
									<option><?php echo $p['thn'] ?></option>
									<?php
								}
								?>			
							</select></td>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
   
	<?php if(isset($_GET['thn'])){
		$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
		$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
		$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
		echo '<h4 class="text-center mb-3">Tahun ' . $thn. ' Semester ' . $smt . '</h4>';
	} ?>
	
	<div class="card">
		<div class="card-header">
			<div class="card-body">
				<table class="table table-hover table-strip">
					<tr>
						<th class="d-none d-md-table-cell">Class</th>
						<th class="d-none d-md-table-cell">NIS</th>
						<th>Name</th>
						<th>Average</th>
					</tr>
						<?php
						if(isset($_GET['thn'])){
							$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
							$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
							$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
							$san=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas='$kls'");
						}else{
							$san=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri WHERE kelas<>'XXX' order by kelas, nama");
							if($san === false) {
								die(mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						while($s=mysqli_fetch_assoc($san)){
							$nis=$s['nis'];
						?>  
					<tr>
						<td class="d-none d-md-table-cell"><?php echo $s['kelas'] ?></td>
						<td class="d-none d-md-table-cell"><?php echo $nis ?></td>
						<td><?php echo $s['nama'] ?></td>
						<?php
						if(isset($_GET['thn'])){
							$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
							$smt=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['smt']);
							$thn=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['thn']);
							$nilai=mysqli_query($GLOBALS["___mysqli_ston"], "select AVG(angka) as avgnil from nilai where thn='$thn' and smt='$smt' and nis='$nis' order by avgnil");
						}else{
							$nilai=mysqli_query($GLOBALS["___mysqli_ston"], "select AVG(angka) as avgnil from nilai where nis='$nis' order by kls, avgnil");
							if($nilai === false) {
								die(mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						while($n=mysqli_fetch_array($nilai)){
						?>
						<td><?php echo number_format($n['avgnil'], 2) ?></td>
					</tr>
						<?php
						}
						}
						}
						}
						?>
				</table>
			</div>
		</div>
	</div>

   
	</div>
</main>
   
<!---------------------------------------------------------->

<script>
	// Chart kelas awal
	var ctx = document.getElementById("KLSAChart").getContext('2d');
	var KLSAChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["Awal 1", "Awal 2", "Awal 3"],
			datasets: [{
				label: 'Kelas',
				data: [
				<?php 
				$koneksi = $GLOBALS["___mysqli_ston"];
				$kls1 = mysqli_query($koneksi,"select * from santri where kelas='Awal 1'");
				echo mysqli_num_rows($kls1);
				?>, 
				<?php 
				$kls2 = mysqli_query($koneksi,"select * from santri where kelas='Awal 2'");
				echo mysqli_num_rows($kls2);
				?>, 
				<?php 
				$kls3 = mysqli_query($koneksi,"select * from santri where kelas='Awal 3'");
				echo mysqli_num_rows($kls3);
				?>
				],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});

	// Chart kls Qonuni
	var ctx = document.getElementById("KLSQChart").getContext('2d');
	var KLSQChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["Qonuni 1", "Qonuni 2", "Qonuni 3"],
			datasets: [{
				label: 'Kelas',
				data: [
				<?php 
				$koneksi = $GLOBALS["___mysqli_ston"];
				$kls1 = mysqli_query($koneksi,"select * from santri where kelas='Qonuni 1'");
				echo mysqli_num_rows($kls1);
				?>, 
				<?php 
				$kls2 = mysqli_query($koneksi,"select * from santri where kelas='Qonuni 2'");
				echo mysqli_num_rows($kls2);
				?>, 
				<?php 
				$kls3 = mysqli_query($koneksi,"select * from santri where kelas='Qonuni 3'");
				echo mysqli_num_rows($kls3);
				?>
				],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});

	// Jenis Kelamin Santri
	var ctx = document.getElementById("JKChart").getContext('2d');
	var JKChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: ["Laki-laki", "Perempuan"],
			datasets: [{
				label: '',
				data: [
				<?php 
				$konek = $GLOBALS["___mysqli_ston"];
				$jumlah_laki = mysqli_query($konek,"select * from santri where kelas<>'XXX' and kelamin='laki-laki'");
				echo mysqli_num_rows($jumlah_laki);
				?>, 
				<?php 
				$jumlah_perempuan = mysqli_query($konek,"select * from santri where  kelas<>'XXX' and kelamin='perempuan'");
				echo mysqli_num_rows($jumlah_perempuan);
				?>
				],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});

	// SPP
	var ctx = document.getElementById("PAYChart").getContext('2d');
	var KLSChart = new Chart(ctx, {
		type: 'line',
		data: {
			<?php 
			$koneksi = $GLOBALS["___mysqli_ston"];
			$santri = mysqli_query($koneksi,"select * from santri WHERE ket_santri='-'");
			$total= mysqli_num_rows($santri);
			$bul1 = date('M-Y', strtotime(date('M-Y') . '- 2 month')) ;
			$bul2 = date('M-Y', strtotime(date('M-Y') . '- 1 month')) ;
			$bul3 = date('M-Y') ;
			$q1 = mysqli_query($koneksi,"select * from bayaran where bln='$bul1'");
			$j1= mysqli_num_rows($q1);
			$p1=round($j1/$total * 100);
			$q2 = mysqli_query($koneksi,"select * from bayaran where bln='$bul2'");
			$j2= mysqli_num_rows($q2);
			$p2=round($j2/$total * 100);
			$q3 = mysqli_query($koneksi,"select * from bayaran where bln='$bul3'");
			$j3= mysqli_num_rows($q3);
			$p3=round($j3/$total * 100);								
			?>
			labels: ["<?php echo substr($bul1,0,3) ." : ". $p1 ?>%", "<?php echo substr($bul2,0,3) ." : ". $p2 ?>%", "<?php echo substr($bul3,0,3) ." : ". $p3 ?>%"],
			datasets: [{
				label: 'SPP',
				data: [
				<?php 
				echo mysqli_num_rows($q1);
				?>, 
				<?php 
				echo mysqli_num_rows($q2);
				?>, 
				<?php 
				echo mysqli_num_rows($q3);
				?>
				],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
	</script>  
