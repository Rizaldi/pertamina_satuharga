<?php



/**

 * Created by PhpStorm.

 * User: DANJANNY

 * Date: 19/06/2019

 * Time: 14:31

 */

class Transaksi extends REST_Controller

{

    /**

     * main db table satu harga

     * @var string

     */

    private $satu_harga_table = "kg_bbm_satu_harga";



    public function __construct()

    {

        parent::__construct();

    }



    /**

     * Get value of loses

     * loses = stok akhir pada transaksi terakhir - stok awal saat transaksi berikutnya

     * params : ?no_spbu=xx.xxx&id_bbm=x

     * @return JSONArray

     */

    public function loses_get()

    {



        $no_spbu = $this->input->get('no_spbu');

        $id_bbm = $this->input->get('id_bbm');



        $query_stmt_loses = "SELECT loses 

                                FROM {$this->satu_harga_table} 

                                  WHERE no_spbu = {$no_spbu} AND id_bbm = {$id_bbm} 

                                    ORDER BY create_date DESC 

                                      LIMIT 0,1";



        $this->response($this->db->query($query_stmt_loses)->result());



    }



    /**

     * POST

     * Get stok akhir

     * @return JSON Object

     */

    public function stok_akhir_post()

    {

        $no_spbu = str_replace(" ", "", $_POST['no_spbu']);

        $id_bbm = str_replace(" ", "", $_POST['id_bbm']);



        $query_stmt_loses = "SELECT stok_akhir

                                FROM {$this->satu_harga_table}

                                  WHERE no_spbu = {$no_spbu} AND id_bbm = {$id_bbm}

                                    ORDER BY create_date DESC

                                      LIMIT 0,1";



        $this->response($this->db->query($query_stmt_loses)->row_array());

    }



    /**

     * Get stok akhir for satu_harga method

     * @param string $spbu_no

     * @param string $id_bbm

     * @return int

     */

    public function get_stok_akhir($no_spbu = "", $id_bbm = "")

    {

        $no_spbu = str_replace(" ", "", $no_spbu);

        $id_bbm = str_replace(" ", "", $id_bbm);

        $stok_akhir_terakhir = GetValue("stok_akhir", "kg_bbm_satu_harga", array("id_bbm" => "where/" . $id_bbm, "no_spbu" => "where/" . $no_spbu, "id" => "order/desc", "limit" => "0/1"));



        if(!$stok_akhir_terakhir) {

            return $stok_akhir_terakhir;

        } else {

            return $stok_akhir_terakhir;

        }

    }



    /**

     * Post data transaksi to table `kg_bbm_satu_harga`

     * POST param : id_bbm, no_spbu, stok_awal, terima, jual

     * @return String | ok or fail

     */

    public function satu_harga_post()

    {

        $ins['id_bbm'] = $_POST['id_bbm'];

        $ins['no_spbu'] = str_replace(" ", "", $_POST['no_spbu']);



        // stok awal

        $stok_awal_length = strlen((string)$_POST['stok_awal']);

        if ($stok_awal_length > 6) {

            $ins['stok_awal'] = 'error';

        } else {

            $ins['stok_awal'] = $_POST['stok_awal'];

        }



        // penerimaan

        $terima_length = strlen((string)$_POST['terima']);

        if ($terima_length > 6) {

            $ins['terima'] = 'error';

        } else {

            $ins['terima'] = $_POST['terima'];

        }



// 		$ins['terima'] = $_POST['terima'];

        if ($ins['terima'] == '000' || $ins['terima'] == '0') {

            $ins['terima'] = 0;

        } else if ($ins['terima'] == "") {

            $ins['terima'] = "";

        } else {

            $ins['terima'] = $ins['terima'];

        }



        // jual

        $jual_length = strlen((string)$_POST['jual']);

        if ($jual_length > 6) {

            $ins['jual'] = 'error';

        } else {

            $ins['jual'] = $_POST['jual'];

        }



        $ins['stok_akhir'] = $ins['stok_awal'] + $ins['terima'] - $ins['jual'];



        // jika spbu sudah pernah melakukan transaksi dengan id_bbm tertentu

        $rowCount = $this->db->query("SELECT * FROM kg_bbm_satu_harga WHERE no_spbu = '{$ins["no_spbu"]}' AND id_bbm = '{$ins["id_bbm"]}' ORDER BY create_date DESC")->num_rows();

        if ($rowCount > 0) {

            $ins['loses'] = $ins['stok_awal'] - $this->get_stok_akhir($ins['no_spbu'], $ins['id_bbm']);

        } else {

            $ins['loses'] = 0;

        }



        $ins['modify_date'] = date("Y-m-d H:i:s");

        $ins['create_date'] = date("Y-m-d H:i:s");

        $ins['tgl'] = date("Y-m-d");



        // filter input

        if ($ins['stok_awal'] == 'error') {

            echo "Angka Stok awal tidak boleh lebih dari 6 digit";

        } else if ($ins['jual'] == 'error') {

            echo "Angka penjualan tidak boleh lebih dari 6 digit";

        } else if ($ins['terima'] === "error") {

            echo "Angka penerimaan BBM tidak boleh lebih dari 6 digit";

        } else if ($ins['terima'] === "") {

            echo "Angka penerimaan BBM harus diisi 0";

        } else if ($ins['id_bbm'] == 0) {

            echo "Pilihan BBM harus dipilih salah satu";

        } else if ($ins['jual'] == "" || $ins['stok_awal'] == "") {

            echo "Kolom harus diisi";

        } else {



            // if user ingin revisi input di tanggal yang sama



            $q_cek_input = $this->db->query("SELECT * FROM kg_bbm_satu_harga WHERE id_bbm = '" . $ins['id_bbm'] . "' AND

		    no_spbu = '" . $ins['no_spbu'] . "' AND tgl = '" . $ins['tgl'] . "' ");



            // if spbu sudah input

            if ($q_cek_input->num_rows() > 0) {



                $this->db->where('id_bbm', $ins['id_bbm']);

                $this->db->where('no_spbu', $ins['no_spbu']);

                $this->db->where('tgl', $ins['tgl']);



                // update just modified_date

                unset($ins['create_date']);

                // update all data except modified date

                if ($this->db->update('kg_bbm_satu_harga', $ins)) {

                    $this->response(["status" => "ok", "message" => "updated"]);

                } else {

                    echo "Input Stock Gagal";

                }



            } else {



                if ($this->db->insert("kg_bbm_satu_harga", $ins)) {

                    $this->response(["status" => "ok", "message" => "inserted"]);

                } else {

                    echo "Input Stock Gagal";

                }



            }



        }

    }



    public function test_post()

    {

        $rowCount = $this->db->query("SELECT * FROM kg_bbm_satu_harga WHERE no_spbu = '{$_POST["no_spbu"]}' AND id_bbm = '{$_POST["id_bbm"]}' ORDER BY create_date DESC")

            ->num_rows();

        $this->response(["data" => $rowCount]);

    }

    public function satuhargadata_post()
    {
        $this->load->model('Spbu_model');
        $param['start_date'] = $this->input->post('start_date');
        $param['end_date'] = $this->input->post('end_date');
        if ($this->input->post('no_spbu') == "0") {
            $param['no_spbu'] = null;
        }else{
            $param['no_spbu'] = $this->input->post('no_spbu');
        }
        if ($this->input->post('no_pol') == "0") {
            $param['no_pol'] = null;
        }else{
            $param['no_pol'] = $this->input->post('no_pol');
        }
        

        $list   = $this->Spbu_model->get_datatables($param);
        $data   = array();
        $no     = $_POST['start'];
        foreach ($list as $row_data) {
            $no++;
            $aksi = '';

            $row = array();
            $row[] = $no;
            $row[] = $row_data->no_spbu;
            $row[] = $row_data->no_pol;
            $row[] = $row_data->no_hp;
            $row[] = 'Rp '.number_format($row_data->rupiah);
            $row[] = $row_data->tgl;
            // $row[] = $aksi;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw"              => $_POST['draw'],
                        "recordsTotal"      => $this->Spbu_model->count_all($param),
                        "recordsFiltered"   => $this->Spbu_model->count_filtered($param),
                        "data"              => $data,
                );
        echo json_encode($output);
        // if (!empty($start_date) || !empty($end_date)) {
        //     $this->db->where('tgl >=', $start_date);
        //     $this->db->where('tgl <=', $end_date);
        // }
        // if (!empty($no_spbu)) {
        //     $this->db->where('no_spbu', $no_spbu);
        // }
        // if (!empty($no_pol)) {
        //     $this->db->where('no_pol', $no_pol);
        // }
        // $this->db->where('app', 'satuharga');
        // $this->response($this->db->get("kg_beli_pribadi")->result());

    }

}