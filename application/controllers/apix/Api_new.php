<?php

// ptmsolar.com/apix_mock/api_new
class Api_new extends CI_Controller {
    
    
    private $transaction_kendaraan = "kg_beli_pribadi";
    
    private $member_kendaraan = "kg_member_pribadi";
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }
    
    public function index() {
        echo 'masuk nyet!';
    }
    
    /**
     * User login
     * 
     * @return JSON String ["status", "message", "data"]
     */ 
    public function cek_login() {
	    $ins['no_pol'] = str_replace(" ","", $this->input->post('no_pol') );
	    $ins['no_hp'] = str_replace(" ","", $this->input->post('no_hp'));
	    
	    // cek if login input no_pol & no_hp is not empty / not null 
	    if($ins['no_pol'] && $ins['no_hp']) {

            // is user has registered ?
	        $userHasRegistered = $this->db->query("SELECT * FROM {$this->member_kendaraan} WHERE no_pol = '{$ins['no_pol']}' AND no_hp = '{$ins['no_hp']}' ")->num_rows();
	        if($userHasRegistered) {
	            
	            $dateNow = date('Y-m-d');
	           // $dateNow = "2020-01-11";
	           
       	        // cek sudah berapa kali pengisian dalam hari ini ?
	            $numOfFill = $this->db->query("SELECT * FROM {$this->transaction_kendaraan} WHERE no_pol = '{$ins['no_pol']}' AND tgl = '{$dateNow}' ")->num_rows();
	            
	            // cek total volume pengisian selama hari ini, apakah >= 100 liter
	            $totalVolumeFill = $this->db->query("SELECT SUM(liter) AS `total_volume` FROM {$this->transaction_kendaraan} WHERE no_pol = '{$ins['no_pol']}' AND tgl = '{$dateNow}' ")
	            ->row_array()['total_volume'];
	            
	            // Needs APPROVAL utk pengisian bbm >= 100 liter dalam sehari    
                if($totalVolumeFill >= 200) {
    
        	        $response = [ 
        	            "status" => "limit", 
        	            "message" => "Anda tidak bisa login karena telah melakukan transaksi 200 liter dalam sehari!"
        	            ];
        	            
        	       echo json_encode($response);
	            }  else {
	                // PASSED & OKAY!
                    $response = [
                        "status" => "ok", 
                        "message" => "Konsumen dapat melakukan transaksi!", 
        	            "data" => ["num_of_fill" => $numOfFill]
        	            ];
    	            echo json_encode($response);                
	            }
	            
	        } else {
	            // user has not registered
	            $response = ["status" => "error", "message" => "Mohon Maaf Customer belum terdaftar.\nSilakan daftar terlebih dahulu!"];
	            echo json_encode($response);
	        }
	    } else {
	        // login input has empty
            $response = ["status" => "error", "message" => "no polisi or no hp is null or is empty!"];
            echo json_encode($response);
	    }
    }
    
    
    /**
     * Filter / pembatasan pembelian bbm
     * 
     * @return JSON String ["status", "message", "question"]
     */ 
    public function cek_pembelian() {
	    $ins['id_bbm'] = $this->input->post('id_bbm');
	    $ins['no_pol'] = str_replace(" ","",$this->input->post('no_pol'));
	    $ins['liter'] = str_replace(",",".",$this->input->post('liter'));
	    $ins['odometer'] = str_replace(" ","",$this->input->post('odometer'));
	    $ins['numOfFill'] = $this->input->post('num_of_fill'); // frekuensi pengisian (berapa kali isi bensin dalam sehari?)
        $ins['numOfBuy'] = $ins['numOfFill'] + 1;
	    
	    // if odometer konsumen > 99999999
	    if($ins['odometer'] > 99999999) {
	        $response = [
	            "status" => "approval", 
	            "message" => "Mohon untuk melakukan approval reset odometer", 
	            "question" => "Apakah anda setuju melakukan reset odometer ?"
	            ];
            echo json_encode($response);
	    } else {
	        // filter pembatasan pembelian jika odometer masih < 99999999
	        $this->purchaseRestrictionsAwal($ins);
	    }
	    
    }
    
    
    /**
     * Filter / pembatasan saat transaksi di modul approval 
     * revisi 04/11 pak bayu - pembatasan > 200 liter
     * 
     * @return JSON String ["status", "message"]
     */ 
    public function cek_volume_approval() {
        $volume = $this->input->post('volume'); // volume pengisian (liter)
        $response = [];

        // transaksi approval dikenakan pembatasan pada pengisian > 200 liter
        if($volume > 200) {
            $response = ['status' => 'error', 'message' => "Customer tidak diizinkan mengisi lebih dari 200 liter.\n\nSilakan ubah volume pengisian atau log out!"];
        } else {
            $response = ['status' => 'ok', 'message' => 'Silakan melanjutkan ke detail transaksi pembelian!'];
        }
        
        echo json_encode($response);
    }
    
    
    /**
     * Filter / pembatasan pembelian bbm
     * 
     * @return JSON String ["status", "message", "question"]
     */ 
    public function cek_pembelian_approval() {
	    $ins['id_bbm'] = $this->input->post('id_bbm');
	    $ins['no_pol'] = str_replace(" ","",$this->input->post('no_pol'));
	    $ins['liter'] = str_replace(",",".",$this->input->post('liter'));
	    $ins['odometer'] = str_replace(" ","",$this->input->post('odometer'));
	    $ins['numOfFill'] = $this->input->post('num_of_fill'); // frekuensi pengisian (berapa kali isi bensin dalam sehari?)
        $ins['numOfBuy'] = $ins['numOfFill'] + 1;
	    
	    // if odometer konsumen > 99999999
	    if($ins['odometer'] > 99999999) {
	        $response = [
	            "status" => "approval", 
	            "message" => "Mohon untuk melakukan approval reset odometer", 
	            "question" => "Apakah anda setuju melakukan reset odometer ?"
	            ];
            echo json_encode($response);
	    } else {
	        // filter pembatasan pembelian jika odometer masih < 99999999
	        $this->purchaseRestrictionsApproval($ins);
	    }
	    
    }
    
    

    /**
     * Pembatasan pembelian awal (pertama kali), sebelum approval
     * 
     */ 
    private function purchaseRestrictionsAwal($ins) {
        
        $dateNow = date('Y-m-d'); // date now
        
        // cek total volume pengisian selama hari ini, apakah >= 100 liter
        $totalVolumeFill = $this->db->query("SELECT SUM(liter) AS `total_volume` FROM {$this->transaction_kendaraan} WHERE no_pol = '{$ins['no_pol']}' AND tgl = '{$dateNow}' ")
        ->row_array()['total_volume'];
        
        $lastTotalVolume = floatval($ins['liter']) + floatval($totalVolumeFill);
        
        if($lastTotalVolume > 200) {
	        $response = [
	            "status" => "error", 
	            "message" => "Customer tidak dapat mengisi lebih dari 200 liter ({$lastTotalVolume} liter) dalam satu hari yang sama"	            
	           // "message" => "Customer tidak dapat mengisi lebih dari 200 liter ({$lastTotalVolume} liter) dalam pembelian ke - {$ins['numOfBuy']}", 
	            ];
	        echo json_encode($response);
	        
        } else if(floatval($ins['liter']) > 75) {
	        
	        $response = [
	            "status" => "approval", 
	            "message" => "Customer ingin mengisi lebih dari 75 liter ({$ins['liter']} liter) dalam pembelian {$ins['numOfBuy']}", 
	            "question" => "Apakah anda setuju melakukan pengisian lebih dari 75 liter ({$ins['liter']} liter) ?"
	            ];
	        echo json_encode($response);
	        
        } else {
	        $response = [
	            "status" => "ok", 
	            "message" => "Customer ingin mengisi biosolar dengan volume {$ins['liter']} liter pada pembelian ke - {$ins['numOfBuy']}"
	            ];
	        echo json_encode($response);	            
        }        
    }
    
    /**
     * Pembatasan pembelian setelah approval
     * 
     */ 
    private function purchaseRestrictionsApproval($ins) {
        if($ins['liter'] > 100) {
	        $response = [
	            "status" => "error", 
	            "message" => "Customer tidak diizinkan mengisi lebih dari 100 lt ({$ins['liter']} lt).\n\nSilakan ubah volume!", 
	            ];
	        echo json_encode($response);	            
        } else {
	        $response = [
	            "status" => "ok", 
	            "message" => "Customer ingin mengisi biosolar dengan volume {$ins['liter']} liter pada pembelian ke - {$ins['numOfBuy']}"
	            ];
	        echo json_encode($response);	            
        }        
    }


    /**
     * Filter pembatasan pembelian
     * 
     * @return JSON String ["status", "message", "question"]
     */ 
    private function purchaseRestrictions($ins) {
	    // pembelian pertama
	    if($ins['numOfFill'] == 0) {
	        // filter > 75 lt
	        if($ins['liter'] > 75) {
    	        $response = [
    	            "status" => "approval", 
    	            "message" => "Customer ingin mengisi lebih dari 75 liter ({$ins['liter']} liter) dalam pembelian {$ins['numOfBuy']}", 
    	            "question" => "Apakah anda setuju melakukan pengisian lebih dari 75 liter ({$ins['liter']} liter) ?"
    	            ];
    	        echo json_encode($response);	            
	        } else {
    	        $response = [
    	            "status" => "ok", 
    	            "message" => "Customer ingin mengisi biosolar dengan volume {$ins['liter']} liter pada pembelian ke - {$ins['numOfBuy']}"
    	            ];
    	        echo json_encode($response);	            
	        }
	        
	        // pembelian kedua
	    } else if($ins['numOfFill'] == 1) {
	        // filter > 50 lt	        
	        if($ins['liter'] > 50) {
    	        $response = [
    	            "status" => "approval", 
    	            "message" => "Customer ingin mengisi lebih dari 50 liter ({$ins['liter']} liter) dalam pembelian ke - {$ins['numOfBuy']}", 
    	            "question" => "Apakah anda setuju melakukan pengisian lebih dari 50 liter ({$ins['liter']} liter) ?"
    	            ];
    	        echo json_encode($response);	            
	        } else {
    	        $response = [
    	            "status" => "ok", 
    	            "message" => "Customer ingin mengisi biosolar dengan volume {$ins['liter']} liter pada pembelian ke - {$ins['numOfBuy']}"
    	            ];
    	        echo json_encode($response);	            
	        }
	        
        // pembelian > 2 kali
	    } else {
	        // filter volume > 50 liter
	        if($ins['liter'] > 50) {
    	        $response = [
    	            "status" => "approval", 
    	            "message" => "Customer ingin mengisi lebih dari 2 kali ({$ins['numOfBuy']} kali) dengan volume lebih dari 50 liter ({$ins['liter']} liter)", 
    	            "question" => "Apakah anda setuju melakukan pengisian lebih dari 2 kali ({$ins['numOfBuy']} kali) dengan volume lebih dari 50 liter ({$ins['liter']} liter) ?"
    	            ];
    	        echo json_encode($response);	            
	        } else {
    	        $response = [
    	            "status" => "approval", 
    	            "message" => "Customer ingin mengisi lebih dari 2 kali ({$ins['numOfBuy']} kali)", 
    	            "question" => "Apakah anda setuju melakukan pengisian lebih dari 2 kali ({$ins['numOfBuy']} kali) di hari yg sama ?"
    	            ];
    	       echo json_encode($response);	            
	        }	        
	        
	    }
    }
    
    public function test() {
        $r = $this->db->query("SELECT SUM(liter) AS `total_volume` FROM kg_beli_pribadi WHERE no_pol = 'B6554PYL' AND tgl = '2020-02-19'")->row_array()['total_volume'];
        var_dump(floatval($r) + 50);
    }

    
}