<?php

class PlacesHelper extends AppHelper {
	
	public $helpers = array('Html', 'Js', 'Form');
	public $view;
	public $autocompleteInputs = array();

	protected $_settings = array(
		'key' => null,
	);

	const CITIES_SEARCH = '(cities)';
	const ESTABLISHMENT_SEARCH = 'establishment';
	const ADDRESS_SEARCH = 'geocode';
	const REGIONS_SEARCH = '(regions)';

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

	protected $_addPlaceAutocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleAddPlaceAutocomplete',
		'plugin' => 'google_places'
	);

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->_settings = Set::merge($this->_settings, $settings);
		$this->view = $view;
		$this->_cityAutocompleteCallback = $this->url($this->_cityAutocompleteCallback);
		$this->_establishmentAutocompleteCallback = $this->url($this->_establishmentAutocompleteCallback);
		$this->_addPlaceAutocompleteCallback = $this->url($this->_addPlaceAutocompleteCallback);
		
	}

	public function autocomplete($countries, $type = self::CITIES_SEARCH, $iso2 = "AD", $autocompleteInputOptions = array()) {
		$inputID = $type . '_autocomplete';
		$countriesInput = 'countries_autocomplete';
		$countryID = 'country_id_autocomplete';
		$placeID = "Localization.place_id";
		$placeReference = "Localization.place_reference";
		$classPlaceID = 'placeID';
		$classPlaceReference = 'placeReference';
		$establishmentAutocomplete = 'establishment_autocomplete';
		$establishmentID = 'Localization.establishment_id';
		$establishmentReference = 'Localization.establishment_reference';
		$classEstablishmentID = 'establishmentID';
		$classEstablishmentReference = 'establishmentReference';
		
		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries, 'default' => $iso2));
		$this->_setAutocomplete($type, $countriesInput, $autocompleteInputOptions);
		/*echo $this->Form->hidden($placeID, array('id' => $placeID, 'class' => $classPlaceID));
		echo $this->Form->hidden($placeReference, array('id' => $placeReference, 'class' => $classPlaceReference));
		echo $this->Form->hidden($countryID, array('id' => $countryID, 'value' => $iso2));
		
		echo $this->Form->input($inputID, array('id' => $inputID));
		
		if($type == 'establishment') {
			echo $this->Form->hidden($establishmentID, array('id' => $establishmentID, 'class' => $classEstablishmentID));
			echo $this->Form->hidden($establishmentReference, array('id' => $establishmentReference, 'class' => $classEstablishmentReference));
			echo $this->Form->input($establishmentAutocomplete, array(
				'class' => 'establishmentAutocomplete',
				'div' => array(
					'style' => 'display: none;',
					'class' => 'divEstablishment'
				)
			));
		}

		if($type == 'geocode') {
			echo $this->Form->input('placeGeocode', array(
				'id' => 'placeGeocode',
				'div' => array(
					'style' => 'display: none;',
					'class' => 'divAddPlace'
				)
			));
		}

		echo $this->Form->input('autoTest', array('id' => 'autoTest'));
		$this->Html->scriptStart(array('inline' => false));
		?>
			var gpInput = new GooglePlacesAutocompleteInput(
				'city_autocomplete', {
					types: ['(cities)'],
					componentRestrictions: {
						country: 'fr'
					}
				},
				'countries_autocomplete',
				function() {
					console.log(this.place);
				}
			);
			
			console.log(gpInput.placeChangedCallback);
		<?php
		$this->Html->scriptEnd();
		$this->autocompleteInputs[] = compact("inputID", "countriesInput", "iso2", "countryID", "placeID", "placeReference", "classPlaceID", "classPlaceReference");
		$this->_autocompleteJavascript();

		if($type == 'establishment')
			$this->establishmentAutocomplete(compact("countriesInput", "countryID", "establishmentID", "establishmentReference", "classEstablishmentID", "classEstablishmentReference"));
		if($type == 'geocode') {
			$this->addPlaceAutocomplete($countryID);
		}
		if($this->Form->isFieldError($placeID)) {
			echo $this->Form->error($placeID);
		}*/
	}

	private function _setAutocomplete($type, $countriesInput, $autocompleteInputOptions) {
		$inputTemplate = ':type_autocomplete';
		$autocompleteInput = '';
		switch($type) {
			case self::CITIES_SEARCH:
				$autocompleteInput = String::insert($inputTemplate, array('type' => 'cities'));
				break;
			case self::REGIONS_SEARCH:
				$autocompleteInput = String::insert($inputTemplate, array('type' => 'regions'));
				break;
			case self::ESTABLISHMENT_SEARCH:
			case self::ADDRESS_SEARCH:
				$autocompleteInput = String::insert($inputTemplate, array('type' => $type));
				break;

		}
		$autocompleteInputOptions = Set::merge($autocompleteInputOptions, array('id' => $autocompleteInput));
		echo $this->Form->input($autocompleteInput, $autocompleteInputOptions);
		$this->Html->scriptStart(array('inline' => false));
		?>
			var gpInput = new GooglePlacesAutocompleteInput(
				'<?php echo $autocompleteInput;?>', {
					types: ['<?php echo $type;?>'],
					componentRestrictions: {country: 'fr'} //TODO changer pour la locale
				},
				'<?php echo $countriesInput;?>',
				function() {
					console.log(this.place);
				}
			);
		<?php
		$this->Html->scriptEnd();
	}

	public function establishmentAutocomplete($inputs) {
		extract($inputs);

		$this->Html->scriptStart(array('inline' => false));
		?>
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				$('.divEstablishment').show();
				place = autocomplete.getPlace();
				console.log("in establishment");
				console.log(place);

				var input = $('.establishmentAutocomplete');
				var cache = {},lastXhr;
				input.autocomplete({
					minLength:2,
					source: function( request, response ) {
						request.iso = $('#<?php echo $countryID;?>').val();
						console.log("ISO = "+request.iso);
						request.cityName = place.name;
						request.lat = place.geometry.location.lat;
						request.lng = place.geometry.location.lng;
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
					select : function(event, ui){
						var establishmentInfos = ui.item.id.split('|'); //[0] => id, [1] => reference
						$('.<?php echo $classEstablishmentID;?>').val(establishmentInfos[0]);
						$('.<?php echo $classEstablishmentReference;?>').val(establishmentInfos[1]);
					}
				});
			});
		<?php
		$this->Html->scriptEnd();
	}

	public function addPlaceAutocomplete($countryID) {
		$this->Html->scriptStart(array('inline' => false));
		?>
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				$('.divAddPlace').show();	
				place = autocomplete.getPlace();
				console.log("in addPlace");
				console.log(place);

				var input = $('#placeGeocode');
				var cache = {},lastXhr;
				input.autocomplete({
					minLength:2,
					source: function( request, response ) {
						request.iso = $('#<?php echo $countryID;?>').val();
						console.log("ISO = "+request.iso);
						request.cityName = place.name;
						request.lat = place.geometry.location.lat;
						request.lng = place.geometry.location.lng;
						var term = request.term;
						if ( term in cache ) {
							response( cache[ term ] );
							return;
						}

						lastXhr = $.getJSON( "<?php echo $this->_addPlaceAutocompleteCallback; ?>", request, function( data, status, xhr ) {
							cache[ term ] = data;
							if ( xhr === lastXhr ) {
								response( data );
							}
						});
					},
					select : function(event, ui){
						var addPlaceInfos = ui.item.id.split('|'); //[0] => id, [1] => reference
						
						console.log(addPlaceInfos);
					}
				});
			});
		<?php
		$this->Html->scriptEnd();

	}

	/*public function afterRender($viewFile) {
		$this->_autocompleteJavascript();
	}*/

	private function _autocompleteJavascript() {
		$this->Html->scriptStart(array('inline' => false));
		?>
			

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
					$('.' + input['classPlaceID']).val(place.id);
					$('.' + input['classPlaceReference']).val(place.reference);
					$.post("<?php echo $this->_cityAutocompleteCallback;?>", {place: JSON.stringify(place)});
				});

				$('#' + input['countriesInput']).change(function() {
					var countryISO = $('#' + input['countriesInput'] + ' option:selected').val();
					console.log('CountryISO = '+countryISO);
					$('#' + input['countryID']).val(countryISO);
					autocomplete.setComponentRestrictions({country: ''+countryISO+''});
				});
			});
			
		<?php
		$this->Html->scriptEnd();
	}

}

?>