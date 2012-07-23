<?php

class GooglePlacesJSHelper extends AppHelper {
	
	public $helper = array('Js');

	private $_jsBuffer = '';
	
	public function __construct(View $view, $settings = array()) {
		parent::construct(View $view, $settings = array());
	}
}

?>