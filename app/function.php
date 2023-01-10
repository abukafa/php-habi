<?php
function getdb(){
$servername = "localhost";
$username = "root";
$password = "";
$db = "habi";
try {
    $conn = mysqli_connect($servername, $username, $password, $db);
     //echo "Connected successfully"; 
    }
catch(exception $e){
    echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}

// -------------------------------------------------------------------------- Table Santri
if(isset($_POST["Import-santri"])){
	$con = getdb(); 
	$filename=$_FILES["file"]["tmp_name"];		
	if($_FILES["file"]["size"] > 0){
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
			$sql = "INSERT into santri (nis, nama, panggilan, kelamin, kelas, tmp_lahir, tgl_lahir, anak_ke, status_kel, jml_sdr, alamat, dusun, desa, kec, kab, kpos, hobi, olah_raga, cita, tinggi, berat, jarak, waktu, ayah, tmp_ayah, tgl_ayah, pend_ayah, ket_ayah, ibu, tmp_ibu, tgl_ibu, pend_ibu, ket_ibu, kerja, salary, tlp, ket_wali, ket_santri, penyakit, prestasi, alamat_wali, hubungan_wali) 
			values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."'	,'".$getData[6]."'	,'".$getData[7]."'	,'".$getData[8]."'	,'".$getData[9]."'	,'".$getData[10]."'	,'".$getData[11]."'	,'".$getData[12]."'	,'".$getData[13]."'	,'".$getData[14]."'	,'".$getData[15]."'	,'".$getData[16]."'	,'".$getData[17]."'	,'".$getData[18]."'	,'".$getData[19]."'	,'".$getData[20]."'	,'".$getData[21]."'	,'".$getData[22]."'	,'".$getData[23]."'	,'".$getData[24]."'	,'".$getData[25]."'	,'".$getData[26]."'	,'".$getData[27]."'	,'".$getData[28]."'	,'".$getData[29]."'	,'".$getData[30]."'	,'".$getData[31]."'	,'".$getData[32]."'	,'".$getData[33]."'	,'".$getData[34]."'	,'".$getData[35]."'	,'".$getData[36]."'	,'".$getData[37]."'	,'".$getData[38]."'	,'".$getData[39]."'	,'".$getData[40]."'	,'".$getData[41]."')";
			$result = mysqli_query($con, $sql);
			if(!isset($result)){
				echo "<script type=\"text/javascript\">
					alert(\"Invalid File : Please Upload CSV File.\");
					window.location = \"santri.php\"
					</script>";		
				}else{
				echo"<script type=\"text/javascript\">
					alert(\"CSV File has been successfully send to Import .\");
					window.location = \"santri.php\"
					</script>";
			}
		}
		fclose($file);	
	}
}
 if(isset($_POST["Export-santri"])){
	$con = getdb(); 
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename=santri.csv');  
	$output = fopen("php://output", "w");  
	fputcsv($output, array('nis', 'nama', 'panggilan', 'kelamin', 'kelas', 'tmp_lahir', 'tgl_lahir', 'anak_ke', 'status_kel', 'jml_sdr', 'alamat', 'dusun', 'desa', 'kec', 'kab', 'kpos', 'hobi', 'olah_raga', 'cita', 'tinggi', 'berat', 'jarak', 'waktu', 'ayah', 'tmp_ayah', 'tgl_ayah', 'pend_ayah', 'ket_ayah', 'ibu', 'tmp_ibu', 'tgl_ibu', 'pend_ibu', 'ket_ibu', 'kerja', 'salary', 'tlp', 'ket_wali', 'ket_santri', 'penyakit', 'prestasi', 'alamat_wali', 'hubungan_wali')); 
	$query = "SELECT * from santri ORDER BY kelas";  
	$result = mysqli_query($con, $query);  
	while($row = mysqli_fetch_assoc($result)){  
		fputcsv($output, $row);  
		}  
	fclose($output);  
}

// -------------------------------------------------------------------------- Table Bayaran
if(isset($_POST["Import-bayaran"])){
	$con = getdb(); 
	$filename=$_FILES["file"]["tmp_name"];		
	if($_FILES["file"]["size"] > 0){
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
			$sql = "INSERT into bayaran (no, tgl, period, nis, nama, wali, thn, daftar, bangunan, pendidikan, seragam, bln, spp, makan, lain, ket, jumlah, admin) 
			values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."'	,'".$getData[6]."'	,'".$getData[7]."'	,'".$getData[8]."'	,'".$getData[9]."'	,'".$getData[10]."'	,'".$getData[11]."'	,'".$getData[12]."'	,'".$getData[13]."'	,'".$getData[14]."'	,'".$getData[15]."'	,'".$getData[16]."'	,'".$getData[17]."')";
			$result = mysqli_query($con, $sql);
			if(!isset($result)){
				echo "<script type=\"text/javascript\">
					alert(\"Invalid File : Please Upload CSV File.\");
					window.location = \"pay.php\"
					</script>";		
				}else{
				echo"<script type=\"text/javascript\">
					alert(\"CSV File has been successfully send to Import .\");
					window.location = \"pay.php\"
					</script>";
			}
		}
		fclose($file);	
	}
}
 if(isset($_POST["Export-bayaran"])){
	$con = getdb(); 
	$awl=$_POST['taw'];
	$ahr=$_POST['tah'];
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename=bayaran.csv');  
	$output = fopen("php://output", "w");  
	fputcsv($output, array('no', 'tgl', 'period', 'nis', 'nama', 'wali', 'thn', 'daftar', 'bangunan', 'pendidikan', 'seragam', 'bln', 'spp', 'makan', 'lain', 'ket', 'jumlah', 'admin')); 
	$query = "SELECT * from bayaran where tgl between '$awl' and '$ahr' ORDER BY tgl";  
	$result = mysqli_query($con, $query);  
	while($row = mysqli_fetch_assoc($result)){  
		fputcsv($output, $row);  
		}  
	fclose($output);  
}


// -------------------------------------------------------------------------- Table Finance
if(isset($_POST["Import-finance"])){
	$con = getdb(); 
	$filename=$_FILES["file"]["tmp_name"];		
	if($_FILES["file"]["size"] > 0){
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
			$sql = "INSERT into finance (no, inv, tgl, period, akun, vendor, uraian, ket, debit, kredit, admin) 
			values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."'	,'".$getData[6]."'	,'".$getData[7]."'	,'".$getData[8]."'	,'".$getData[9]."'	,'".$getData[10]."')";
			$result = mysqli_query($con, $sql);
			if(!isset($result)){
				echo "<script type=\"text/javascript\">
					alert(\"Invalid File : Please Upload CSV File.\");
					window.location = \"finance.php\"
					</script>";		
				}else{
				echo"<script type=\"text/javascript\">
					alert(\"CSV File has been successfully send to Import .\");
					window.location = \"finance.php\"
					</script>";
			}
		}
		fclose($file);	
	}
}
 if(isset($_POST["Export-finance"])){
	$con = getdb(); 
	$awl=$_POST['taw'];
	$ahr=$_POST['tah'];
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename=finance.csv');  
	$output = fopen("php://output", "w");  
	fputcsv($output, array('no', 'inv', 'tgl', 'period', 'akun', 'vendor', 'uraian', 'ket', 'debit', 'kredit', 'admin')); 
	$query = "SELECT * from finance where tgl between '$awl' and '$ahr' ORDER BY tgl";  
	$result = mysqli_query($con, $query);  
	while($row = mysqli_fetch_assoc($result)){  
		fputcsv($output, $row);  
		}  
	fclose($output);  
}

// -------------------------------------------------------------------------- Table Tabungan
if(isset($_POST["Import-tabungan"])){
	$con = getdb(); 
	$filename=$_FILES["file"]["tmp_name"];		
	if($_FILES["file"]["size"] > 0){
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
			$sql = "INSERT into tabungan (no, tgl, period, nis, nama, wali, debit, kredit, ket, admin) 
			values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."'	,'".$getData[6]."'	,'".$getData[7]."'	,'".$getData[8]."'	,'".$getData[9]."')";
			$result = mysqli_query($con, $sql);
			if(!isset($result)){
				echo "<script type=\"text/javascript\">
					alert(\"Invalid File : Please Upload CSV File.\");
					window.location = \"bank.php\"
					</script>";		
				}else{
				echo"<script type=\"text/javascript\">
					alert(\"CSV File has been successfully send to Import .\");
					window.location = \"bank.php\"
					</script>";
			}
		}
		fclose($file);	
	}
}
 if(isset($_POST["Export-tabungan"])){
	$con = getdb(); 
	$awl=$_POST['taw'];
	$ahr=$_POST['tah'];
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename=tabungan.csv');  
	$output = fopen("php://output", "w");  
	fputcsv($output, array('no', 'tgl', 'period', 'nis', 'nama', 'wali', 'debit', 'kredit', 'ket', 'admin')); 
	$query = "SELECT * from tabungan where tgl between '$awl' and '$ahr' ORDER BY tgl";  
	$result = mysqli_query($con, $query);  
	while($row = mysqli_fetch_assoc($result)){  
		fputcsv($output, $row);  
		}  
	fclose($output);  
}

// -------------------------------------------------------------------------- Table Beban
if(isset($_POST["Import-beban"])){
	$con = getdb(); 
	$filename=$_FILES["file"]["tmp_name"];		
	if($_FILES["file"]["size"] > 0){
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
			$sql = "INSERT into beban (no, nis, nama, thn, ket, daftar, bangunan, pendidikan, seragam, spp, makan, asrama) 
			values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."'	,'".$getData[6]."'	,'".$getData[7]."'	,'".$getData[8]."'	,'".$getData[9]."','".$getData[10]."','".$getData[11]."')";
			$result = mysqli_query($con, $sql);
			if(!isset($result)){
				echo "<script type=\"text/javascript\">
					alert(\"Invalid File : Please Upload CSV File.\");
					window.location = \"beban.php\"
					</script>";		
				}else{
				echo"<script type=\"text/javascript\">
					alert(\"CSV File has been successfully send to Import .\");
					window.location = \"beban.php\"
					</script>";
			}
		}
		fclose($file);	
	}
}
 if(isset($_POST["Export-beban"])){
	$con = getdb(); 
	$thn=$_POST['tah'];
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename=beban.csv');  
	$output = fopen("php://output", "w");  
	fputcsv($output, array('no', 'nis', 'nama', 'thn', 'ket', 'daftar', 'bangunan', 'pendidikan', 'seragam', 'spp', 'makan', 'asrama')); 
	$query = "SELECT * from beban where thn= '$thn' ORDER BY nama";  
	$result = mysqli_query($con, $query);  
	while($row = mysqli_fetch_assoc($result)){  
		fputcsv($output, $row);  
		}  
	fclose($output);  
}

// -------------------------------------------------------------------------- Table Exception
if(isset($_POST["Import-exc"])){
	$con = getdb(); 
	$filename=$_FILES["file"]["tmp_name"];		
	if($_FILES["file"]["size"] > 0){
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
			$sql = "INSERT into exception (no, nis, nama, thn, ket, daftar, bangunan, pendidikan, seragam, spp, makan, asrama) 
			values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."'	,'".$getData[6]."'	,'".$getData[7]."'	,'".$getData[8]."'	,'".$getData[9]."','".$getData[10]."','".$getData[11]."')";
			$result = mysqli_query($con, $sql);
			if(!isset($result)){
				echo "<script type=\"text/javascript\">
					alert(\"Invalid File : Please Upload CSV File.\");
					window.location = \"exc.php\"
					</script>";		
				}else{
				echo"<script type=\"text/javascript\">
					alert(\"CSV File has been successfully send to Import .\");
					window.location = \"exc.php\"
					</script>";
			}
		}
		fclose($file);	
	}
}
 if(isset($_POST["Export-exc"])){
	$con = getdb(); 
	$thn=$_POST['tah'];
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename=exception.csv');  
	$output = fopen("php://output", "w");  
	fputcsv($output, array('no', 'nis', 'nama', 'thn', 'ket', 'daftar', 'bangunan', 'pendidikan', 'seragam', 'spp', 'makan', 'asrama')); 
	$query = "SELECT * from exception where thn= '$thn' ORDER BY nama";  
	$result = mysqli_query($con, $query);  
	while($row = mysqli_fetch_assoc($result)){  
		fputcsv($output, $row);  
		}  
	fclose($output);  
}

// -------------------------------------------------------------------------- Table Nilai
if(isset($_POST["Import-nilai"])){
	$con = getdb(); 
	$filename=$_FILES["file"]["tmp_name"];		
	if($_FILES["file"]["size"] > 0){
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
			$sql = "INSERT into nilai (no, thn, smt, nis, nama, kls, materi, angka, desk) 
			values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."'	,'".$getData[6]."'	,'".$getData[7]."'	,'". addslashes($getData[8]) ."')";
			$result = mysqli_query($con, $sql);
			if(!isset($result)){
				echo "<script type=\"text/javascript\">
					alert(\"Invalid File : Please Upload CSV File.\");
					window.location = \"nilai.php\"
					</script>";		
				}else{
				echo"<script type=\"text/javascript\">
					alert(\"CSV File has been successfully send to Import .\");
					window.location = \"nilai.php\"
					</script>";
			}
		}
		fclose($file);	
	}
}
 if(isset($_POST["Export-nilai"])){
	$con = getdb(); 
	$mtr=$_POST['materi'];
	$smt=$_POST['smt'];
	$thn=$_POST['thn'];
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename=nilai.csv');  
	$output = fopen("php://output", "w");  
	fputcsv($output, array('no', 'thn', 'smt', 'nis', 'nama', 'kls', 'materi', 'angka', 'desk')); 
	$query = "select * from nilai where thn='$thn' and smt='$smt' and materi='$mtr' order by nis";  
	$result = mysqli_query($con, $query);  
	while($row = mysqli_fetch_assoc($result)){  
		fputcsv($output, $row);  
		}  
	fclose($output);  
}

?>