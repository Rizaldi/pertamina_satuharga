<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;
use Danjanny\Excel;

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
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
		$data['main'] = 'home'; // views/content.php
		$data['title'] = 'Pertamina - Satu Harga';
		// $data['template_key'] = 'partial_key'; 
		$this->load->view('template', $data);
	}

	public function ajax_store_datepicker_input_start() {

	  $date_start = (!empty($_POST['date_start']) ? $_POST['date_start'] : '');

      $datepicker_input = ['date_start' => $date_start];
      
      $this->session->set_userdata($datepicker_input);

	}

	public function ajax_store_datepicker_input_end() {

	  $date_end = (!empty($_POST['date_end']) ? $_POST['date_end'] : '');

      $datepicker_input = ['date_end' => $date_end];
      
      $this->session->set_userdata($datepicker_input);

	}	

	public function test_session() {
		var_dump([$this->session->userdata('date_start'), $this->session->userdata('date_end')]);
	}

	public function excel() {
	    ini_set("max_execution_time", -1);
		// get start date
        $datepicker_date_start = $this->session->userdata('date_start');
        // get end date
        $datepicker_date_end = $this->session->userdata('date_end');
        // query stmt
        $query_excel = "SELECT * FROM view_excel WHERE create_date BETWEEN '{$datepicker_date_start}' AND '{$datepicker_date_end}' ";
        // result array
        // var_dump($this->db->query($query_excel)->result_array() );
        $this->load->library('excellibrary');
        // $this->load->library('test');
        // $this->excellibrary->data_source($datepicker_date_start, $datepicker_date_end);
        $this->excellibrary->excel($datepicker_date_start, $datepicker_date_end);
	}

	public function export_excel() {
	    
	    ini_set('max_execution_time', 0); // execution time no limit

		// init client object
		$request_satuharga = new Client();
		$url = site_url() . 'Api/satuharga/transaction';

		// http request by url
		$response = $request_satuharga->request('GET', $url);
		// parse json to array
		$data_satuharga = json_decode($response->getBody(), true);

		// get start date
        $datepicker_date_start = $this->session->userdata('date_start');
        // get end date
        $datepicker_date_end = $this->session->userdata('date_end');

		$html = "<table border='1'>
			<thead>
				<tr>
					<th>Pilihan BBM</th>
					<th>No SPBU</th>
					<th>Stok Awal</th>
					<th>Terima</th>
					<th>Jual</th>
					<th>Stok Akhir</th>
					<th>Tanggal</th>
				</tr>
			</thead>";
		//<th>Loses</th>
					
		$html .= "<tbody>";

		foreach ($data_satuharga['data'] as $data) {
			if($data['tgl'] == $datepicker_date_start || $data['tgl'] == $datepicker_date_end) {
				$html .= "<tr>";
					$html .= "<td>{$data['pilihan_bbm']}</td>";
					$html .= "<td>{$data['no_spbu']}</td>";
					$html .= "<td>{$data['stok_awal']}</td>";
					$html .= "<td>{$data['terima']}</td>";
					$html .= "<td>{$data['jual']}</td>";
					$html .= "<td>{$data['stok_akhir']}</td>";
					//$html .= "<td>{$data['loses']}</td>";
					$html .= "<td>{$data['tgl']}</td>";
				$html .= "</tr>";
			}
		}

		$html .= "</tbody></table>";

		to_excel($html, "Satuharga_report_" . $datepicker_date_start . "_" . $datepicker_date_end);
		unset($_SESSION['date_start'], $_SESSION['date_end']);
		die();

	}
	
	public function getName() {
	    echo 'asd';
	}

}
