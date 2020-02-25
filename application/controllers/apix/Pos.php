<?php

/**
 * Api for point of sales
 * 
 * @author Ridha Danjanny
 * @email ridhadanjanny.mail@gmail.com
 */
class Pos extends REST_Controller {
    
    /**
     * DB Client 'Satu Harga'
     * 
     * @var String
     */ 
    private $db_satuharga;
    
    /**
     * DB Connection Group 'Satu Harga'
     * Purpose : get ptmsolar_satuharga/satuharga_beli_pribadi
     * check application/database.php for further info
     * 
     * @var String
     */ 
    private $db_group_satuharga = 'satuharga';
    
    /**
     * Transaksi beli tbl
     * 
     * @var String
     */     
    // private $beli_tbl = 'satuharga_beli_pribadi';
    
    /**
     * DB Connection Group 'Biosolar / Ptmsolar'
     * Purpose : get ptmsolar_new/kg_bbm_satu_jarga
     * check application/database.php for further info
     * 
     * @var String
     */ 
    private $db_group_biosolar = 'production';
    
    /**
     * Stok satu harga
     * 
     * @var String
     */     
    private $stok_tbl = 'kg_bbm_satu_harga';
    
    
    /**
     * Tabel Beli
     * 
     * @var String
     */     
    private $beli_tbl = 'kg_beli_pribadi';
    
    /**
     * DB Client 'Biosolar'
     * 
     * @var String
     */ 
    private $db_biosolar;
    
    /**
     * Init db instance using db group 'satu harga', set timezone
     */ 
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); // set timezone to jakarta
        $this->db_satuharga = $this->load->database($this->db_group_satuharga, TRUE); // set db connection to satu harga, to get beli table
        $this->db_biosolar = $this->load->database($this->db_group_biosolar, TRUE); // set db connection to biosolar, to get user table
    }

    
    /**
     * Rekap data detail
     */ 
    public function rekap_detail_get() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        
        $mapQueryParam = $this->input->get(); // no_spbu, id_bbm, end_date, start_date
        $filteredResult = $this->getFilterQueryParam($mapQueryParam);
        
        // POS Query default with query param filter
        if($mapQueryParam != null) {
            $queryStmtRekapPos = "SELECT * FROM {$this->stok_tbl} {$filteredResult['filteredWhere']}";    
        } else {
            // without filter
            $queryStmtRekapPos = "SELECT id, no_spbu, id_bbm, stok_awal, terima, jual, stok_akhir, tgl, create_date FROM kg_bbm_satu_harga 
                        WHERE create_date IN (SELECT MAX(create_date) FROM kg_bbm_satu_harga GROUP BY no_spbu, id_bbm, tgl) 
                            ORDER BY create_date DESC LIMIT 0,10";            
        }
        
        // get result with filter or not
        $res = $this->db_biosolar->query($queryStmtRekapPos)->result_array();

        // get final result        
        $resultPerInputStok = [];
        $resultPos = [];         // list harga bbm * terima, list harga bbm * jual
        
        // list produk bbm dan harganya
		$listProdukBbm = [
		    ["id" => 1, "title" => "Premium", "harga" => 6450],
		    ["id" => 2, "title" => "Biosolar", "harga" => 5150],
		    ["id" => 3, "title" => "Pertalite", "harga" => 7650],
		    ["id" => 4, "title" => "Dexlite", "harga" => 9500],
		    ["id" => 5, "title" => "Pertamax", "harga" => 9200],
		    ["id" => 6, "title" => "Turbo", "harga" => 9900],		    
		    ["id" => 7, "title" => "Pertamina Dex", "harga" => 10200]
	    ];	    
		    
		// create result per input stok bbm    
        foreach($res as $row) {
            foreach($listProdukBbm as $produk) {
                if($row['id_bbm'] == $produk['id']) {
                    // result per input stok - all
                    $resultPerInputStok[] = [
                        'id' => $row['id'],
                        'produk' => $produk['title'],
                        'no_spbu' => $row['no_spbu'],
                        'stok_awal' => $row['stok_awal'],
                        'terima' => $row['terima'],
                        'jual' => $row['jual'],
                        'stok_akhir' => $row['stok_akhir'],
                        'total_terima' => $row['terima'] * $produk['harga'],
                        'total_jual' => $row['jual'] * $produk['harga'],                        
                        'tgl' => $row['tgl']
                        ];
                    break;
                }
            }
        }
        
        // output JSONString final result
        $this->response($resultPerInputStok);
    }
    
    /**
     * Rekap data by : id bbm (pilihan bbm), start date, end date
     * get data : 
     * 1. [table ptmsolar_new/satuharga] penerimaan (lt) * harga = total penerimaan (Rp)
     * 2. [table ptmsolar_new/satuharga] penjualan (lt) * harga = total penjualan (Rp)
     * 3. [table ptmsolar_satuharga] penjualan
     * 3. list penjualan - no pol, nilai transaksi, volume
     */ 
    public function rekap_get() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        
        $mapQueryParam = $this->input->get(); // no_spbu, id_bbm, end_date, start_date
        $filteredResult = $this->getFilterQueryParam($mapQueryParam);
        
        // POS Query default with query param filter
        if($mapQueryParam != null) {
            $queryStmtRekapPos = "SELECT * FROM {$this->stok_tbl} {$filteredResult['filteredWhere']}";    
        } else {
            // without filter
            $queryStmtRekapPos = "SELECT id, no_spbu, id_bbm, stok_awal, terima, jual, stok_akhir, tgl, create_date FROM kg_bbm_satu_harga 
                        WHERE create_date IN (SELECT MAX(create_date) FROM kg_bbm_satu_harga GROUP BY no_spbu, id_bbm, tgl) 
                            ORDER BY create_date DESC LIMIT 0,10";            
        }
        
        $res = $this->db_biosolar->query($queryStmtRekapPos)->result_array();
        
        $resultPerInputStok = [];
        $resultPos = [];         // list harga bbm * terima, list harga bbm * jual
        
        // list produk bbm dan harganya
		$listProdukBbm = [
		    ["id" => 1, "title" => "Premium", "harga" => 6450],
		    ["id" => 2, "title" => "Biosolar", "harga" => 5150],
		    ["id" => 3, "title" => "Pertalite", "harga" => 7650],
		    ["id" => 4, "title" => "Dexlite", "harga" => 9500],
		    ["id" => 5, "title" => "Pertamax", "harga" => 9200],
		    ["id" => 6, "title" => "Turbo", "harga" => 9900],		    
		    ["id" => 7, "title" => "Pertamina Dex", "harga" => 10200]
	    ];	    
		    
		// create result per input stok bbm    
        foreach($res as $row) {
            foreach($listProdukBbm as $produk) {
                if($row['id_bbm'] == $produk['id']) {
                    // result per input stok - all
                    $resultPerInputStok[] = [
                        'id' => $row['id'],
                        'produk' => $produk['title'],
                        'no_spbu' => $row['no_spbu'],
                        'stok_awal' => $row['stok_awal'],
                        'terima' => $row['terima'],
                        'jual' => $row['jual'],
                        'stok_akhir' => $row['stok_akhir'],
                        'total_terima' => $row['terima'] * $produk['harga'],
                        'total_jual' => $row['jual'] * $produk['harga'],                        
                        'tgl' => $row['tgl']
                        ];
                    break;
                }
            }
        }
        
        // create result rekap per produk
        $r = [];
        $dateAll = [];
        foreach($listProdukBbm as $produk) {
            $sum_terima = 0;
            $sum_jual = 0;
            foreach($resultPerInputStok as $stok) {
                if($produk['title'] == $stok['produk']) {
                    $sum_terima += $stok['total_terima']; // rekap terima (Rp)
                    $sum_jual += $stok['total_jual']; // rekap jual (Rp)
                    
                    // get 2 unique date : highest and lowest
                    $dateAll[] = $stok['tgl'];
                }
            }
            
            // $dateUnique = array_unique($dateAll);
            
            $r[] = [
                'id_produk' => $produk['id'],
                'produk' => $produk['title'],
                'sum_terima' => (String) $sum_terima,
                'sum_jual' => (String)  $sum_jual
                ];            
        }
        
        // get start date & end date
        $uniqueDate = array_unique($dateAll);
        usort($uniqueDate, function($a, $b) {
            $dateTimestamp1 = strtotime($a);
            $dateTimestamp2 = strtotime($b);
            return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
        });
        
        // result for consume
        $lastResult = [
            'start_date' => $uniqueDate[0], 
            'end_date' => $uniqueDate[count($uniqueDate) - 1],
            'pos_rekap_result' => $r
            // 'pos_input_stok' => $resultPerInputStok
            ];
            
        // var_dump($rrr);
        $this->response($lastResult);
    }
    
    private function getFilterQueryParam($queryParam) {
        $inner = "";
        $end_date_v = "";
        
        $inner .= " WHERE create_date IN (SELECT MAX(create_date) FROM kg_bbm_satu_harga GROUP BY no_spbu, id_bbm, tgl)";
        foreach($queryParam as $k => $v) {
            
            // no_spbu
            if($k == 'no_spbu') {
                $inner .= " AND {$k} = '{$v}' ";
            }

            // id_bbm
            if($k == 'id_bbm') {
                $inner .= " AND {$k} LIKE '%{$v}%' ";
            }

            // #1 end_date : cek end_date tersedia
            if($k == 'end_date') {
                $end_date_v = $v;
            }

            // #2 start_date
            if($k == 'start_date') {
                // end_date ditambahkan
                if($end_date_v != "") {
                    $inner .= " AND (tgl BETWEEN '{$v}' AND '{$end_date_v}')";

                    // start_date aja, end_date kosong
                } else {
                    $inner .= " AND tgl >= '{$v}'";
                }
            }
        }

        return [
            'filteredWhere' => $inner
        ];
    }

    public function list_produk_bbm_get() {
		$listProdukBbm = [
		    ["id" => 1, "title" => "Premium", "harga" => 6450],
		    ["id" => 2, "title" => "Biosolar", "harga" => 5150],
		    ["id" => 3, "title" => "Pertalite", "harga" => 7650],
		    ["id" => 4, "title" => "Dexlite", "harga" => 9500],
		    ["id" => 5, "title" => "Pertamax", "harga" => 9200],
		    ["id" => 6, "title" => "Turbo", "harga" => 9900],		    
		    ["id" => 7, "title" => "Pertamina Dex", "harga" => 10200]
	    ];
	    
	    $this->response($listProdukBbm);
    }    
    
    
    /*
     * Update Form Penjualan di Modul Stok App
     * Data penjualan menggunakan data di modul beli biosolar
     * 
     * @return JSONString
     */ 
    public function update_form_penjualan_get() {
        $noSpbu = $this->input->get('no_spbu');
        $pilihanBbmPosition = $this->input->get('pilihan_bbm_position');
        $tglIsi = $this->input->get('tgl_isi');
        
        $stmt = "SELECT SUM(rupiah) AS `total_jual` FROM {$this->beli_tbl} ";
        switch($pilihanBbmPosition) { // value berdasarkan posisi spinner
            case 2: // pilihan bbm di spinner nomor 2 : Biosolar / Solar
                $idBbm = 1;
                $stmt .= "WHERE app = 'biosolar' AND no_spbu = '{$noSpbu}' AND id_bbm = {$idBbm} AND tgl = '{$tglIsi}' ";
                break;
            default:
                $stmt = "";
        }
        
        $size = 0; // size of result array
        $result = []; // result
        if($q = $this->db_biosolar->query($stmt)) {
            $size = $q->num_rows(); // get size of row
            $result = $q->result_array()[0]; // get first element
        }
        
        // response
        $this->response([
            'position' => $pilihanBbmPosition, 
            'tgl_isi' => $tglIsi, 
            'stmt' => $stmt, 
            'size' => $size,
            'total_jual' => $result['total_jual'] != null ? $result['total_jual'] : 0 
            ]);
    }
    
    public function update_tgl_get() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);

    }
    
    public function ngetes_get() {
        $r = array_unique(["2020-01-01", "2020-01-01", "2020-01-01", "2020-01-02", "2020-01-02", "2020-01-02", "2020-01-03"]);
        var_dump($r);
    }
}













