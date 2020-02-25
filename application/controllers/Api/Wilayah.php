<?php

/**
 * Api wilayah
 * Provinsi, kabupaten / Kota
 */
class Wilayah extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function provinsi_get()
    {
        $q_stmt_prov = "SELECT * FROM kg_ref_prov";
        $this->response($this->db->query($q_stmt_prov)->result());
    }

    public function kabkot_get($id_prov) {
        $q_stmt_kab = "SELECT * FROM kg_ref_kab WHERE id_prov = '" . $id_prov . "' ";
        $this->response($this->db->query($q_stmt_kab)->result());
    }

}