<?php
/**
 * GooglePlaces Plugin
 * 
 * Licensed under Creative Commons BY-SA
 * Redistribution of files must retain the above copyright notice.
 *
 * @link	
 * @license CC BY-SA
 * @author Pierre Criulanscy
 */


/**
 * Handles the GooglePlacesRequest's response
 *
 * @package		GooglePlaces
 * @subpackage	GooglePlaces.Lib
 */
class GooglePlacesResponse {
	
/**
 * The response's data
 *
 * @var string
 */
	public $data = array();

/**
 * Constructor
 *
 * Set the current url and parse data from current output to array
 *
 * @param string $url The current request's url
 * @param string $data The current request's response
 * @param string $output The current output
 * @return array $data
 */
	public function __construct($url, $data, $output) {
		$this->url = $url;
		$this->data = $this->parseData($data, $output);
	}

/**
 * Parse data from json/xml to array
 *
 * @param string $data Data in json/xml
 * @param string $output Data format
 * @return array $data
 */	
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