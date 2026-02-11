<?php 
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false; if ($update) { 
 	$sql = $connection->query("SELECT * FROM jenis WHERE id_jenis='$_GET[key]'"); 
 	$row = $sql->fetch_assoc(); 
} 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
 	if ($update) { 
 	 	$sql = "UPDATE jenis SET nama='$_POST[nama]' WHERE id_jenis='$_GET[key]'"; 
 	} else { 
 	 	$sql = "INSERT INTO jenis VALUES (NULL, '$_POST[nama]')"; 
 	} 
  if ($connection->query($sql)) { 
    echo alert("Berhasil!", "?page=jenis"); 
  } else { 
 	 	echo alert("Gagal!", "?page=jenis"); 
  } 
} 
if (isset($_GET['action']) AND $_GET['action'] == 'delete') { 
  $connection->query("DELETE FROM jenis WHERE id_jenis='$_GET[key]'");  	echo alert("Berhasil!", "?page=jenis"); 
} 
?> 
 
<style type="text/css"> 
 	.card{ 
 	 	margin-top: 15px; 
 	} 
</style> 
 
<div class="row"> 
 	<div class="col-md-4 d-print-none"> 
 	    <div class="card card-<?= ($update) ? "warning" : "info" ?>"> 
 	        <div class="card-header"><h3 class="text-center"><?= ($update) ? "EDIT JENIS" : "TAMBAH JENIS" ?></h3></div> 
 	        <div class="card-body"> 
 	            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST"> 
 	                <div class="form-group"> 
 	                    <label for="nama">Nama</label> 
 	                    <input type="text" name="nama" class="form-control" <?= 
(!$update) ?: 'value="'.$row["nama"].'"' ?> placeholder="Masukkan Nama Jenis"> 
 	                </div> 
 	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : 
"info" ?> btn-block">Simpan</button> 
 	                <?php if ($update): ?> 
 	 	 	 	 	 	 	 	 	 	<a href="?page=jenis" class="btn btn-info btn-block">Batal</a> 
 	 	 	 	 	 	 	 	 	<?php endif; ?> 
 	            </form> 
 	        </div> 
 	    </div> 
 	</div> 
 	<div class="col-md-8"> 
 	    <div class="card card-info"> 
 	        <div class="card-header"><h3 class="text-center">DAFTAR 
JENIS</h3></div> 
 	        <div class="card-body"> 
 	            <table class="table table-condensed"> 
 	                <thead> 
 	                    <tr> 
 	                        <th>No</th> 
 	                        <th>Nama</th> 
 	                        <th class="d-print-none" style="text-align: center;">Aksi</th> 
 	                    </tr> 
 	                </thead> 
 	                <tbody> 
 	                    <?php $no = 1; ?> 
 	                    <?php if ($query = $connection->query("SELECT * FROM jenis")): 
?> 
 	                        <?php while($row = $query->fetch_assoc()): ?> 
 	                        <tr> 
 	                            <td><?=$no++?></td> 
 	 	 	 	 	 	 	 	 	 
 	 	 	 	 	<td><?=$row['nama']?></td> 
 	                            <td class="d-print-none" style="text-align: center;"> 
 	                                <div class="btn-group"> 
 	                                    <a 
href="?page=jenis&action=update&key=<?=$row['id_jenis']?>" class="btn btn-warning btn-sm">Edit</a> 
 	                                    <a 
href="?page=jenis&action=delete&key=<?=$row['id_jenis']?>" class="btn btn-danger btn-sm">Hapus</a> 
 	                                </div> 
 	                            </td> 
 	                        </tr> 
 	                        <?php endwhile ?> 
 	                    <?php endif ?> 
 	                </tbody> 
 	            </table> 
 	        </div> 
 	 	 	    <div class="card-footer d-print-none"> 
 	 	 	        <a onClick="window.print();return false" class="btn 
btn-primary" style="color: white;"><i class="fas fa-print" style="color: white;"></i> 
Cetak</a> 
 	 	 	    </div> 
 	    </div> 
 	</div> 
</div> 
 
admin/lap_denda.php 
<br> 
<form class="form-inline d-print-none" action="<?=$_SERVER["REQUEST_URI"]?>" method="post"> 
 	 	<label>Periode</label> 
 	 	<input type="date" class="form-control" name="start" 
style="margin-left: 5px; margin-right: 5px;"> 
 	 	<label>s/d</label> 
 	 	<input type="date" class="form-control" name="stop" 
style="margin-left: 5px; margin-right: 5px;"> 
 	 	<button type="submit" class="btn btn-primary 
btn-sm">Tampilkan</button> 
 	</form> 
 	<br> 
 	<?php if ($_POST): ?> 
 	 	<div class="card card-info"> 
 	 	 	<div class="card-header"><h3 
class="text-center">LAPORAN DENDA</h3><h4 class="text-center">Tanggal: 
<?=$_POST['start']?> s/d <?=$_POST['stop']?></h4></div> 
 	 	 	<div class="card-body"> 
 	 	 	 	 	<table class="table table-condensed"> 
 	 	 	 	 	 	 	<thead> 
 	 	 	 	 	 	 	 	 	<tr> 
 	 	 	 	 	 	 	 	 	 
 	<th>No</th> 
 	 	 	 	 	 	 	 	 	 
 	<th>Nama Pelanggan</th> 
 	 	 	 	 	 	 	 	 	 
 	<th>Tanggal Ambil</th> 
 	 	 	 	 
 	<th>Tanggal Kembali</th> 	 	 	 	 	 
 	 	 	 
 	<th>Terlambat</th> 	 	 	 	 	 	 
 	 	 	 
 	<th>Total Harga</th> 	 	 	 	 	 	 
 	 	 	 
 	<th>Denda</th> 
 	 	 	 	 	 	 
 	 	 	 	 	 	 	 	 	</tr> 
 	 	 	 	 	 	 	</thead> 	
 	 	 	 	 	 	 	<tbody> 	
 	 	 	 
= 1; ?> 	 	 	 	 	 	<?php $no 
 	 	 	 	 	 	 	 	 	<?php if 
($query = $connection->query("SELECT p.nama, t.total_harga, t.denda, t.tgl_sewa, 
t.tgl_ambil, t.tgl_kembali, (TIMESTAMPDIFF(HOUR, ADDDATE(t.tgl_ambil, INTERVAL 
t.lama DAY), t.tgl_kembali)) AS terlambat FROM transaksi t JOIN pelanggan p USING(id_pelanggan) WHERE t.denda != 0 AND t.tgl_sewa BETWEEN '$_POST[start]' AND '$_POST[stop]'")): ?> 
 	 	 	 	 	 	 	 	 	 
 	<?php while($row = $query->fetch_assoc()): ?> 
 	 
 	<tr> 	 	 	 	 	 	 	 	 
 	 	 	 	 	 	 	 	 	 
 	 	 	<td><?=$no++?></td> 
 	 	 	 	 	 	 	 	 	 
 	 	 	<td><?=$row['nama']?></td> 
 	 	 	 	 	 	 	 	 	 
 	 	 	<td><?=date("d-m-Y H:i:s", 
strtotime($row['tgl_ambil']))?></td> 
 	 	 	 	 	 	 	 	 	 
 	 	 	<td><?=date("d-m-Y H:i:s", 
strtotime($row['tgl_kembali']))?></td> 
 	 	 	 	 	 	 	 	 	 
 	 	 	<td><?=$row['terlambat']?> jam</td> 
 	 	 	 	 	 	 	 	 	 
 	 	 	<td>Rp.<?=number_format($row['total_harga'])?>,-</td> 
 	 	 	 	 	 	 	 	 	 
 	 	 	<td>Rp.<?=number_format($row['denda'])?>,-</td> 
 	 
 	</tr> 	 	 	 	 	 	 	 	 
 	 	 	 	 	 	 	 	 	 
 	<?php endwhile ?> 
 	 	 	 	 	 	 	 	 	<?php endif ?> 
 	 	 	 	 	 	 	</tbody> 
 	 	 	 	 	</table> 
 	 	 	</div> 
 	    <div class="card-footer d-print-none"> 
 	        <a onClick="window.print();return false" class="btn btn-primary" style="color: white;"><i class="fas fa-print" style="color: white;"></i> Cetak</a> 
 	    </div> 
 	 	</div> 
<?php endif; ?> 
