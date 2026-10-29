<?php
require_once 'navbar.php';
require_once 'koneksi.php';

$sql ="SELECT *FROM users order by id desc";

$hasil = mysqli_query ($koneksi, $sql);

if (mysqli_num_rows($hasil) > 0 ) {
  while ($baris = mysqli_fetch_assoc ($hasil)){
    $data[] = $baris;
  }
} else {
  echo "Tidak ada data";  
}
?>

<!-- awal content -->
<div class="container">
  
<!-- awal kolom -->
  <div class="container">
  <div class="row align-items-start">
    <div class="col-30">
     <!-- One of three columns-->
    </div>
    <div class="col-30">
     <br>
     <!-- awal card -->
      <div class="card">
  <div class="card-header">
   <h3>Tabel Daftar User</h3> 
  </div>
  <div class="card-body">
    <!-- awal tabel -->
     <table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Username</th>
      <th scope="col">Passwod</th>
      <th scope="col">Role</th>
      <th scope="col">Create At</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
       
  <tbody>
        <?php
        $no = 1;
        for ($i =0; $i < count($data);
        $i++) {
        ?>
          
    <tr>
      <th scope="row"><?php echo $no++ ?></th>
      <td><?= $data [$i] ['username'] ?></td>
      <td><?= $data [$i] ['password'] ?></td>
      <td><?= $data [$i] ['role'] ?></td>
      <td><?= $data [$i] ['created_at'] ?></td>
      <td>
        <a href="" class="btn btn-warning btn-sm">Edit</a>
        <a href ="" class="btn btn-danger btn-sm">Hapus</a>     
      </td>
    </tr>
          
       <?php } ?>
  </tbody>
     </table>
    <!-- akhir tabel -->
  </div>
      </div>
      <!-- akhir card -->
      
    </div>
    <div class="col-10">
       <!--One of three columns-->
        </div>
     </div>
  </div>
<!--akhir kolom -->
  
</div>
<!-- akhir content -->

<?php
require_once 'footer.php';
?>