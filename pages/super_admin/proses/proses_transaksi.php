<?php
include "../../../koneksi.php";
session_start();
$oleh                       = $_SESSION['id_user'];

//Proses Tambah
if(isset($_POST['tambah'])){
  $id_kategori              = addslashes(trim($_POST['id_kategori']));
  $id_produk                = addslashes(trim($_POST['id_produk']));
  $banyaknya                = addslashes(trim($_POST['banyaknya']));
  $kode_keranjang           = addslashes(trim($_POST['kode_keranjang']));
  $id_pelanggan             = addslashes(trim($_POST['id_pelanggan']));
  $key_keranjang            = $kode_keranjang;
  
  $query_cari_produk        = mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk=$id_produk");
  $sql_cari_produk          = mysqli_fetch_array($query_cari_produk);
  $harga                    = $sql_cari_produk['harga_produk'];
  $stok                     = $sql_cari_produk['stok'];

  $var_kurangi_stok         = $stok - $banyaknya;
 
  $var = '/^[0-9]*$/';

  if(!preg_match($var,$banyaknya)){
    header("Location: ../index.php?hal=keranjang&pesan=gagal");
    } else {
      if ($stok >= $banyaknya) {
        $query = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE kode_keranjang='$kode_keranjang' AND id_produk='$id_produk' AND oleh='$oleh'");
        if(mysqli_num_rows($query) == 0){
        $sql = mysqli_query($koneksi, "INSERT INTO keranjang VALUES(NULL,'$kode_keranjang','$id_produk','$banyaknya','$harga','2',NOW(),'$key_keranjang','$oleh','$id_pelanggan')");
        $sql = mysqli_query($koneksi, "UPDATE produk SET stok='$var_kurangi_stok' WHERE id_produk='$id_produk'");
          if ($sql) { 
            header("Location: ../index.php?hal=keranjang&pesan=successTambah");
          } else {
            header("Location: ../index.php?hal=keranjang&pesan=gagal");
          }
        }else {
          header("Location: ../index.php?hal=keranjang&pesan=duplikat");
        }
      } else {
        header("Location: ../index.php?hal=keranjang&pesan=gagalStokKurang");
      }
  } 
}

//Proses Tambah Transaksi
if(isset($_POST['bayar_dan_cetak'])){
    $total_qty                = addslashes(trim($_POST['total_qty']));
    $kode_keranjang           = addslashes(trim($_POST['kode_keranjang']));
    $total_bayar_hidden       = addslashes(trim($_POST['total_bayar_hidden']));
    $catatan                  = addslashes(trim($_POST['catatan']));
    $dari_mana_mengetahui     = addslashes(trim($_POST['dari_mana_mengetahui']));
    $result_lainya            = addslashes(trim($_POST['result_lainya']));
    $id_pelanggan             = addslashes(trim($_POST['id_pelanggan']));
    $key_keranjang            = md5($kode_keranjang);
   
    $sql = mysqli_query($koneksi, "INSERT INTO transaksi VALUES('','$kode_keranjang','$total_qty','$total_bayar_hidden','$catatan',NOW(),'$key_keranjang','$oleh','$dari_mana_mengetahui','$result_lainya','$id_pelanggan')");
    $sql = mysqli_query($koneksi, "UPDATE keranjang SET status_keranjang='1' WHERE kode_keranjang='$kode_keranjang' AND oleh='$oleh'");
      if ($sql) { 
        header("Location: ../invoice.php?kode_keranjang=".$kode_keranjang);
      } else {
        header("Location: ../index.php?hal=keranjang&pesan=gagal");
      }
}
?>
