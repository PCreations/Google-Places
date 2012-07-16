<?php

$config = array(
	'key' => 'AIzaSyAir6DKOMRfmXyHgXGHgHSg_FovG7yuMYY'
);

Configure::write('GooglePlaces', $config);
App::build(array('EasyCurl' => array(App::pluginPath('GooglePlaces') . DS . 'Vendor' . DS . 'EasyCurl')));
App::uses('EasyCurlCookieHelper', 'GooglePlaces.Vendor/EasyCurl');
App::uses('EasyCurlExceptions', 'GooglePlaces.Vendor/EasyCurl');
App::uses('EasyCurlExecuter', 'GooglePlaces.Vendor/EasyCurl');
App::uses('EasyCurlRequest', 'GooglePlaces.Vendor/EasyCurl');
App::uses('EasyCurlResponse', 'GooglePlaces.Vendor/EasyCurl');
App::import('GooglePlaces.Vendor/EasyCurl', 'EasyCurlHelperClasses', array('file' => 'EasyCurlHelperClasses.php'));
?>