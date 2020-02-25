<?php

/**
 * Created by PhpStorm.
 * User: DANJANNY
 * Date: 19/07/2019
 * Time: 10:01
 */
class Spbu extends CI_Controller
{
    private $view_modifier = 'spbu';

    private $spbu_table = 'kg_member_spbu';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('spbu_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $this->main();
    }

    public function main()
    {
//        loggedin_permission();
        if (!$this->session->userdata('admin')) {
            redirect('login/index/err');
        }
        // header, sidebar, footer, main content
        $data = GetHeaderFooter();
        $data['main'] = $this->view_modifier;
        $data['title'] = 'Daftar SPBU';

        $this->load->view('template', $data);
    }

    public function edit($id_spbu = 0)
    {
        // id == 0 : create new data, insert
        // id > 0 : edit existing data, update
        if (!$this->session->userdata('admin')) {
            redirect('login/index/err');
        }

        $data = GetHeaderFooter();
        $data['main'] = $this->view_modifier . '_edit';
        $data['title'] = 'Edit SPBU';
        $data['filename'] = $this->view_modifier;

        // if edit button clicked (in the existing spbu)
        if ($id_spbu > 0) {
            // show an existing value of id_spbu
            if ($q_spbu_by_id = $this->db->query("SELECT * FROM {$this->spbu_table} 
                    WHERE id = {$id_spbu}")
            ) {
                // get id spbu untuk fetch data existing provinsi & kab kota
                $data['row_spbu'] = $q_spbu_by_id->row_array();
            }
        } else {
            $data['row_spbu']['id'] = 0;
        }

        // opt_prov
        $data['opt_prov'] = $this->get_data_provinsi();
        $data['opt_kab'] = $this->get_data_kab_kota();

        // else : add button clicked, show blank form

        $this->load->view('template', $data);
    }

    public function update()
    {
        $id_spbu = $this->input->post('id');

        foreach ($_POST as $field_name => $val) {
            if ($field_name != 'id' && $field_name != 'id_prov') {
                if ($field_name == 'password') {
                    $data[$field_name] = base64_encode($val);
                } else {
                    $data[$field_name] = $val;
                }
            }
        }

        $data['kategori_spbu'] = 2;
        $data['id_kec'] = 0;
        $data['modify_date'] = date('Y-m-d H:i:s');

        if ($id_spbu > 0) {

            $this->db->where('id', $id_spbu);
            $this->db->update('kg_member_spbu', $data);
            redirect('spbu');

        } else {

            $no_spbu = $this->input->post('no_spbu');
            $q_stmt_checkIfSpbuHasExisted = "SELECT * FROM kg_member_spbu WHERE no_spbu = {$no_spbu} AND kategori_spbu = 2";

            // check if spbu has existed before
            if ($count = $this->db->query($q_stmt_checkIfSpbuHasExisted)->num_rows() > 0) {
                $this->db->where('no_spbu', $no_spbu);
                $this->db->update('kg_member_spbu', $data);

                // if we create a new one
            } else {
                $data['modify_date'] = 0;
                $data['create_date'] = date('Y-m-d H:i:s');

                $this->db->insert('kg_member_spbu', $data);
            }

            // after insert / update, redirect to main spbu menu
            redirect('spbu');

        }
    }

    public function trash($id_spbu)
    {
        $upd['is_deleted'] = 1;
        $this->db->where('id', $id_spbu);
        $this->db->update('kg_member_spbu', $upd);
        redirect('spbu');
    }

    /**
     * Fetch data spbu for datatable source data
     * @return JSONArray of spbu with kategori_spbu = 2 (satu harga)
     */
    public function get_data_spbu()
    {
        $q_all_spbu = "SELECT spbu.id, spbu.no_spbu, kab.kabupaten 
                              FROM kg_member_spbu spbu
                                LEFT JOIN kg_ref_kab kab ON spbu.id_kab = kab.id_kab
                                  WHERE spbu.kategori_spbu = 2 AND is_deleted = 0";
        $all_spbu = $this->db->query($q_all_spbu)->result_array();

        echo json_encode(["data" => $all_spbu]);
    }

    /**
     * Get data provinsi & kab kota spbu by id_spbu
     * use as data source for datatable to show provinsi & kab / kota
     * @param $id_spbu
     */
    public function get_data_wilayah_spbu_by_id($id_spbu = null)
    {
        $q_spbu_by_id = "SELECT spbu.id, spbu.no_spbu, kab.id_kab, kab.kabupaten, kab.id_prov, prov.provinsi
                              FROM kg_member_spbu spbu
                                LEFT JOIN kg_ref_kab kab ON spbu.id_kab = kab.id_kab
                                LEFT JOIN kg_ref_prov prov ON prov.id_prov = kab.id_prov
                                  WHERE spbu.kategori_spbu = 2 AND spbu.id = {$id_spbu}";

        if ($id_spbu != null) {
            $spbu_by_id = $this->db->query($q_spbu_by_id)->result_array();
            echo json_encode($spbu_by_id);
        } else {
            echo json_encode(["status" => null]);
        }
    }

    public function get_data_provinsi()
    {
        $q_all_prov = "SELECT * FROM kg_ref_prov";
        $all_prov = $this->db->query($q_all_prov)->result_array();
        // ["id_prov" => "provinsi"]
        $opt = [];
        $opt[''] = '- Provinsi -';
        foreach ($all_prov as $prov) {
            $opt[$prov['id_prov']] = $prov['provinsi'];
        }
        return $opt;
    }

    public function get_data_kab_kota()
    {
//        $id_prov = $this->input->get('id_prov'); // get id_prov
//        $q_all_kab_kot = "SELECT * FROM kg_ref_kab WHERE id_prov = {$id_prov}";
        $q_all_kab_kot = "SELECT * FROM kg_ref_kab";
        $all_kab_kot = $this->db->query($q_all_kab_kot)->result_array();
        $opt = [];
        $opt[''] = '- Semua -';
        foreach ($all_kab_kot as $kab) {
            $opt[$kab['id_kab']] = $kab['kabupaten'];
        }
        return $opt;
    }

    public function get_kabupaten()
    {
        $id_prov = $this->input->get('id_prov');
        $id_kab = $this->input->get('id_kab');

        $q_kab = "SELECT kab.id_prov, prov.provinsi, kab.id_kab, kab.kabupaten
                              FROM kg_ref_kab kab
                                LEFT JOIN kg_ref_prov prov ON prov.id_prov = kab.id_prov
                                  WHERE kab.id_prov = {$id_prov}";

        $all_prov = $this->db->query($q_kab)->result_array();
        $opt = [];
        $opt[''] = '- Semua -';
        foreach ($all_prov as $prov) {
            $opt[$prov['id_kab']] = $prov['kabupaten'];
        }
        echo form_dropdown('id_kab', $opt, $id_kab, "class='form-control' required");
    }
}