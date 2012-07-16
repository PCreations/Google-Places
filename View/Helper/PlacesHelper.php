<?php

class PlacesHelper extends AppHelper {
	
	public $helpers = array('Html', 'Js', 'Form');

	protected $_settings = array(
		'key' => null
	);

	const PLACES_API_URL = "http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false";
	
	protected $_autocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleAutocomplete',
		'plugin' => 'google_places'
	);

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
	}

	public function autocomplete($iso2) {
		static $autocompleteInputsID = 0;
		$autocompleteInputsID++;
		$inputID = 'city_autocomplete_' . $autocompleteInputsID;
		echo $this->Form->input($inputID, array('id' => $inputID));
		$autocompleteCallback = $this->Html->url($this->_autocompleteCallback);
		$this->Html->scriptStart(array('inline' => false));
		?>
			/*var defaultBounds = new google.maps.LatLngBounds(
				new google.maps.LatLng()
			);*/

			var input = document.getElementById('<?php echo $inputID;?>');
			var options = {
				types: ['(cities)'],
				componentRestrictions: {country: 'FR'}
			}

			autocomplete = new google.maps.places.Autocomplete(input, options);
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				var place = autocomplete.getPlace();
				console.log(place);
				$.post("<?php echo $autocompleteCallback;?>", {place: JSON.stringify(place)});
			});
		<?php
		$this->Html->scriptEnd();
	}

}

?>