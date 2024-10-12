<?php
  include('../../koneksi.php');
  session_start(); //Mendapatkan Session
  if(!isset($_SESSION['super_admin'])){
    ?>
    <script >
        alert("Anda harus login terlebih dahulu");
        document.location="../login/index.php";
    </script>
    <?php
  }

  function tglIndonesia($str){
        $tr   = trim($str);
        $str    = str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'), $tr);
        return $str;
    }

    $kode_keranjang              = $_GET['kode_keranjang'];

    $query_car_tanggal_beli   = mysqli_query($koneksi,"SELECT * FROM transaksi WHERE kode_keranjang='$kode_keranjang'");
    $sql_tanggal_beli           = mysqli_fetch_array($query_car_tanggal_beli); 
    $tanggal_transaksi          = $sql_tanggal_beli['tanggal_transaksi'];

    // pelanggan
    $query_cari_pelanggan     = mysqli_query($koneksi,"SELECT * FROM transaksi, tb_pelanggan WHERE tb_pelanggan.id_pelanggan=transaksi.id_pelanggan AND kode_keranjang='$kode_keranjang'");
    $sql_pelanggan            = mysqli_fetch_array($query_cari_pelanggan); 
    $nama_pelanggan           = $sql_pelanggan['nama_pelanggan'];
    $alamat_pelanggan           = $sql_pelanggan['alamat'];
    $no_hp_pelanggan           = $sql_pelanggan['no_hp'];


    // var_dump($transaksi_pelanggan);

    // exit();

?>

<!DOCTYPE html>
<html>
<head>
  <title>Struk Pembelian <?= $kode_keranjang ?></title>
    <link href="../../template_beck_end/images/<?= $logo_website ?>" rel="icon">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../../template_beck_end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    @media print {
      .btn-kembali {
        display: none;
      }
    }
  </style>


</head>
<body onload="print()"> 
  

  <table>
    <tr>
      <td>
        <!-- <img src="../../template_beck_end/images/<?= $logo_website ?>" style="width: 50px; height: 50px;"> -->
      </td>
      <td>
        <h2>Invoice # <?= $kode_keranjang ?></h2>
        <p><?= tglblnthnjam($tanggal_transaksi) ?></p>
      </td>
    </tr>
  </table>


  


  <div class="row">
    <div class="col-6 d-flex">
      
      <table>
        <tr>
          <td colspan=2><h4><b>From<b></h4></td>
        </tr>
        <tr>
          <td><?= $nama_website ?></td>
        </tr>
        <tr>
          <td> <?= $alamat_website ?></td>
        </tr>
        <tr>
          <td><?= $no_telepon_website ?></td>
        </tr>
      </table>

    </div>
    <div class="col-6 d-flex">
      
       <table>
        <tr>
          <td colspan=2><h4><b>To<b></h4></td>
        </tr>
        <tr>
          <td><?= $nama_pelanggan ?></td>
        </tr>
        <tr>
          <td> <?= $alamat_pelanggan ?></td>
        </tr>
        <tr>
          <td><?= $no_hp_pelanggan ?></td>
        </tr>
      </table>

    </div>
  </div>
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama Produk</th>
        <th>Qty</th>
        <th>Harga Satuan</th>
        <th>Total Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $query_keranjang = mysqli_query($koneksi, "SELECT
        nama_produk,
        qty_produk,
        harga_satuan,
        ( harga_satuan * qty_produk ) AS hargakaliqty,
        status_keranjang,
        tgl_keranjang,
        catatan 
    FROM
        produk AS pek
        RIGHT JOIN keranjang AS krj ON pek.id_produk = krj.id_produk
        RIGHT JOIN transaksi AS trs ON krj.kode_keranjang = trs.kode_keranjang 
    WHERE
        krj.status_keranjang = '1' 
        AND krj.kode_keranjang = '$kode_keranjang' 
    ORDER BY
        krj.tgl_keranjang ASC");
        while ($hasil_keranjang = mysqli_fetch_array($query_keranjang)) {
          $nama_produk          = $hasil_keranjang['nama_produk'];
          $qty_produk           = $hasil_keranjang['qty_produk'];
          $harga_satuan         = $hasil_keranjang['harga_satuan'];
          $hargakaliqty         = $hasil_keranjang['hargakaliqty'];
          $catatan              = $hasil_keranjang['catatan'];
      ?>
      <tr>
        <td><?= $nama_produk ?></td>
        <td><?= $qty_produk ?></td>
        <td><?= 'Rp '.number_format($harga_satuan) ?></td>
        <td><?= 'Rp '.number_format($hargakaliqty) ?></td>
      </tr>
      <?php } ?>
      <?php
        $query_kode_total_bayar   = mysqli_query($koneksi,"SELECT
        harga_satuan,
        kode_keranjang,
        qty_produk,
        SUM( harga_satuan * qty_produk ) AS totalbayar,
        SUM( qty_produk ) AS jumlah_qty, 
        status_keranjang,
        oleh 
    FROM
        kategori AS ktg
        RIGHT JOIN produk AS pdk ON ktg.id_kategori = pdk.id_kategori_produk
        RIGHT JOIN keranjang AS krj ON pdk.id_produk = krj.id_produk 
    WHERE
        krj.status_keranjang = '1' 
        AND krj.kode_keranjang = '$kode_keranjang' ");
        $sql_total_bayar          = mysqli_fetch_array($query_kode_total_bayar); 
        $total_pembayaran         = $sql_total_bayar['totalbayar'];
    ?>
      <tr>
        <td>Total Pembayaran</td>
        <td><?= 'Rp. '.number_format($total_pembayaran) ?></td>
      </tr>
    </tbody>
  </table>
    <?php
      if ($catatan == NULL) {

      } else { ?>
        <h5><b>*Catatan </b><?= $catatan ?></h5>
      <?php }
    ?>
    <?php 
      $query_oleh   = mysqli_query($koneksi,"SELECT
      * 
    FROM
      user AS usr
      INNER JOIN transaksi AS trs ON usr.id_user = trs.oleh 
  WHERE
      trs.kode_keranjang = '$kode_keranjang' ");
      $sql_oleh          = mysqli_fetch_array($query_oleh); 
      $diproses_oleh         = $sql_oleh['nama'];
    ?>
        <h5><b>Kasir </b><?= $diproses_oleh; ?></h5>
        <center><h5><b>~ Terimakasih atas kunjungan anda, kami harap anda menikmati pelayanan dan bisa datang kembali ~</b></h5></center>
        <br>&nbsp;
        <br>&nbsp;
        <br>&nbsp;

  <a class="btn btn-warning btn-lg btn-kembali mb-3" href="index.php?hal=transaksi">Ke Halaman Transaksi</a>

</body>
</html>