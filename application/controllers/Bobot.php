<?php

class Bobot extends CI_Controller {

	private $db_sh;

	public function __construct() {
		parent::__construct();
		$this->db_sh = $this->load->database('satuharga', true);
	}

	public function index() {
		// show progress name
		$data['bobot_progress_name'] = $this->db_sh->query("SELECT id, progress_name FROM sh_spbu_bobot GROUP BY progress_name 
			ORDER BY id")->result_array();
		// show sub progress name
		$data['bobots'] = $this->db_sh->query("SELECT * FROM sh_spbu_bobot")->result_array();
		$total_progress = $this->db_sh->query("SELECT SUM(last_progress) AS `total_progress` FROM `sh_spbu_progress`")->result_array()[0]['total_progress'];

		$data['total_progress'] = floor($total_progress) * 100;
		$this->load->view('satu_harga/header');
		$this->load->view('satu_harga/content', $data);
		$this->load->view('satu_harga/footer');
	}


	/**
	 * Update progress when user click form
	 * @return [type] [description]
	 */
	public function update_progress() {
		$progressParam = $this->input->post();
		$id_bobot = $progressParam['id']; // id bobot
		$result = [];
		$bobotInfo = $this->db_sh->query("SELECT * FROM sh_spbu_bobot WHERE id = {$id_bobot} ")->result_array()[0];
		if($progressParam['state'] == 'checked') {
			// get bobot
			$ins = [
				'no_spbu' => '31.10702',
				'id_info_spbu' => '31.10702',
				'id_bobot_spbu' => $id_bobot,
				'last_progress' => $bobotInfo['bobot']
			];

			if($this->db_sh->insert('sh_spbu_progress', $ins)) {
				$result = [
					'status' => 'ok',
					'progress_name' => $bobotInfo['progress_name'],
					'sub_progress_name' => $bobotInfo['sub_progress_name'],
					'id_bobot' => $id_bobot
				];
			}

		} else if($progressParam['state'] == 'unchecked') {
			// delete row id
			if($this->db_sh->delete('sh_spbu_progress', ['id_bobot_spbu' => $id_bobot] )) {
				$result = [
					'status' => 'ok',
					'message' => 'Id bobot ' . $id_bobot . ' sukses dihapus!',
					'progress_name' => $bobotInfo['progress_name'],
					'sub_progress_name' => $bobotInfo['sub_progress_name']					
				];
			}
		}

		if(!empty($result)){
			$total_progress = $this->db_sh->query("SELECT SUM(last_progress) AS `last_progress` FROM `sh_spbu_progress`")->result_array()[0]['last_progress'];
			$result['total_progress'] = $total_progress;
			echo json_encode($result);
		}
	}


	public function load_progress() {
		$idBobotSpbuResult['data'] = $this->db_sh->query("SELECT id_bobot_spbu FROM `sh_spbu_progress` ORDER BY `id` ASC")->result_array();
		// $idBobotSpbuResult['progress_name_once'] = $this->db_sh->query("SELECT DISTINCT progress_name FROM `sh_spbu_bobot` WHERE sub_progress_name IS NOT NULL ORDER BY `id` ASC")->result_array();
		$idBobotSpbuResult['progress_name_once'] = $this->db_sh->query("SELECT id, progress_name FROM `sh_spbu_bobot` WHERE sub_progress_name IS NOT NULL GROUP BY progress_name ORDER BY `id` ASC")->result_array();
		echo json_encode($idBobotSpbuResult);
	}

}