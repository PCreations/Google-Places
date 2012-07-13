<?php

class PlacesHelper extends AppHelper {
	
	public $helpers = array('Html', 'Js');

	protected $_settings = array(
		'key' => null
	);

	const PLACES_API_URL = "http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false";
	
	protected $_getPlaceCallback = array(
		'controller' => 'places',
		'action' => 'getPlace',
		'plugin' => 'Places'
	);

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
	}

	public function autocomplete($inputID, $latitude, $longitude, $iso2) {
		$getPlaceCallback = $this->Html->url($this->_getPlaceCallback);
		debug($getPlaceCallback);
		$this->Html->scriptStart(array('inline' => false));
		?>
			var defaultBounds = new google.maps.LatLngBounds(
				new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>)
			);

			var input = document.getElementById('<?php echo $inputID;?>');
			var options = {
				types: ['(cities)'],
				componentRestrictions: {country: 'FR'}
			}

			autocomplete = new google.maps.places.Autocomplete(input, options);
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				var place = autocomplete.getPlace();
				console.log(place);
				$.post("<?php echo $getPlaceCallback;?>", {place: serialize(place)});
			});
		<?php
		$this->Html->scriptEnd();
	}

}

?>