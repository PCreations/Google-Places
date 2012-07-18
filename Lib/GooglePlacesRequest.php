<?php

App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

class GooglePlacesRequest {
	
	public $url;
	public $output = "json";
	public $parameters = array();

	public function send($url, $output, $parameters) {
		$this->output = $output;
		$this->parameters = $parameters;
		$this->url = $this->buildRequest($url);
		$easyCurlRequest = new EasyCurlRequest($this->url, EasyCurlRequestType::GET);
		$easyCurlRequest->AddHeader(new EasyCurlHeader('Content-Type', 'application/' . $this->output));
		$easyCurlRequest->SetAutoReferer();
		try {
			$executionResult = $easyCurlRequest->Execute();
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