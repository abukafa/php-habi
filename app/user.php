<?php include 'header.php';	?>

<main class="content">
	<div class="container-fluid p-0">
		<h3 class="display-6"><span class=""></span>Pengguna</h3>
        <?php 
        if($u['uinfo'] == 'Superuser'){
        ?>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Pengguna</button>
        <?php } ?>
		<div class="card col-lg-10 mt-3">
			<div class="card-header d-xl-flex justify-content-between">
				<h5 class="card-title">Data User</h5>
			</div>	
			<div class="card-body">
				<table class="table">
					<tr>
						<th class="d-none d-md-table-cell">ID</th>
						<th class="d-none d-md-table-cell">Username</th>
						<th>Nama</th>
						<th>User Info</th>	
                        <th></th>
					</tr>
					<?php 
					$brg=mysqli_query($GLOBALS["___mysqli_ston"], "select * from admin");
					while($b=mysqli_fetch_array($brg)){
                    ?>
                    <tr>
                        <td class="d-none d-md-table-cell">U0<?php echo $b['id'] ?></td>
                        <td class="d-none d-md-table-cell"><?php echo $b['uname'] ?></td>
                        <td><?php echo $b['name'] ?></td>
                        <td><?= $b['uname'] == 'abu.kafa' ? 'Programmer' : $b['uinfo'] ?></td>
                        <td>
                            <?php 
                            if($u['uinfo'] == 'Superuser'){
                            ?>
                            <a onclick="if(confirm('Apakah anda yakin ?')){ location.href='user_act?delete=<?php echo $b['id']; ?>' }" class="btn btn-danger <?= $b['uname'] == 'abu.kafa' ? 'disabled' : '' ?>"><span data-feather='trash'></span></a>
                            <?php 
                            }
                            ?>
                        </td>
                    </tr>
                    <?php 
                    }
                    ?>
				</table>
			</div>
		</div>
	</div>
</main>

<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Input Pengguna Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">				
				<form action="user_act" method="post">	
					<div class="form-group mb-2">
						<label class="form-label">Nama</label>
						<input name="nama" type="text" class="form-control" id="nama">
					</div>	
					<div class="form-group mb-2">
						<label class="form-label">Username</label>
						<input name="uname" type="text" class="form-control" id="uname">
					</div>				
					<div class="form-group mb-2">
						<label class="form-label">Default Password</label>
						<input name="pass" id="pass" type="text" class="form-control" value="homeschooling" readonly>
					</div>	
					<div class="form-group mb-2">
						<label class="form-label">Keterangan</label>
						<select name="ket" type="text" class="form-select">
                            <option>User</option>
                            <option>Superuser</option>
                            <option>Penilaian</option>
                        </select>
					</div>		
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#tgl").datepicker({dateFormat : 'yy-mm-dd'});							
	});
</script>
