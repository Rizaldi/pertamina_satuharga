<?php

namespace Danjanny;
use GuzzleHttp\Client;

class Mobile extends CI_Controller {

	private $client;

	public function __construct() {
		$this->client = new Client();
	}

	public function index() {
		echo 'Hello ridha';
	}
}