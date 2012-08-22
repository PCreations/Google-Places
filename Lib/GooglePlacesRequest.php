<?php
/**
 * LiveShotBOX : Broadcast Live Music (http://lsbox.com)
 * 
 * Licensed under Creative Commons BY-SA
 * Redistribution of files must retain the above copyright notice.
 *
 * @link	http://lsbox.com
 * @license CC BY-SA
 * @author Pierre Criulanscy
 */

App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

/**
 * Handles sending requests to google places API
 *
 * @package		GooglePlaces
 * @subpackage	GooglePlaces.Lib
 */
class GooglePlacesRequest {

/**
 * Current request's url
 *
 * @var string
 */
	public $url;

/**
 * Output for request
 *
 * @var string
 */
	public $output = "json";
	
/**
 * Request's parameters
 *
 * @var array
 */
	public $parameters = array();

/**
 * Sends a request with EasyCurlHeader for GET request and with cURL for POST ones (have to fixed that)
 *
 * @param string $url The request's url
 * @param string $output The request's output (json/xml)
 * @param array $parameters The request's parameters (json/xml)
 * @param boolean $get If set to true the request will be GET request
 * @param string $urlSuffix Additionnal things to append to url
 * @return GooglePlacesResponse $response The request's response
 * @see GooglePlacesResponse::__construct()
 * @todo Fix the bug with EasyCurl for POST request
 */
	public function send($url, $output, $parameters, $get, $urlSuffix) {
		if($get) {
			$this->output = $output;
			$this->parameters = $parameters;
			$this->url = $this->buildRequest($url) . $urlSuffix;
			$easyCurlRequest = new EasyCurlRequest($this->url, EasyCurlRequestType::GET);
			//debug($easyCurlRequest);
			$easyCurlRequest->AddHeader(new EasyCurlHeader('Content-Type', 'application/' . $this->output));
			$easyCurlRequest->SetCurlOption(CURLINFO_HEADER_OUT, true);
			$easyCurlRequest->SetAutoReferer();
			/*var_dump($this->url);
			var_dump($get);
			var_dump($urlSuffix);*/
			try {
				$executionResult = $easyCurlRequest->Execute();
				//debug($executionResult);
				if($executionResult instanceof EasyCurlResponse) {
					return new GooglePlacesResponse($this->url, $executionResult->ResposeBody, $this->output);
				}
				else if ($executionResult instanceof EasyCurlError)
				{
				    throw new GooglePlacesException(array(
				    	$this->url,
				    	$executionResult->ErrorNumber,
				    	$executionResult->ErrorMessage,
				    	$executionResult->ErrorShortDescription
			    	));
				}
			}
			catch(GooglePlacesException $e) {
				die($e->getMessage());
			}
		}
		else {
			$data_string = json_encode($parameters);
			$this->url = $this->buildRequest($url) . $urlSuffix;
			$curl = curl_init($this->url);
			curl_setopt($curl, CURLOPT_POST, TRUE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			var_dump($data_string);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			    'Content-type: application/json')
			);
			curl_setopt($curl, CURLOPT_AUTOREFERER, true);

			$data = curl_exec($curl);
			curl_close($curl);
			return new GooglePlacesResponse($this->url, $data, $this->output);
		}
	}

/**
 * Builds request by merging output and parameters
 *
 * @param string $url The request's url
 * @return string $url The merged request's url
 */
	private function buildRequest($url) {
		$url .= "{$this->output}?";
		foreach($this->parameters as $name => $value) {
			if($value === false)
				$value = "false";
			else if($value === true)
				$value = "true";
			$url .= "$name=$value&";
		}
		return rtrim($url, '&');
	}
}

?>