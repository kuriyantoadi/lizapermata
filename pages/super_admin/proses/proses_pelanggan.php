<?php
include "../../../koneksi.php";  // Koneksi ke database

// Proses Tambah Pelanggan
if(isset($_POST['tambah'])){
    $nama_pelanggan  = addslashes(trim($_POST['nama_pelanggan']));
    $no_rek          = addslashes(trim($_POST['no_rek']));
    $alamat          = addslashes(trim($_POST['alamat']));
    $no_hp           = addslashes(trim($_POST['no_hp']));
    $status_pelanggan = addslashes(trim($_POST['status_pelanggan']));  // Status Pelanggan
    
    // Mengecek apakah pelanggan dengan nama yang sama sudah ada
    $query = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan WHERE nama_pelanggan='$nama_pelanggan'");
    if(mysqli_num_rows($query) == 0){
        $sql = mysqli_query($koneksi, "INSERT INTO tb_pelanggan (nama_pelanggan, no_rek, alamat, no_hp, status_pelanggan) 
                                        VALUES ('$nama_pelanggan', '$no_rek', '$alamat', '$no_hp', '$status_pelanggan')");
        if ($sql) { 
            header("Location: ../index.php?hal=pelanggan&pesan=successTambah");
        } else {
            header("Location: ../index.php?hal=pelanggan&pesan=gagal");
        }
    } else {
        header("Location: ../index.php?hal=pelanggan&pesan=duplikat");
    }
}

// Proses Ubah Pelanggan
if(isset($_POST['ubah'])){
    $id_pelanggan    = addslashes(trim($_POST['id_pelanggan']));
    $nama_pelanggan  = addslashes(trim($_POST['nama_pelanggan']));
    $no_rek          = addslashes(trim($_POST['no_rek']));
    $alamat          = addslashes(trim($_POST['alamat']));
    $no_hp           = addslashes(trim($_POST['no_hp']));
    $status_pelanggan = addslashes(trim($_POST['status_pelanggan']));  // Status Pelanggan
  
    $sql = mysqli_query($koneksi, "UPDATE tb_pelanggan 
                                   SET nama_pelanggan='$nama_pelanggan', no_rek='$no_rek', alamat='$alamat', no_hp='$no_hp', status_pelanggan='$status_pelanggan' 
                                   WHERE id_pelanggan='$id_pelanggan'");
    if ($sql) { 
        header("Location: ../index.php?hal=pelanggan&pesan=successUpdate");
    } else {
        header("Location: ../index.php?hal=pelanggan&pesan=gagalPerbaharui");
    }
}

// Proses Hapus Pelanggan
if(isset($_POST['hapus'])){
    $id_pelanggan = addslashes(trim($_POST['id_pelanggan']));
    
    $sql = mysqli_query($koneksi, "DELETE FROM tb_pelanggan WHERE id_pelanggan='$id_pelanggan'");
    if ($sql) { 
        header("Location: ../index.php?hal=pelanggan&pesan=successHapus");
    } else {
        header("Location: ../index.php?hal=pelanggan&pesan=gagalHapus");
    }
}
?>
