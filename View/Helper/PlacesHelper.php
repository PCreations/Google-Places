<?php

class PlacesHelper extends AppHelper {
	
	public $helpers = array('Html', 'Js', 'Form');
	public $view;
	public $autocompleteInputs = array();

	protected $_settings = array(
		'key' => null
	);

	const PLACES_API_URL = "http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false";
	
	protected $_cityAutocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleCityAutocomplete',
		'plugin' => 'google_places'
	);

	protected $_establishmentAutocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleEstablishmentAutocomplete',
		'plugin' => 'google_places'
	);

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->view = $view;
		$this->_cityAutocompleteCallback = $this->url($this->_cityAutocompleteCallback);
		
	}

	public function autocomplete($countries, $options = array('type' => 'city'), $iso2 = "AD") {
		if(!isset($options['type']))
			return false;
		$type = $options['type'];
		$inputID = $type . '_autocomplete';
		$countriesInput = 'countries_autocomplete';
		$countryID = 'country_id_autocomplete';
		$placeID = "Localization.place_id";
		$classPlaceID = 'placeID';
		echo $this->Form->hidden($placeID, array('id' => $placeID, 'class' => $classPlaceID));
		echo $this->Form->hidden($countryID, array('id' => $countryID, 'value' => $iso2));
		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries, 'default' => $iso2));
		echo $this->Form->input($inputID, array('id' => $inputID));

		if($type == 'city')
			$this->autocompleteInputs[] = compact("inputID", "countriesInput", "iso2", "countryID", "placeID", "classPlaceID");
		else if($type == 'establishment')
			$this->establishmentAutocomplete(compact("inputID", "countriesInput", "iso2", "countryID", "placeID", "classPlaceID"));

		if($this->Form->isFieldError($placeID)) {
			echo $this->Form->error($placeID);
		}
	}

	public function establishmentAutocomplete($autocompleteInfos) {
		extract($autocompleteInfos);
		$this->Html->scriptStart(array('inline' => false));
		?>
			var input = $('#<?php echo $inputID;?>');
			input.autocomplete({
				minLength:2,
				source: function( request, response ) {
					var term = request.term;
					if ( term in cache ) {
						response( cache[ term ] );
						return;
					}

					lastXhr = $.getJSON( "<?php echo $this->_establishmentAutocompleteCallback; ?>", request, function( data, status, xhr ) {
						cache[ term ] = data;
						if ( xhr === lastXhr ) {
							response( data );
						}
					});
				},
			});
		<?php
		$this->Html->scriptEnd();
	}

	public function afterRender($viewFile) {
		$this->_autocompleteJavascript();
	}

	private function _autocompleteJavascript() {
		$this->Html->scriptStart(array('inline' => false));
		?>
			function addLatLng(place) {
				place.geometry.location.lat = place.geometry.location.lat();
				place.geometry.location.lng = place.geometry.location.lng();
				return place;
			}

			var inputs = <?php echo $this->Js->value($this->autocompleteInputs);?>;
			console.log(inputs);

			$.each(inputs, function(key, input) {
				console.log("input");
				console.log(input);
				var options = {
					types: ['(cities)'],
					componentRestrictions: {country: input['iso2']}
				};

				var inputField = document.getElementById(input['inputID']);

				autocomplete = new google.maps.places.Autocomplete(inputField, options);
				google.maps.event.addListener(autocomplete, 'place_changed', function() {
					var place = autocomplete.getPlace();
					console.log(place);
					place = addLatLng(place);
					console.log('.' + input['classPlaceID']);
					$('.' + input['classPlaceID']).val(place.id);
					$.post("<?php echo $this->_cityAutocompleteCallback;?>", {place: JSON.stringify(place)});
				});

				$('#' + input['countriesInput']).change(function() {
					var countryISO = $('#' + input['countriesInput'] + 'option:selected').val();
					$('#' + input['countryID']).val(countryISO);
					autocomplete.setComponentRestrictions({country: ''+countryISO+''});
				});
			});
			
		<?php
		$this->Html->scriptEnd();
	}

}

?>