<?php

App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

class GooglePlacesRequest {
	
	public $url;
	public $output = "json";
	public $parameters = array();

	public function send($url, $output, $parameters, $get, $urlSuffix) {
		$this->output = $output;
		if($get) {
			$this->parameters = $parameters;
		}
		$this->url = $this->buildRequest($url) . $urlSuffix;
		$easyCurlRequest = new EasyCurlRequest($this->url, $get ? EasyCurlRequestType::GET : EasyCurlRequestType::POST);
		if(!$get) {
			$this->buildPostParameters($easyCurlRequest, $parameters);
		}
		//debug($easyCurlRequest);
		$easyCurlRequest->AddHeader(new EasyCurlHeader('Content-Type', 'application/' . $this->output));
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

	private function buildPostParameters(&$request, $parameters) {
		foreach($parameters as $name => $value) {
			$request->AddPostParameter(new EasyCurlPostParameter($name, $value));
		}
	}
}

?>