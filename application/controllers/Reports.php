<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    private $db_group_satuharga = 'satuharga';
    public function __construct() {
        parent::__construct();
        $this->db_satuharga = $this->load->database($this->db_group_satuharga, TRUE); // set db connection to satu harga, to get beli table
    }
    public function index()
    {
        if(!$this->session->userdata('admin')) {
            redirect('login/index/err');
        }

        $data = GetHeaderFooter();
        $data['main'] = 'reports'; // views/content.php
        $data['title'] = 'Pertamina - Satu Harga Maps';
        // $data['template_key'] = 'partial_key'; 
        $this->load->view('template', $data);
    }
    public function purchase()
    {
        if(!$this->session->userdata('admin')) {
            redirect('login/index/err');
        }

        $data = GetHeaderFooter();
        $data['main'] = 'purchase'; // views/content.php
        $data['title'] = 'Pertamina - Satu Harga Maps';
        // $data['template_key'] = 'partial_key'; 
        $this->load->view('template', $data);
    }
    public function dailySale()
    {
        $data                = GetHeaderFooter();
        $data['title']      = $this->title;
        $data['main']       = 'daily_sale';
        // $data['filename']   = $this->filename;

        #$data['result']        = 1;
        if($this->input->post('tombol')){
            $post = $this->input->post();
            $exp  = explode("/",$post['tgl_start']);
            $data['s_tgl'] = $exp[2]."-".$exp[1]."-".$exp[0];
            $start_date = $data['s_tgl'];

            $exp = explode("/",$post['tgl_end']);
            $data['e_tgl'] = $exp[2]."-".$exp[1]."-".$exp[0];
            $end_date = $data['e_tgl'];
        } else {
            $start_date = "";
            $end_date   = "";
        }

        $query_stmt_all_spbu = "SELECT DISTINCT beli.no_spbu, prov.provinsi, kab.kabupaten FROM kg_beli_pribadi beli
        INNER JOIN (SELECT spbu.no_spbu, kab.id_prov, spbu.id_kab FROM kg_member_spbu spbu
        INNER JOIN kg_ref_kab kab
        ON spbu.id_kab = kab.id_kab) spbu
        ON beli.no_spbu = spbu.no_spbu
        INNER JOIN kg_ref_prov prov
        ON prov.id_prov = spbu.id_prov
        INNER JOIN kg_ref_kab kab
        ON kab.id_kab = spbu.id_kab
        ORDER BY beli.no_spbu;";
        $all_spbu = $this->db->query($query_stmt_all_spbu)->result_array(); 

        $result = [];
        // $ch = curl_init(); 

        //     // set url 
        // curl_setopt($ch, CURLOPT_URL, "http://ptmsatuharga.com/Api/Satuharga/filter_test/?start_date=2020-01-21&end_date=2020-02-21");

        // // return the transfer as a string 
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // // $output contains the output string 
        // $output = curl_exec($ch); 

        // // tutup curl 
        // curl_close($ch);      

        // // menampilkan hasil curl
        // echo $output;
        foreach ($all_spbu as $spbu) {

            $query_stmt_daily_avg = 'SELECT no_spbu, id_bbm, tgl, SUM(rupiah) AS rekap_penjualan ,  CONCAT(DAY(tgl),"-", MONTH(tgl),"-", YEAR(tgl)) AS `date`, DAY(tgl) AS `date_num`, SUBSTRING(DAYNAME(create_date), 1, 3) AS day
            FROM kg_beli_pribadi WHERE no_spbu = "'.$spbu['no_spbu'].'" AND tgl BETWEEN "'.$start_date.'" AND "'.$end_date.'" 
            GROUP BY no_spbu, id_bbm, tgl 
            ORDER BY no_spbu DESC, tgl DESC';
            // echo $query_stmt_daily_avg;
            $row_daily_avg_transaction = $this->db->query($query_stmt_daily_avg)->result_array();
            $result[] = [
                "no_spbu"       => $spbu["no_spbu"],
                "provinsi"      => $spbu["provinsi"],
                "kab"           => $spbu["kabupaten"],
                "transaction"   => $row_daily_avg_transaction
            ];
        }

        $count = 0;
        #$col_header = "&nbsp;"; // col header : 5 = 'E'
        $col_day_position = []; 
        for($date = new DateTime($start_date); $date <= new DateTime($end_date); $date->modify('+1 day')){
            $day_num    = ltrim($date->format('d'), '0');
            $day_name   = $this->format_date_indonesia($date->format('D')); // nama hari
            $month_name = ltrim($date->format('M'), '0'); // nama bulan
            $month_num  = ltrim($date->format('m'), '0'); // nomor bulan
            $year_name  = $date->format('Y'); // tahun
            $date_col   = $day_num . "-" . $month_num . "-" . $year_name;
            $col_day_position[] = ["day_num" => $day_num, "day_name" => $day_name, "date_col" => $date_col];
            #$col_header++;
            $count++;
        }

        $data['colom']  = $col_day_position;
        $data['result'] = $result;
        #}
        $this->load->view('template', $data);
    }
    public function getTahap()
    {
        $query = "SELECT DISTINCT CASE WHEN
        tahap = 1 THEN 'Pembangunan' WHEN tahap = 2 THEN 'Paralel Pembangunan' WHEN tahap = 3 THEN 'Perizinan PEMDA' WHEN tahap = 4 THEN 'Finalisasi' WHEN tahap = 5 THEN 'Operasi'
        END AS tahap,
        (select count(*) from sh_spbu_info inf where sh_spbu_info.tahap = inf.tahap) as total_tahap
        FROM
        sh_spbu_info";
        $parameter = array('Pembangunan','Paralel Pembangunan','Perizinan PEMDA','Finalisasi','Operasi');
        $data = $this->db_satuharga->query($query)->result();
        foreach ($data as $val) {
            $json['name'] = $val->tahap;
            $json['y'] = (int)$val->total_tahap;
            $dataz[] = $json;
        }
        echo json_encode(array('parameter'=>$parameter,'data_tahap'=>$dataz));
    }
    public function getTypeRegion()
    {
        $arr = array();
        $data_spbu_type = $this->db_satuharga->query('SELECT DISTINCT jenis_spbu from sh_spbu_info')->result();
        foreach ($data_spbu_type as $spbu_type) {
            $spbu_types[] = $spbu_type->jenis_spbu;
        }
        $arr['spbu_type'] = $spbu_types;

        $query = "
        SELECT DISTINCT
        (select COUNT(a.no_spbu) from sh_spbu_info a where jenis_spbu = 'SPBU Kompak') AS spbu_kompak,
        (select COUNT(a.no_spbu) from sh_spbu_info a where jenis_spbu = 'SPBUN Type A') AS spbun_type_a,
        (select COUNT(a.no_spbu) from sh_spbu_info a where jenis_spbu = 'Basic') AS basic,
        (select COUNT(a.no_spbu) from sh_spbu_info a where jenis_spbu = 'SPBU Modular') AS spbu_modular,
        (select COUNT(a.no_spbu) from sh_spbu_info a where jenis_spbu = 'SPBU Mini') AS spbu_mini
        FROM
        sh_spbu_info
        ";
        $data = $this->db_satuharga->query($query)->result();
        $arr['data'] = $data;

        echo json_encode($arr);
    }
    public function getTargetRegion()
    {
        $arr = array();
        $region = array('I','II','III','IV','V','VI','VII','VIII');
        $data_region = array('Region I','Region II','Region III','Region IV','Region V','Region VI','Region VII','Region VIII');
        foreach ($region as $key => $val_region) {
            $query = "
            SELECT DISTINCT
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'I' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_I,
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'II' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_II,
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'III' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_III,
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'IV' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_IV,
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'V' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_V,
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'VI' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_VI,
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'VII' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_VII,
            (select COUNT(a.no_spbu) from sh_spbu_info a where mor = 'VIII' and sh_spbu_info.tahun_operasi = a.tahun_operasi) AS mor_VIII,
            tahun_operasi
            FROM
            sh_spbu_info
            GROUP BY
            tahun_operasi,
            mor
            ";
            // $query = "SELECT COUNT(no_spbu) as 'total_spbu', mor , tahun_operasi from sh_spbu_info WHERE mor = '".$val_region."' group by tahun_operasi, mor";
            $regions['name'] = 'Region '.$val_region;
            $region_I = array();
            $region_II = array();
            $region_III = array();
            $region_IV = array();
            $region_V = array();
            $region_VI = array();
            $region_VII = array();
            $region_VIII = array();
            $data_target = $this->db_satuharga->query($query);
            foreach ($data_target->result() as $target) {
                $region_I[] = (int)$target->mor_I;
                $region_II[] = (int)$target->mor_II;
                $region_III[] = (int)$target->mor_III;
                $region_IV[] = (int)$target->mor_IV;
                $region_V[] = (int)$target->mor_V;
                $region_VI[] = (int)$target->mor_VI;
                $region_VII[] = (int)$target->mor_VII;
                $region_VIII[] = (int)$target->mor_VIII;
            }
            if ($val_region == "I") {
                $regions['data'] = $region_I;
            }elseif ($val_region == "II") {
                $regions['data'] = $region_II;
            }elseif ($val_region == "III") {
                $regions['data'] = $region_III;
            }elseif ($val_region == "IV") {
                $regions['data'] = $region_IV;
            }elseif ($val_region == "V") {
                $regions['data'] = $region_V;
            }elseif ($val_region == "VI") {
                $regions['data'] = $region_VI;
            }elseif ($val_region == "VII") {
                $regions['data'] = $region_VII;
            }elseif ($val_region == "VIII") {
                $regions['data'] = $region_VIII;
            }
            // print_r($data_target);
            // $regions['data'] = implode(',', $data_target->total_spbu);
            // if ($val_region == "I") {
            //     $regions['data'] = $regions_I;
            // }elseif ($val_region == "II") {
            //     $regions['data'] = array_unique($regions_II, SORT_LOCALE_STRING);
            // }elseif ($val_region == "III") {
            //     $regions['datax'] = $regions_III;
            // }
            $a[] = $regions;
        }
        // $db = $this->db_satuharga->query($query);
        // foreach ($db->result() as $get_target) {
        //     if (in_array($get_target->mor, $region)) {
        //         $data_implode[] = $get_target->total_spbu;
        //     }else{
        //         $data_implode[] = 0;
        //     }
        //     // if (in_array($get_target->mor, $region)) {
        //     //     $data['name'] = 'Region '.$get_target->mor;
        //     //     $data['data'] = (int)$get_target->total_spbu;
        //     // }else{
        //     //     $data['name'] = 'Region '.$region;
        //     //     $data['data'] = (int)0;
        //     // }
        //     // $arr[] = $data;
        // }
        // $implode = implode(',', $data_implode);
        // $data['data'] = $implode;
        echo json_encode($a);
    }
    public function format_date_indonesia($day_name_english){
        switch ($day_name_english) {
            case 'Sun':
            $hari_ini = "Minggu";
            break;

            case 'Mon':
            $hari_ini = "Senin";
            break;

            case 'Tue':
            $hari_ini = "Selasa";
            break;

            case 'Wed':
            $hari_ini = "Rabu";
            break;

            case 'Thu':
            $hari_ini = "Kamis";
            break;

            case 'Fri':
            $hari_ini = "Jumat";
            break;

            case 'Sat':
            $hari_ini = "Sabtu";
            break;

            default:
            $hari_ini = "Tidak di ketahui";
            break;
        }

        return $hari_ini;
    }
    public function report_stock_day()
    {
        if(!$this->session->userdata('admin')) {
            redirect('login/index/err');
        }

        $data = GetHeaderFooter();
        $data['main'] = 'stock_day'; // views/content.php
        $data['title'] = 'Pertamina - Satu Harga Maps';
        // $data['template_key'] = 'partial_key'; 
        $this->load->view('template', $data);
    }
    public function report_stock_month()
    {
        if(!$this->session->userdata('admin')) {
            redirect('login/index/err');
        }

        $data = GetHeaderFooter();
        $data['main'] = 'stock_month'; // views/content.php
        $data['title'] = 'Pertamina - Satu Harga Maps';
        // $data['template_key'] = 'partial_key'; 
        $this->load->view('template', $data);
    }
}
