<?php include 'header.php'; ?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Pencarian</h3>
		<div class="d-flex justify-content-between">
			<a class="btn" href="pay"><span data-feather="arrow-left"></span>Kembali</a>
			<!-- Filter Data Santri -->
			<form action="" method="get">
				<div class="input-group col-md-5 col-md-offset-7">
					<label class="input-group-text" id="basic-addon1"><span data-feather="search"></span></label>
					<select type="submit" name="kls" class="form-control" onchange="this.form.submit()">
						<option>Pilih Kelas ..</option>
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
				<h5 class="card-title">Data Tunggakan</h5>
				<?php 
				if(isset($_GET['kls'])){
					$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
					$tg="pay_laptagal";
					$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri where kelas='$kls'");
				?>
					<a style="margin-bottom:10px" href="<?php echo $tg ?>" target="_blank" class="btn btn-success">Rekap Data</a>  

				<?php
				}else{
					$tg="pay_laptagal";
					$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri");
				}
					$per_hal=20;
					$jum=mysqli_num_rows($jumlah_record);
					$halaman=ceil($jum / $per_hal);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $per_hal;
				?>
				
			</div>
			<div class="card-body">
				<table class="table table-hover">
					<tr>
						<th>No</th>
						<th>NIS</th>
						<th>Nama Santri</th>
						<th class="d-none d-xl-table-cell text-end">Daftar</th>
						<th class="d-none d-xl-table-cell text-end">Bangunan</th>
						<th class="d-none d-xl-table-cell text-end">Pendidikan</th>
						<th class="d-none d-xl-table-cell text-end">Seragam</th>
						<th class="d-none d-xl-table-cell text-end">SPP</th>
						<th class="text-end">Jumlah</th>
					</tr>
					<?php 
					$per_hal=20;
					$jumlah_record=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri");
					$jum=mysqli_num_rows($jumlah_record);
					$halaman=ceil($jum / $per_hal);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $per_hal;

					if(isset($_GET['kls'])){
						$kls=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['kls']);
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where kelas='$kls' order by nama");
					}else{
						$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from santri where kelas<>'XXX' order by kelas, nama");
					}
					$no=1;
					while($b=mysqli_fetch_array($brg)){
					?>
					<tr>	
						<td><?php echo $no ?></td>
						<?php
						$nis=$b['nis'];
						$bl=date("m")-0;
						if ( $bl < 7 ){
							$yer=date("Y")-1;
						}else{
							$yer=date("Y");
						}
						$tg="pay_laptag?nis='$nis'&yer='$yer'"; ?>
						<td><a href="<?php echo $tg ?>"   target="_blank" ><?php echo $b['nis'] ?></a></td>
						<td><?php echo $b['nama'] ?></td>
					
						<?php
						$query2=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $nis .", daftar, 0)) as dft, sum(if(nis=". $nis .", bangunan, 0)) as bgn, sum(if(nis=". $nis .", pendidikan, 0)) as pdd, sum(if(nis=". $nis .", seragam, 0)) as srg, sum(if(nis=". $nis .", spp, 0)) as sp, sum(if(nis=". $nis .", makan, 0)) as mkn, sum(if(nis=". $nis .", lain, 0)) as lin, sum(if(nis=". $nis .", jumlah, 0)) as jm from bayaran where nis =" . $nis);
						while($see=mysqli_fetch_array($query2)){

						$query3=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(nis=". $nis .", daftar, 0)) as dft, sum(if(nis=". $nis .", bangunan, 0)) as bgn, sum(if(nis=". $nis .", pendidikan, 0)) as pdd, sum(if(nis=". $nis .", seragam, 0)) as srg, sum(if(nis=". $nis .", spp, 0)) as sp, sum(if(nis=". $nis .", makan, 0)) as mkn, sum(if(nis=". $nis .", asrama, 0)) as asr from exception");
						while($exc=mysqli_fetch_array($query3)){	
				
						$query=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(if(thn=".$yer." and nis=". $nis .", spp,0)) as spp, sum(if(nis=". $nis .", daftar, 0)) as dft, sum(if(nis=". $nis .", bangunan, 0)) as bgn, sum(if(nis=". $nis .", pendidikan, 0)) as pdd, sum(if(nis=". $nis .", seragam, 0)) as srg, sum(if(nis=". $nis .", spp, 0)) as sp, sum(if(nis=". $nis .", makan, 0)) as mkn, sum(if(nis=". $nis .", asrama, 0)) as asr from beban");
						while($leh=mysqli_fetch_array($query)){


						$taun = $yer . '-07-01';
						$timeStart = strtotime("$taun");
						$numBulan = 1 + (date("Y")-date("Y",$timeStart))*12;
						$numBulan += date("m")-date("m",$timeStart);
						$sbln = 12 - $numBulan;

						$tdft=$leh['dft']-($see['dft']+$exc['dft']);
						$tbgn=$leh['bgn']-($see['bgn']+$exc['bgn']);
						$tpdd=$leh['pdd']-($see['pdd']+$exc['pdd']);
						$tsrg=$leh['srg']-($see['srg']+$exc['srg']);
						$tspp=(12*$leh['sp'])-($see['sp']+$exc['sp'])-($sbln*$leh['spp']);
						$tmkn=0;
						$tlin=0;
						$tjml=$tdft+$tbgn+$tpdd+$tsrg+$tspp+$tmkn+$tlin;	
						?>
						
						<td class="d-none d-xl-table-cell text-end"><?php echo number_format($tdft,0,'',',') ?></td>
						<td class="d-none d-xl-table-cell text-end"><?php echo number_format($tbgn,0,'',',') ?></td>
						<td class="d-none d-xl-table-cell text-end"><?php echo number_format($tpdd,0,'',',') ?></td>
						<td class="d-none d-xl-table-cell text-end"><?php echo number_format($tsrg,0,'',',') ?></td>
						<td class="d-none d-xl-table-cell text-end"><?php echo number_format($tspp,0,'',',') ?></td>
						<td class="text-end"><?php echo number_format($tjml,0,'',',') ?></td>
						</td>
					</tr>		
					<?php 
					$no++;
					}	
					}		
					}
					}
					?>
				</table>
			</div>
		</div>
	</div>
</main>