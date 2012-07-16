<?php

class GooglePlacesResponse {
	
	public $data = array();

	public function __construct($data, $output) {
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