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

App::uses('GooglePlacesAPI', 'GooglePlaces.Lib');

/**
 * This Behaviors is the link between models and GooglePlaceAPI. He makes your models acting as GooglePlacesAPI
 *
 * @package		GooglePlaces
 * @subpackage	GooglePlaces.Model.Behavior	
 */
class GooglePlacesAPIBehavior extends ModelBehavior {

/**
 * Instance of GooglePlacesAPI
 *
 * @var GooglePlacesAPI
 */
	public $gpAPI;

/**
 * Constructor
 *
 * Initialize GooglePlacesAPI instance with API Key defined in bootstrap
 */
	public function __construct() {
		parent::__construct();
		$this->gpAPI = new GooglePlacesAPI(Configure::read('GooglePlaces.key'));
	}

/**
 * Return GooglePlacesAPI instance
 */
	public function gpAPI() {
		return $this->gpAPI;
	}

}
?>