<?php

App::uses('GooglePlacesResponse', 'GooglePlaces.Lib');
App::uses('GooglePlacesException', 'GooglePlaces.Lib');

class GooglePlacesRequest {
	
	public $url;
	public $output = "json";
	public $parameters = array();

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
		else { //TODO check why it's doesn't work with EasyCurl
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