<?php 
include "../../../koneksi.php";
session_start();
$oleh                       = $_SESSION['id_user'];

//Proses Hapus Transaksi
//   if(isset($_POST['hapus_transaksi'])){
    $id_uang_keluar       = addslashes(trim($_GET['id_uang_keluar']));


    $sql = mysqli_query($koneksi, "DELETE FROM t_uang_keluar WHERE id_uang_keluar='$id_uang_keluar'");
      if ($sql) { 
        header("Location: ../index.php?hal=uang_keluar&pesan=successHapus");
      } else {
        header("Location: ../index.php?hal=uang_keluar&pesan=gagalHapus");
      }
//   }

?>