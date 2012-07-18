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
		$this->_autocompleteCallback = $this->Html->url($this->_autocompleteCallback);
		
	}

	public function autocomplete($alias, $countries, $iso2 = "AD") {
		$inputID = 'city_autocomplete_' . $alias;
		$countriesInput = 'countries_autocomplete_' . $alias;
		$countryID = 'country_id_autocomplete_' . $alias;
		$placeID = "Localization.$alias.place_id";
		echo $this->Form->hidden($placeID, array('id' => $placeID, 'class' => 'placeID_' . $alias));
		echo $this->Form->hidden($countryID, array('id' => $countryID, 'value' => $iso2));
		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries, 'default' => $iso2));
		echo $this->Form->input($inputID, array('id' => $inputID));
		debug($this->Form->isFieldError($inputID));
		if($this->Form->isFieldError($placeID)) {
			echo $this->Form->error($placeID);
		}
		
		$this->_autocompleteJavascript($countriesInput, $countryID, $iso2, $inputID, 'placeID_' . $alias);
	}

	private function _autocompleteJavascript($countriesInput, $countryID, $iso2, $inputID, $placeIDClass) {
		$this->Html->scriptStart(array('inline' => false));
		?>
			function addLatLng(place) {
				place.geometry.location.lat = place.geometry.location.lat();
				place.geometry.location.lng = place.geometry.location.lng();
				return place;
			}

			var options = {
				types: ['(cities)'],
				componentRestrictions: {country: '<?php echo $iso2;?>'}
			}

			/*var defaultBounds = new google.maps.LatLngBounds(
				new google.maps.LatLng()
			);*/

			var input = document.getElementById('<?php echo $inputID;?>');

			autocomplete = new google.maps.places.Autocomplete(input, options);
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				var place = autocomplete.getPlace();
				console.log(place);
				place = addLatLng(place);
				$('.<?php echo $placeIDClass;?>').val(place.id);
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