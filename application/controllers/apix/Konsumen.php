<?php


/**
 * Api for Transaksi Konsumen, Login Konsumen, Register New Konsumen
 * 
 * @author Ridha Danjanny
 * @email ridhadanjanny.mail@gmail.com
 */
class Konsumen extends REST_Controller {
    
    /**
     * DB Client 'Satu Harga'
     * 
     * @var String
     */ 
    private $db_satuharga;
    
    /**
     * DB Client 'Biosolar'
     * 
     * @var String
     */ 
    private $db_biosolar;
    
    /**
     * DB Connection Group 'Satu Harga'
     * check application/database.php for further info
     * 
     * @var String
     */ 
    private $db_group_satuharga = 'apix';
    
    /**
     * DB Connection Group 'Biosolar / Ptmsolar'
     * check application/database.php for further info
     * 
     * @var String
     */ 
    private $db_group_biosolar = 'production';
    
    /**
     * Transaksi beli tbl
     * 
     * @var String
     */     
    private $beli_tbl = 'kg_beli_pribadi';
    
    /**
     * User tbl
     * 
     * @var String
     */     
    private $user_tbl = 'kg_member_pribadi';
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); // set timezone to jakarta
        $this->db_satuharga = $this->load->database($this->db_group_satuharga, TRUE); // set db connection to satu harga, to get beli table
        $this->db_biosolar = $this->load->database($this->db_group_biosolar, TRUE); // set db connection to biosolar, to get user table
    }
    
    /**
     * Login auth
     */ 
    public function login_post() {
       // pake ptmsolar.com/api/cek_login 
    }
    
    /**
     * Input transaksi pembelian
     */ 
    public function beli_post() {
        $ins['id_bbm'] = $_POST['id_bbm'];
        $ins['app'] = 'satuharga';        
		$ins['no_spbu'] = $_POST['no_spbu'];
		$ins['no_hp'] = $_POST['no_hp'];
	    $ins['no_pol'] = str_replace(" ","",$_POST['no_pol']);
	    $ins['liter'] = str_replace(",",".",$_POST['liter']);
	    $ins['odometer'] = str_replace(",",".",$_POST['odometer']);
	    $ins['rupiah'] = $_POST['rupiah'];
	    $ins['modify_date'] = date("Y-m-d H:i:s");
	   	$ins['create_date'] = date("Y-m-d H:i:s");
	   	$ins['tgl'] = date("Y-m-d");
	   	
	   	// insert data approval
	   	$ins['approval_name'] = $this->input->post('approval_name');
	   	
	    if($this->db_biosolar->insert($this->beli_tbl, $ins)) {
			echo "ok";
		} else {
		    echo "Pembelian Gagal";
		} 
    }
    
    
    /**
     * Fetch list harga all produk BBM
     * 
     * @return JSONArray
     */ 
    public function list_harga_bbm_get() {
		$listProdukBbm = [
		    ["id" => 1, "title" => "Premium", "harga" => 7650], // premium ?
		    ["id" => 2, "title" => "Biosolar", "harga" => 5150],
		    ["id" => 3, "title" => "Pertalite", "harga" => 7650],
		    ["id" => 4, "title" => "Dexlite", "harga" => 9500],
		    ["id" => 5, "title" => "Pertamax", "harga" => 9200],
		    ["id" => 6, "title" => "Turbo", "harga" => 9900],		    
		    ["id" => 7, "title" => "Pertamina Dex", "harga" => 10200]
	    ];
	    
	    $this->response($listProdukBbm);
    }
    
    /**
     * Histori pembelian - filter data pembelian
     * 1. Fetch 10 top last row
     * 2. Fetch by start date & end date & id bbm (jenis bbm)
     */ 
    public function history_get() {
        
    }
    
}