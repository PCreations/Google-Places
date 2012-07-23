<?php

class GooglePlacesJSHelper extends AppHelper {
	
	public $helper = array('Html', 'Js', 'Form');

	private $_jsBuffer = '';
	
	public function __construct(View $view, $settings = array()) {
		parent::construct(View $view, $settings = array());
	}

	public function addCityAutocomplete($countryField, $autocompleteInputOptions = array()) {
		echo $this->Form->input()
	}
}

?>