  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Pelanggan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Pelanggan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Pelanggan Baru</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>No Rekening</th>   <!-- Kolom tambahan -->
                            <th>Alamat</th>        <!-- Kolom tambahan -->
                            <th>No HP</th>         <!-- Kolom tambahan -->
                            <th><center>Status Pelanggan</center></th>
                            <th><center>Aksi</center></th>
                        </tr>
                    </thead>

                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--------------------------- MODAL --------------------------->

  <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pelanggan Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Form Tambah Pelanggan -->
            <form action="proses/proses_pelanggan.php" method="post">
                <div class="modal-body">
                <!-- Input Nama Pelanggan -->
                <div class="form-group">
                    <label for="nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" maxlength="50" placeholder="Masukkan Nama Pelanggan" required>
                </div>

                <!-- Input No Rekening -->
                <div class="form-group">
                    <label for="no_rek" class="col-form-label">No Rekening</label>
                    <input type="text" class="form-control" name="no_rek" id="no_rek" maxlength="20" placeholder="Masukkan No Rekening" required>
                </div>

                <!-- Input Alamat -->
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
                </div>

                <!-- Input No HP -->
                <div class="form-group">
                    <label for="no_hp" class="col-form-label">No HP</label>
                    <input type="text" class="form-control" name="no_hp" id="no_hp" maxlength="15" placeholder="Masukkan No HP" required>
                </div>

                 <!-- Input Status Pelanggan -->
                    <div class="form-group">
                        <label for="status_pelanggan" class="col-form-label">Status Pelanggan</label>
                        <select class="form-control" name="status_pelanggan" id="status_pelanggan" required>
                            <option value="1" selected="selected">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

  
  <!--------------------------- MODAL --------------------------->
  <div class="modal fade" id="modal-delete">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Konfirmasi Hapus Data Pelanggan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="proses/proses_pelanggan.php" method="post">
                  <div class="modal-body">
                      <p>Apa anda yakin ingin menghapus data pelanggan ini?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <input type="hidden" id="id_pelanggan_hapus" name="id_pelanggan" value="">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                      <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                  </div>
              </form>
          </div>
      </div>
    </div>

    <!-- /.modal-dialog -->
  </div>


  <!-- modal edit -->


  <!-- Modal Edit Pelanggan -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form Edit Pelanggan -->
            <form action="proses/proses_pelanggan.php" method="post">
                <div class="modal-body">
                    <!-- Hidden Input ID Pelanggan -->
                    <input type="hidden" name="id_pelanggan" id="edit_id_pelanggan">

                    <!-- Input Nama Pelanggan -->
                    <div class="form-group">
                        <label for="edit_nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" name="nama_pelanggan" id="edit_nama_pelanggan" maxlength="50" placeholder="Masukkan Nama Pelanggan" required>
                    </div>

                    <!-- Input No Rekening -->
                    <div class="form-group">
                        <label for="edit_no_rek" class="col-form-label">No Rekening</label>
                        <input type="text" class="form-control" name="no_rek" id="edit_no_rek" maxlength="20" placeholder="Masukkan No Rekening" required>
                    </div>

                    <!-- Input Alamat -->
                    <div class="form-group">
                        <label for="edit_alamat" class="col-form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="edit_alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
                    </div>

                    <!-- Input No HP -->
                    <div class="form-group">
                        <label for="edit_no_hp" class="col-form-label">No HP</label>
                        <input type="text" class="form-control" name="no_hp" id="edit_no_hp" maxlength="15" placeholder="Masukkan No HP" required>
                    </div>

                    <!-- Input Status Pelanggan -->
                    <div class="form-group">
                        <label for="edit_status_pelanggan" class="col-form-label">Status Pelanggan</label>
                        <select class="form-control" name="status_pelanggan" id="edit_status_pelanggan" required>
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    // This function fills in the form with the data to be edited
    function editdata(id_pelanggan, nama_pelanggan, no_rek, alamat, no_hp, status_pelanggan) {
        document.getElementById('edit_id_pelanggan').value = id_pelanggan;
        document.getElementById('edit_nama_pelanggan').value = nama_pelanggan;
        document.getElementById('edit_no_rek').value = no_rek;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_no_hp').value = no_hp;
        document.getElementById('edit_status_pelanggan').value = status_pelanggan;
    }
</script>


  <!-- modal edit -->

 
  <script> 
       $(function(){
  
            $('.table').DataTable({
               "responsive": true,
               "processing": true,
               "serverSide": true,
               "ajax":{
                        "url": "ajax/ajax_pelanggan.php?action=table_data",
                        "dataType": "json",
                        "type": "POST"
                      },
               "columns": [
                   { "data": "no" },
                   { "data": "nama_pelanggan" },
                   { "data": "no_rek" },
                   { "data": "alamat" },
                   { "data": "no_hp" },
                   { "data": "status_pelanggan" },
                   { "data": "aksi" },
               ]  
  
           });
         });
 
 </script>

 <script>
    function hapusdata(id_pelanggan) {
        document.getElementById("id_pelanggan_hapus").value = id_pelanggan;
    }

 </script>