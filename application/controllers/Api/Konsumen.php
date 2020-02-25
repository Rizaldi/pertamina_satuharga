<?php

class TransaksiKonsumen extends REST_Controller {
    
    private $db_satuharga;
    private $tbl_test = 'test';
    private $db_group = 'apix';
    
    public function __construct() {
        date_default_timezone_set('Asia/Jakarta');
        $this->db_satuharga = $this->load->database($this->db_group, TRUE);
    }
    
    public function test_get() {
        echo 'asd';
        // $res = $this->db_group->query("SELECT * FROM {$this->tbl_test}")->result_array();
        // var_dump($res);
    }
}