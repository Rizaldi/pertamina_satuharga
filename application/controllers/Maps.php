<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Maps extends CI_Controller {

    private $db_group_satuharga = 'satuharga';

    public function __construct() {

        parent::__construct();

        $this->db_satuharga = $this->load->database($this->db_group_satuharga, TRUE); // set db connection to satu harga, to get beli table

    }



    /**

     * Main Dashboard

     * Show datatable filter & export to excel

     * @return View

     */

    public function index()

    {

        if(!$this->session->userdata('admin')) {

            redirect('login/index/err');

        }



        $data = GetHeaderFooter();

        $data['main'] = 'maps'; // views/content.php

        $data['title'] = 'Pertamina - Satu Harga Maps';

        // $data['template_key'] = 'partial_key'; 

        $this->load->view('template', $data);

    }

    public function get_location()

    {

        $query = $this->db_satuharga->get("sh_spbu_info")->result();



        echo json_encode($query);

    }

    public function get_location_id()

    {

        $data['id'] = $this->input->post('id_info');

        $spbu['no_spbu'] = $this->input->post('no_spbu');

        $this->db_satuharga->join("sh_spbu_bobot","sh_spbu_bobot.id = sh_spbu_progress.id_bobot_spbu");

        $get_spbu_progress = $this->db_satuharga->get_where("sh_spbu_progress",$spbu)->result();

        

        $sql = "SELECT SUM(last_progress) AS `total_progress` FROM `sh_spbu_progress` where no_spbu = '".$spbu['no_spbu']."'";



        $total_progress = $this->db_satuharga->query($sql)->result_array()[0]['total_progress'];



        $query = $this->db_satuharga->get_where("sh_spbu_info",$data)->row();

        $query->data_bobot = $get_spbu_progress;

        $query->total_progress = floor($total_progress) * 100;

        $sql = $this->db_satuharga->query("SELECT id, progress_name FROM sh_spbu_bobot GROUP BY progress_name

            ORDER BY id");

        $query->bobot_progress_name = $sql->result_array();

        $query->bobots = $this->db_satuharga->query("SELECT * FROM sh_spbu_bobot")->result_array();



        foreach ($query->bobot_progress_name as $progress) {

            foreach ($query->bobots as $bobot) {

                if($progress['progress_name'] == $bobot['progress_name'] && $bobot['sub_progress_name'] != NULL){

                    $query->bobotz = true;

                }

            }

        }

        echo json_encode($query);

        // print_r($_POST); 

    }

    public function update_progress() {

        $progressParam = $this->input->post();

        $id_bobot = $progressParam['id']; // id bobot
        $no_spbu = $progressParam['no_spbu']; // id bobot
        $result = [];

        $bobotInfo = $this->db_satuharga->query("SELECT * FROM sh_spbu_bobot WHERE id = {$id_bobot} ")->result_array()[0];

        if($progressParam['state'] == 'checked') {

            // get bobot

            $ins = [

                'no_spbu' => $no_spbu,

                'id_info_spbu' => $no_spbu,

                'id_bobot_spbu' => $id_bobot,

                'last_progress' => $bobotInfo['bobot']

            ];



            if($this->db_satuharga->insert('sh_spbu_progress', $ins)) {

                $result = [

                    'status' => 'ok',

                    'progress_name' => $bobotInfo['progress_name'],

                    'sub_progress_name' => $bobotInfo['sub_progress_name'],

                    'id_bobot' => $id_bobot

                ];

            }



        } else if($progressParam['state'] == 'unchecked') {

            // delete row id

            if($this->db_satuharga->delete('sh_spbu_progress', ['id_bobot_spbu' => $id_bobot, 'no_spbu'=>$no_spbu] )) {

                $result = [

                    'status' => 'ok',

                    'message' => 'Id bobot ' . $id_bobot . ' sukses dihapus!',

                    'progress_name' => $bobotInfo['progress_name'],

                    'sub_progress_name' => $bobotInfo['sub_progress_name']                  

                ];

            }

        }



        if(!empty($result)){

            $total_progress = $this->db_satuharga->query("SELECT SUM(last_progress) AS `last_progress` FROM `sh_spbu_progress` where no_spbu = '".$no_spbu."'")->result_array()[0]['last_progress'];

            $result['total_progress'] = $total_progress;

            echo json_encode($result);

        }

    }





    public function load_progress() {

        $idBobotSpbuResult['data'] = $this->db_satuharga->query("SELECT id_bobot_spbu FROM `sh_spbu_progress` WHERE no_spbu = '".$this->input->post('no_spbu')."' ORDER BY `id` ASC")->result_array();

        // $idBobotSpbuResult['progress_name_once'] = $this->db_satuharga->query("SELECT DISTINCT progress_name FROM `sh_spbu_bobot` WHERE sub_progress_name IS NOT NULL ORDER BY `id` ASC")->result_array();

        $idBobotSpbuResult['progress_name_once'] = $this->db_satuharga->query("SELECT id, progress_name FROM `sh_spbu_bobot` WHERE sub_progress_name IS NOT NULL GROUP BY progress_name ORDER BY `id` ASC")->result_array();

        $sql = "SELECT SUM(last_progress) AS `total_progress` FROM `sh_spbu_progress` where no_spbu = '".$this->input->post('no_spbu')."'";



        $total_progress = $this->db_satuharga->query($sql)->result_array()[0]['total_progress'];



        $idBobotSpbuResult['total_progress'] = round($total_progress * 100);

        echo json_encode($idBobotSpbuResult);

    }

    public function get_data()

    {

        $id_info_spbu = $this->input->post('id_info');

        $no_spbu = $this->input->post('no_spbu');

        $startdate = $this->input->post('date_start');

        $enddate = $this->input->post('date_end');



        // $this->input->post('id_info');

        if (!empty($startdate)) {

            $this->db->where('tgl >=', $startdate);

            $this->db->where('tgl <=', $enddate);

        }

        $list = $this->db->get_where("view_excel",array('no_spbu'=>$no_spbu));

        if ($list->num_rows() > 0) {

            $no     = $_POST['start'];

            foreach ($list->result() as $row_data) {

                $no++;

                $aksi = '';



                // $aksi .= '<div class="btn-group">

                //               <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                //                 AKSI

                //               </button>

                //               <ul class="dropdown-menu pull-right" x-placement="bottom-start">';



                //             if($row_data->payment_status == 2){

                //                 $aksi .= '<li>

                //                             <a class="dropdown-item btn-konfirmasi" href="javascript:;" data-url="'.base_url('peserta/konfirmasi-bayar/' . $row_data->id_member).'">

                //                                 <i class="fa fa-check"></i> Konfirmasi Pembayaran

                //                             </a>

                //                         </li>';



                //                 $aksi .= '<div class="dropdown-divider"></div>';

                //             }



                //             $aksi .= '<li>

                //                         <a class="dropdown-item btn-detail" href="javascript:;" data-url="'.base_url('peserta/detail/' . $row_data->id_member).'">

                //                             <i class="fa fa-search"></i> Detail Data

                //                         </a>

                //                     </li>';



                //             $aksi .= '</ul>

                //             </div>';





                // $payment_status = '';

                // if($row_data->payment_status == 2){

                //     $payment_status = '<span class="text-info"><strong>Menunggu Konfirmasi</strong></span>';

                // } else if($row_data->payment_status == 3){

                //     $payment_status = '<span class="text-success"><strong>Sudah Bayar</strong></span>';

                // } else if($row_data->payment_status == 1) {

                //     $payment_status = '<span class="text-warning"><strong>Belum Bayar</strong></span>';

                // } else {

                //     $payment_status = '<span class="text-danger"><strong>Belum Pesan Tiket</strong></span>';

                // }



                $row = array();

                $row[] = $no;

                $row[] = $row_data->no_spbu;

                $row[] = $row_data->pilihan_bbm;

                $row[] = $row_data->stok_awal;

                $row[] = $row_data->terima;

                $row[] = $row_data->jual;

                $row[] = $row_data->stok_akhir;

                $row[] = $row_data->dot;

                $row[] = $row_data->cd;

                $row[] = $row_data->tgl;

                // $row[] = $aksi;

     

                $data[] = $row;

            }

        }else{

                $data = [];

        }

 

        $output = array(

                        "draw"              => $_POST['draw'],

                        "recordsTotal"      => 0,

                        "recordsFiltered"   => 0,

                        "data"              => $data

        );

        echo json_encode($output);

    }

    public function update_detail()

    {

        $id = $this->input->post('input_id');

        $post['pengusaha'] = $this->input->post('input_pengusaha');

        $post['no_spbu'] = $this->input->post('input_no_spbu');

        $post['alamat'] = $this->input->post('input_alamat');

        $post['tahun_operasi'] = $this->input->post('input_tahun_operasi');

        $post['mor'] = $this->input->post('input_region');

        $post['prov'] = $this->input->post('input_provinsi');

        $post['kab'] = $this->input->post('input_kabupaten');

        $post['kec'] = $this->input->post('input_kecamatan');

        $post['lat'] = $this->input->post('input_latitude');

        $post['lng'] = $this->input->post('input_longitude');

        $config['upload_path']          = './assets/img/img_spbu/';

        $config['allowed_types']        = 'gif|jpg|png';

        $config['max_size']             = 1000;



        $this->load->library('upload', $config);



        if ($_FILES) {

            if ( ! $this->upload->do_upload('img_spbu'))

            {

                    $error = array('error' => $this->upload->display_errors());

                    echo json_encode($error);

            }

            else

            {

                    $data = array('upload_data' => $this->upload->data());

                    $post['image_spbu'] = $data['upload_data']['file_name'];

                    if ($this->db_satuharga->update('sh_spbu_info', $post, array('id'=>$id))) {

                        echo json_encode(array('resp_id'=>1, 'msg'=>'Success Update Detail'));

                    }else{

                        echo json_encode(array('resp_id'=>0, 'msg'=>'Fail Update Detail','query'=>$this->db_satuharga->error()));

                    }

            }

        }else{

            if ($this->db_satuharga->update('sh_spbu_info', $post, array('id'=>$id))) {

                echo json_encode(array('resp_id'=>1, 'msg'=>'Success Update Detail'));

            }else{

                echo json_encode(array('resp_id'=>0, 'msg'=>'Fail Update Detail','query'=>$this->db_satuharga->error()));

            }

        }

    }

    public function insert_detail()

    {

        $post['pengusaha'] = $this->input->post('pengusaha');

        $post['no_spbu'] = $this->input->post('no_spbu');

        $post['alamat'] = $this->input->post('alamat');

        $post['tahun_operasi'] = $this->input->post('tgl_operasional');

        $post['tgl_operasional'] = $this->input->post('tgl_operasional');

        $post['mor'] = $this->input->post('mor');

        $post['prov'] = $this->input->post('prov');

        $post['kab'] = $this->input->post('kab');

        $post['kec'] = $this->input->post('kec');

        $post['lat'] = $this->input->post('lat');

        $post['lng'] = $this->input->post('lng');

        $config['upload_path']          = './assets/img/img_spbu/';

        $config['allowed_types']        = 'gif|jpg|png';

        $config['max_size']             = 1000;



        $this->load->library('upload', $config);



        if ($_FILES) {

            if ( ! $this->upload->do_upload('image_spbu'))

            {

                    $error = array('error' => $this->upload->display_errors());

                    echo json_encode($error);

            }

            else

            {

                    $data = array('upload_data' => $this->upload->data());

                    $post['image_spbu'] = $data['upload_data']['file_name'];

                    if ($this->db_satuharga->insert('sh_spbu_info', $post)) {

                        echo json_encode(array('resp_id'=>1, 'msg'=>'Success Update Detail'));

                    }else{

                        echo json_encode(array('resp_id'=>0, 'msg'=>'Fail Update Detail','query'=>$this->db_satuharga->error()));

                    }

            }

        }else{

            if ($this->db_satuharga->insert('sh_spbu_info', $post)) {

                echo json_encode(array('resp_id'=>1, 'msg'=>'Success Insert Detail'));

            }else{

                echo json_encode(array('resp_id'=>0, 'msg'=>'Fail Insert Detail','query'=>$this->db_satuharga->error()));

            }

        }

    }

}

