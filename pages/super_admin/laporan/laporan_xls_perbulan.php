<?php
  include('../../../koneksi.php');
  session_start(); //Mendapatkan Session
  if(!isset($_SESSION['super_admin'])){
    ?>
    <script >
        alert("Anda harus login terlebih dahulu");
        document.location="../login/index.php";
    </script>
    <?php
  }

  date_default_timezone_set('Asia/Jakarta');
  function tglIndonesia($str){
        $tr   = trim($str);
        $str    = str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'), $tr);
        return $str;
    }

  $thn              = addslashes(trim($_GET['tahun']));
  $bln              = addslashes(trim($_GET['bulan']));

  $bulan = $bln;
  if ($bulan == 1) {
    $new_bulan = 'Januari';
  } else if ($bulan == 2){
    $new_bulan = 'Febuari';
  } else if ($bulan == 3){
    $new_bulan = 'Maret';
  } else if ($bulan == 4){
    $new_bulan = 'April';
  } else if ($bulan == 5){
    $new_bulan = 'Mei';
  } else if ($bulan == 6){
    $new_bulan = 'Juni';
  } else if ($bulan == 7){
    $new_bulan = 'Juli';
  } else if ($bulan == 8){
    $new_bulan = 'Agustus';
  } else if ($bulan == 9){
    $new_bulan = 'September';
  } else if ($bulan == 10){
    $new_bulan = 'Oktober';
  } else if ($bulan == 11){
    $new_bulan = 'November';
  } else if ($bulan == 12){
    $new_bulan = 'Desember';
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Transaksi Penjualan Per <?= $new_bulan.' '.$thn ?></title>
    <link href="../../../template_beck_end/images/<?= $logo_website ?>" rel="icon">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../../../template_beck_end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_perbulan.xls");
?>

  <center>
    
    <h5>Laporan Total Transaksi Penjualan Per <?= $new_bulan.' '.$thn ?></h5>
    <?php
        $query = mysqli_query($koneksi,"SELECT * FROM transaksi WHERE YEAR(tanggal_transaksi)=$thn AND MONTH(tanggal_transaksi)=$bln");
        if(mysqli_num_rows($query) == 0){
        echo '<b>TIDAK ADA TRANSAKSI PENJUALAN</b>';
        } else { 
    ?>
  </center>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Tanggal Transaksi</th>
        <th>Kode Keranjang</th>
        <th>Jumlah</th>
        <th>Total Harga</th>
        <th>Metode Pembayaran</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE YEAR(tanggal_transaksi)=$thn AND MONTH(tanggal_transaksi)=$bln ORDER BY tanggal_transaksi ASC");
        while ($hasil_transaksi = mysqli_fetch_array($query)) {
          $kode_keranjang       = $hasil_transaksi['kode_keranjang'];
          $jumlah_yang_dibeli   = $hasil_transaksi['jumlah_yang_dibeli'];
          $total_harga          = $hasil_transaksi['total_harga'];
          $tanggal_transaksi    = $hasil_transaksi['tanggal_transaksi'];
          $metode_pembayaran    = $hasil_transaksi['metode_pembayaran'];
          $keterangan_pembayaran    = $hasil_transaksi['keterangan_pembayaran'];
      ?>
      <tr>
        <td><?= tglblnthnjam($tanggal_transaksi) ?></td>
        <td><?= $kode_keranjang ?></td>
        <td><?= $jumlah_yang_dibeli ?></td>
        <td><?= 'Rp '.number_format($total_harga) ?></td>
        <td><?= $metode_pembayaran.' - '.$keterangan_pembayaran ?></td>
      </tr>
      <?php } ?>
      <?php
        $query_kode_total_pendapatan   = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total_pendapatan FROM transaksi WHERE YEAR(tanggal_transaksi)=$thn AND MONTH(tanggal_transaksi)=$bln");
        $sql_total_pendapatan          = mysqli_fetch_array($query_kode_total_pendapatan); 
        $sql_total_pendapatan          = $sql_total_pendapatan['total_pendapatan'];
      ?>
      <tr>
        <td>Total Pendapatan Pada Bulan <?= $new_bulan.' Tahun '.$thn ?></td>
        <td><?= 'Rp. '.number_format($sql_total_pendapatan) ?></td>
      </tr>
      <?php
        $query_kode_total_pendapatan_tunai   = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total_pendapatan FROM transaksi WHERE tanggal_transaksi LIKE '%$tanggal%' AND metode_pembayaran='Tunai' AND YEAR(tanggal_transaksi)=$thn AND MONTH(tanggal_transaksi)=$bln");
        $sql_total_pendapatan_tunai          = mysqli_fetch_array($query_kode_total_pendapatan_tunai); 
        $sql_total_pendapatan_tunai          = $sql_total_pendapatan_tunai['total_pendapatan'];
      ?>
      <tr>
        <td>Total Pendapatan Uang Tunai Pada <?= $new_bulan.' Tahun '.$thn ?></td>
        <td><?= 'Rp. '.number_format($sql_total_pendapatan_tunai) ?></td>
      </tr>
      <?php
        $query_kode_total_pendapatan_non_tunai   = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total_pendapatan FROM transaksi WHERE tanggal_transaksi LIKE '%$tanggal%' AND metode_pembayaran='Lainnya' AND YEAR(tanggal_transaksi)=$thn AND MONTH(tanggal_transaksi)=$bln");
        $sql_total_pendapatan_non_tunai          = mysqli_fetch_array($query_kode_total_pendapatan_non_tunai); 
        $sql_total_pendapatan_non_tunai          = $sql_total_pendapatan_non_tunai['total_pendapatan'];
      ?>
      <tr>
        <td>Total Pendapatan Non Tunai Pada <?= $new_bulan.' Tahun '.$thn ?></td>
        <td><?= 'Rp. '.number_format($sql_total_pendapatan_non_tunai) ?></td>
      </tr>
    </tbody>
  </table>
</body>
</html>
<?php } ?>