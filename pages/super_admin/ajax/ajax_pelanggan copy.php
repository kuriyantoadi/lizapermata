<?php 
require_once '../../../koneksi.php';
// session_start();

session_start();
if (!isset($_SESSION['id_user'])) {
    echo "Session tidak terdeteksi!";
    exit;
}


$id_dari_session_header             = $_SESSION['id_user'];
if($_GET['action'] == "table_data"){
 
 
      $columns = array( 
                               0 =>'id_pelanggan', 
                               1 =>'nama_pelanggan',
                               2=> 'no_rek',
                               3=> 'alamat',
                               4=> 'no_hp',
                               5=> 'id_pelanggan',
                           );
 
    //   $querycount = $koneksi->query("SELECT count(id_pelanggan) as jumlah FROM tb_pelanggan WHERE id_pelanggan NOT IN('$id_dari_session_header')");
      $querycount = $koneksi->query("SELECT count(id_pelanggan) as jumlah FROM tb_pelanggan");
    //   var_dump($querycount);

    //   exit();
      $datacount = $querycount->fetch_array();
    
   
        $totalData = $datacount['jumlah'];
             
        $totalFiltered = $totalData; 
 
        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order = $columns[$_POST['order']['0']['column']];
        $dir = $_POST['order']['0']['dir'];
             
        if(empty($_POST['search']['value']))
        {            
         $query = $koneksi->query("SELECT * FROM tb_pelanggan WHERE id_pelanggan NOT IN('$id_dari_session_header') order by $order $dir
                                                      LIMIT $limit
                                                      OFFSET $start");
        }
        else {
            $search = $_POST['search']['value']; 
            $query = $koneksi->query("SELECT * FROM tb_pelanggan WHERE id_pelanggan NOT IN('$id_dari_session_header') AND nama LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'
                                                         order by $order $dir
                                                         LIMIT $limit
                                                         OFFSET $start");
 
 
           $querycount = $koneksi->query("SELECT count(id_pelanggan) as jumlah FROM tb_pelanggan WHERE id_pelanggan NOT IN('$id_dari_session_header') AND nama LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'");
           $datacount = $querycount->fetch_array();
           $totalFiltered = $datacount['jumlah'];
        }
 
        $data = array();
        if(!empty($query))
        {
            $no = $start + 1;
            while ($r = $query->fetch_array())
            {
                $id_pelanggan                   = $r['id_pelanggan'];

                if ($r['status_aktif'] == 1) {
                    $new_status_aktif = '<center><button type="button" class="btn btn-block btn-primary btn-sm"><i class="fa fa-check"></i> Aktif</button></center>';
                } else if ($r['status_aktif'] == 2) {
                    $new_status_aktif = '<center><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-times"></i> Blokir</button></center>';
                } else {
                    $new_status_aktif = '<center><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-check"></i> Terjadi Gangguan</button></center>'; 

                }

                if ($r['level'] == 1) {
                    $new_level = '<center><button type="button" class="btn btn-block btn-primary btn-sm">Superadmin</button></center>';
                } else if ($r['level'] == 2) {
                    $new_level = '<center><button type="button" class="btn btn-block btn-warning btn-sm">Kasir</button></center>';
                } else if ($r['level'] == 3) {
                    $new_level = '<center><button type="button" class="btn btn-block btn-info btn-sm">Investor</button></center>';
                } else {
                    $new_level = '<center><button type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-check"></i> Terjadi Gangguan</button></center>'; 

                }

                $nestedData['no']          = $no;
                $nestedData['nama_pelanggan']         = $r['nama_pelanggan'];
                $nestedData['no_rek']             = $r['no_rek'];
                $nestedData['alamat']            = $r['alamat'];              
                $nestedData['id_pelanggan']             =  '
                                                    <center>
                                                        <button type="button" class="btn btn-block btn-success btn-sm" value='.$id_pelanggan.' onclick="ubahdata(this.value)" data-toggle="modal" data-target="#ubah"><i class="fa fa-edit"></i> Ubah</button>
                                                        <button type="button" class="btn btn-block btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" value='.$id_pelanggan.' onclick="hapusdata(this.value)"><i class="fa fa-trash"></i> Hapus</button>
                                                    </center>';
                $data[] = $nestedData;
                $no++;
            }
        }
           
        $json_data = array(
                    "draw"            => intval($_POST['draw']),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data  
                    );
             
        echo json_encode($json_data); 
 
}
?>