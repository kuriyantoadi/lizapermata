<?php 
require_once '../../../koneksi.php';

if ($_GET['action'] == "table_data") {

    $columns = array( 
        0 => 'id_pelanggan', 
        1 => 'nama_pelanggan',
        2 => 'no_rek',
        3 => 'alamat',
        4 => 'no_hp',
        5 => 'status_pelanggan'
    );

    // Hitung jumlah total data
    $querycount = $koneksi->query("SELECT count(id_pelanggan) as jumlah FROM tb_pelanggan");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    // Ambil data dari POST, gunakan nilai default jika tidak ada
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;  // default 10 jika tidak ada 'length'
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;     // default 0 jika tidak ada 'start'
    $order_column_index = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0; 
    $order = $columns[$order_column_index];
    $dir = isset($_POST['order'][0]['dir']) && $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

    // Query dasar
    $sql = "SELECT * FROM tb_pelanggan";

    // Cek apakah ada pencarian
    if (!empty($_POST['search']['value'])) {
        $search = $koneksi->real_escape_string($_POST['search']['value']);
        $sql .= " WHERE nama_pelanggan LIKE '%$search%' OR no_rek LIKE '%$search%' OR alamat LIKE '%$search%' OR no_hp LIKE '%$search%'";
        $querycount = $koneksi->query("SELECT count(id_pelanggan) as jumlah FROM tb_pelanggan WHERE nama_pelanggan LIKE '%$search%' OR no_rek LIKE '%$search%' OR alamat LIKE '%$search%' OR no_hp LIKE '%$search%'");
        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    // Order dan limit
    $sql .= " ORDER BY $order $dir LIMIT $start, $limit";
    $query = $koneksi->query($sql);

    $data = array();
    if ($query->num_rows > 0) {
        $no = $start + 1;
        while ($r = $query->fetch_assoc()) {
            $id_pelanggan = $r['id_pelanggan'];
            if ($r['status_pelanggan'] == 1) {
                $status = '<center><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fa fa-check"></i> Aktif</button></center>';
            } else {
                $status = '<center><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-times"></i> Tidak Aktif</button></center>';
            }

            $nestedData['no'] = $no;
            $nestedData['nama_pelanggan'] = $r['nama_pelanggan'];
            $nestedData['no_rek'] = $r['no_rek'];
            $nestedData['alamat'] = $r['alamat'];
            $nestedData['no_hp'] = $r['no_hp'];
            $nestedData['status_pelanggan'] = $status;
            $nestedData['aksi'] =  '
                <center>
                    <button type="button" class="btn btn-success btn-sm" value="'.$id_pelanggan.'" onclick="ubahdata(this.value)" data-toggle="modal" data-target="#ubah"><i class="fa fa-edit"></i> Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" value="'.$id_pelanggan.'" onclick="hapusdata(this.value)"><i class="fa fa-trash"></i> Hapus</button>
                </center>';
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,  
        "recordsTotal" => intval($totalData),  
        "recordsFiltered" => intval($totalFiltered), 
        "data" => $data
    );

    echo json_encode($json_data);
}
?>
