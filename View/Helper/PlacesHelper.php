<?php

class PlacesHelper extends AppHelper {
	
	public $helpers = array('Html', 'Js', 'Form');
	public $view;

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
		$this->view = $view;
	}

	public function autocomplete($iso2, $countries) {
		static $autocompleteInputsID = 0;
		$autocompleteInputsID++;
		$inputID = 'city_autocomplete_' . $autocompleteInputsID;
		$countriesInput = 'countries_autocomplete_' . $autocompleteInputsID;
		$countryID = 'country_id_autocomplete_' . $autocompleteInputsID;
		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries));
		echo $this->Form->input($inputID, array('id' => $inputID));
		echo $this->Form->hidden($countryID, array('id' => $countryID, 'value' => 'AD'));
		$this->_autocompleteJavascript($countriesInput, $countryID, $inputID);
	}

	private function _autocompleteJavascript($countriesInput, $countryID, $inputID) {
		$this->Html->scriptStart(array('inline' => false));
		?>
			var options = {
				types: ['(cities)'],
				componentRestrictions: {country: 'AD'}
			}

			/*var defaultBounds = new google.maps.LatLngBounds(
				new google.maps.LatLng()
			);*/

			var input = document.getElementById('<?php echo $inputID;?>');

			autocomplete = new google.maps.places.Autocomplete(input, options);
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				var place = autocomplete.getPlace();
				console.log(place);
				$.post("<?php echo $this->_autocompleteCallback;?>", {place: JSON.stringify(place)});
			});

			$('#<?php echo $countriesInput;?>').change(function() {
				var countryISO = $('#<?php echo $countriesInput;?> option:selected').val();
				$('#<?php echo $countryID;?>').val(countryISO);
				autocomplete.setComponentRestrictions({country: ''+countryISO+''});
			});
		<?php
		$this->Html->scriptEnd();
	}

}

?>