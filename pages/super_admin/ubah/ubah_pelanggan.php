<?php
include '../../../koneksi.php'; // Include your database connection file

// Get the key_pelanggan from the GET request
$key_pelanggan = addslashes(trim($_GET['q']));

// Query to select the customer details
$query = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE key_pelanggan='$key_pelanggan'");
$hasil_pelanggan = mysqli_fetch_array($query);

// Extract the necessary fields from the result
$nama_pelanggan = $hasil_pelanggan['nama_pelanggan'];
$no_rek = $hasil_pelanggan['no_rek'];
$alamat = $hasil_pelanggan['alamat'];
$no_hp = $hasil_pelanggan['no_hp'];
$status_pelanggan = $hasil_pelanggan['status_pelanggan'];

?>
<div class="form-group">
    <label for="recipient-name" class="col-form-label">Nama Pelanggan</label>
    <input type="hidden" class="form-control" name="key_pelanggan" value="<?= $key_pelanggan ?>" readonly required>
    <input type="text" class="form-control" name="nama_pelanggan" maxlength="50" placeholder="Masukkan Nama Pelanggan" value="<?= htmlspecialchars($nama_pelanggan) ?>" required>
</div>
<div class="form-group">
    <label for="no_rek" class="col-form-label">No Rekening</label>
    <input type="text" class="form-control" name="no_rek" maxlength="20" placeholder="Masukkan No Rekening" value="<?= htmlspecialchars($no_rek) ?>" required>
</div>
<div class="form-group">
    <label for="alamat" class="col-form-label">Alamat</label>
    <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat" required><?= htmlspecialchars($alamat) ?></textarea>
</div>
<div class="form-group">
    <label for="no_hp" class="col-form-label">No HP</label>
    <input type="text" class="form-control" name="no_hp" maxlength="15" placeholder="Masukkan No HP" value="<?= htmlspecialchars($no_hp) ?>" required>
</div>
<div class="form-group">
    <label>Status Pelanggan</label>
    <select class="form-control select2" style="width: 100%;" name="status_pelanggan" required>
        <option value="<?= $status_pelanggan ?>" selected="selected">
            <?php 
            if ($status_pelanggan == 1) { 
                echo 'Aktif'; 
            } else if ($status_pelanggan == 2) { 
                echo 'Tidak Aktif'; 
            } else { 
                echo 'Terjadi Gangguan'; 
            } ?>
        </option>
        <option value="1">Aktif</option>
        <option value="2">Tidak Aktif</option>
    </select>
</div>
