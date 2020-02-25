<?php

use GuzzleHttp\Client;

class Mobile extends CI_Controller {

	private $client;

	public function __construct() {
		$this->client = new Client();
	}

	public function index() {
		$res = $this->client->request('GET', 'http://stokbbmsatuharga.com/Api/satuharga/excel');
		var_dump($res);
	}
}