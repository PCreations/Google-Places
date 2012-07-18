<?php

class GooglePlacesResponse {
	
	public $data = array();

	public function __construct($url, $data, $output) {
		$this->url = $url;
		$this->data = $this->parseData($data, $output);
	}

	private function parseData($data, $output) {
		switch($output) {
			case "json":
			default:
				$data = json_decode($data);
				return $data;
				break;
		}
	}

}

?>