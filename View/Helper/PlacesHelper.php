<?php

class PlacesHelper extends AppHelper {
	
	public $helpers = array('Html', 'Js', 'Form');
	public $view;
	public $autocompleteInputs = array();
	public $defaultCountry;

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

	protected $_geocodeAutocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleGeocodeAutocomplete',
		'plugin' => 'google_places'
	);

	protected $_addPlaceCallback = array(
		'controller' => 'places',
		'action' => 'handleAddPlace',
		'plugin' => 'google_places'
	);

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->_settings = Set::merge($this->_settings, $settings);
		$this->view = $view;
		$this->_cityAutocompleteCallback = $this->url($this->_cityAutocompleteCallback);
		$this->_establishmentAutocompleteCallback = $this->url($this->_establishmentAutocompleteCallback);
		$this->_geocodeAutocompleteCallback = $this->url($this->_geocodeAutocompleteCallback);
		$this->_addPlaceCallback = $this->url($this->_addPlaceCallback);
		
	}

	public function autocompleteEstablishmentsInCity($countries, $iso2, $autocompleteInputOptions = array(), $localizationData = array()) {
		$this->defaultCountry = strtoupper($iso2);
		$countriesInput = 'countries_autocomplete';
		$establishmentAutocomplete = 'establishment_autocomplete';
		$establishmentID = 'Localization.establishment_id';
		$establishmentReference = 'Localization.establishment_reference';
		$classEstablishmentID = 'establishmentID';
		$classEstablishmentReference = 'establishmentReference';

		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries, 'default' => $this->defaultCountry));
		$this->_setAutocomplete(self::CITIES_SEARCH, $countriesInput, array('placeholder' => __('Establishment\'s city')));

		echo $this->Form->hidden($establishmentID, array('id' => $establishmentID, 'class' => $classEstablishmentID));
		echo $this->Form->hidden($establishmentReference, array('id' => $establishmentReference, 'class' => $classEstablishmentReference));
		echo $this->Form->input($establishmentAutocomplete, array(
			'class' => 'establishmentAutocomplete',
			'div' => array(
				'style' => 'display: none;',
				'class' => 'divEstablishment'
			)
		));
		$this->Html->scriptStart(array('inline' => false));
		?>
			gpInput.appendToPlaceChangedCallback(gpInput, function(){
				$('.divEstablishment').show();
				place = gpInput.autocomplete.getPlace();
				console.log("in establishment");
				console.log(place);

				var input = $('.establishmentAutocomplete');
				var cache = {},lastXhr;
				var inputVal;
				var cityName;
				input.autocomplete({
					minLength:2,
					source: function( request, response ) {
						$('#addPlace').remove();
						request.iso = $('.countryID').val();
						console.log("ISO = "+request.iso);
						request.cityName = place.name;
						cityName = place.name;
						request.lat = place.geometry.location.lat;
						request.lng = place.geometry.location.lng;
						inputVal = $('.establishmentAutocomplete').val();
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
						console.log('SELECT');
						console.log(ui);
						console.log(establishmentInfos);
						console.log(inputVal);
						if(establishmentInfos[0] == -1) {
							$('.divEstablishment').append('<div id="addPlace"></div>');
							console.log('countriesInput : <?php echo $countriesInput;?>\ncountryID : '+$('.countryID').val()+'\ncityName : '+cityName);
							$('#addPlace').load('<?php echo $this->_addPlaceCallback;?>', {countriesInput: '<?php echo $countriesInput;?>', country: $('.countryID').val(), cityName: cityName}, function() {
								$('.establishmentAutocomplete').val(inputVal);
							});
						}
						else {
							$('.<?php echo $classEstablishmentID;?>').val(establishmentInfos[0]);
							$('.<?php echo $classEstablishmentReference;?>').val(establishmentInfos[1]);
						}
					}
				});
			});
		<?php
		$this->Html->scriptEnd();
		if($this->Form->isFieldError($establishmentID)) {
			$this->Html->scriptStart(array('inline' => false));
			?>
				$('.divEstablishment').show();
			<?php
			$this->Html->scriptEnd();
			echo $this->Form->error($establishmentID);
		}
	}

	public function autocomplete($countries, $type = self::CITIES_SEARCH, $iso2 = "AD", $autocompleteInputOptions = array()) {
		$this->defaultCountry = $iso2;
		$countriesInput = 'countries_autocomplete';
		
		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries, 'default' => $iso2));
		$this->_setAutocomplete($type, $countriesInput, $autocompleteInputOptions);
	}

	/*
	* Basic function to find place just by country restictions.
	*/
	private function _setAutocomplete($type, $countriesInput, $autocompleteInputOptions, $defaultCountry = null, $printJS = false) {
		if($defaultCountry == null)
			$defaultCountry = $this->defaultCountry;
		$placeID = "Localization.place_id";
		$countryID = "Localization.country_id";
		$classCountryID = "countryID";
		$placeReference = "Localization.place_reference";
		$classPlaceID = 'placeID';
		$classPlaceReference = 'placeReference';
		$inputTemplate = ':type_autocomplete';
		$autocompleteInput = '';
		echo $this->Form->hidden($countryID, array('id' => $countryID, 'class' => $classCountryID, 'value' => $defaultCountry));
		echo $this->Form->hidden($placeID, array('id' => $placeID, 'class' => $classPlaceID));
		echo $this->Form->hidden($placeReference, array('id' => $placeReference, 'class' => $classPlaceReference));

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
		$this->Html->scriptStart(array('inline' => $printJS));
		?>
			var gpInput = new GooglePlacesAutocompleteInput(
				'<?php echo $autocompleteInput;?>', {
					types: ['<?php echo $type;?>'],
					componentRestrictions: {country: '<?php echo strtolower($defaultCountry);?>'}
				},
				'<?php echo $countriesInput;?>',
				'<?php echo $classCountryID;?>',
				function() {
					var place = this.place;
					$('.<?php echo $classPlaceID;?>').val(place.id);
					$('.<?php echo $classPlaceReference;?>').val(place.reference);
					$.post("<?php echo $this->_cityAutocompleteCallback;?>", {place: JSON.stringify(place)});
				}
			);
		<?php
		$jsBlock = $this->Html->scriptEnd();
		if($printJS)
			echo $jsBlock;
	}

	public function addPlace($countriesInput, $country, $cityName, $types) {
		echo $this->Form->input('Establishment.geocode', array('id' => 'geocode_autocomplete', 'placeholder' => 'Etablishment\'s address'));
		echo $this->Form->input('Establishment.types', array('id' => 'establishment_types', 'options' => $types));
		echo $this->Form->hidden('Localization.action', array('value' => 'place_report'));
		echo $this->Form->hidden('Geocode.latitude', array('id' => 'geocode_latitude'));
		echo $this->Form->hidden('Geocode.longitude', array('id' => 'geocode_longitude'));
		$this->Html->scriptStart(array('inline' => true));
		?>
			var input = $('#geocode_autocomplete');
			console.log("ADD PLACE");
			console.log(input);
			var cache = {},lastXhr;
			var inputVal;
			var cityName = '<?php echo $cityName;?>';
			var iso = '<?php echo $country;?>';
			input.autocomplete({
				minLength:2,
				source: function( request, response ) {
					request.iso = iso;
					console.log("ISO = "+request.iso);
					request.cityName = cityName;
					var term = request.term;
					if ( term in cache ) {
						response( cache[ term ] );
						return;
					}

					lastXhr = $.getJSON( "<?php echo $this->_geocodeAutocompleteCallback; ?>", request, function( data, status, xhr ) {
						cache[ term ] = data;
						if ( xhr === lastXhr ) {
							response( data );
						}
					});
				},
				select : function(event, ui){
					var geocodeInfos = ui.item.id.split('|'); //[0] => id, [1] => reference
					console.log('SELECT');
					console.log(ui);
					console.log(geocodeInfos);
					$.getJSON('<?php echo $this->url(array('controller' => 'places', 'action' => 'geocodeDetails', 'plugin' => 'google_places'));?>', {geocodeReference: geocodeInfos[1]}, function(json, status, xhr) {
						$('#geocode_latitude').val(json.geocodeDetails.geometry.location.lat);
						$('#geocode_longitude').val(json.geocodeDetails.geometry.location.lng);
					});
					
				}
			});
		<?php
		echo $this->Html->scriptEnd();
	}

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