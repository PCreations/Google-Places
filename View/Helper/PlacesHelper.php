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

App::uses('AppHelper', 'View/Helper');

 /**
  * Places Helper handles javascript autocomplete (cities and establishments) and place report and one line localization (place, city, country)
  *
  * @package	GooglePlaces
  * @subpackage	GooglePlaces.View.Helper
  * @todo : Nettoyer le Helper en supprimant la redondance de code en passant par une autocompletion full cURL et pas javascript. Prendre en charge correctement la validation (les messages d'erreurs ne sont pas affichés lors de l'édition) et gérer l'édition d'un lieu générique (juste geocode/establishment/city...)
  */

class PlacesHelper extends AppHelper {

/**
 * Array of helpers
 *
 * @var array
 */
	public $helpers = array('Html', 'Js', 'Form');

/**
 * Current view
 *
 * @var View
 */
	public $view;

/**
 * Default country to select in countries' list (alpha-2 ISO 3166-1)
 *
 * @var string
 */
	public $defaultCountry;

/**
 * Array of settings
 *
 * @var array
 */
	protected $_settings = array();

/**
 * Google component restrictions to cities search
 *
 * @constant CITIES_SEARCH
 */
	const CITIES_SEARCH = '(cities)';

/**
 * Google label for establishment search
 *
 * @constant ESTABLISHMENT_SEARCH
 */
	const ESTABLISHMENT_SEARCH = 'establishment';

/**
 * Google label for address search (geocode)
 *
 * @constant ADDRESS_SEARCH
 */
	const ADDRESS_SEARCH = 'geocode';

/**
 * Google component restrictions to regions search
 *
 * @constant REGIONS_SEARCH
 */
	const REGIONS_SEARCH = '(regions)';

/**
 * Google places API url
 *
 * @constant PLACES_API_URL
 */
	const PLACES_API_URL = "http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false";

/**
 * Callback url informations to handle city autocomplete
 *
 * @var array
 */
	protected $_cityAutocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleCityAutocomplete',
		'plugin' => 'google_places'
	);

/**
 * Callback url informations to handle establishment autocomplete
 *
 * @var array
 */
	protected $_establishmentAutocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleEstablishmentAutocomplete',
		'plugin' => 'google_places'
	);

/**
 * Callback url informations to handle geocode autocomplete
 *
 * @var array
 */
	protected $_geocodeAutocompleteCallback = array(
		'controller' => 'places',
		'action' => 'handleGeocodeAutocomplete',
		'plugin' => 'google_places'
	);

/**
 * Callback url informations to handle place report
 *
 * @var array
 */
	protected $_addPlaceCallback = array(
		'controller' => 'places',
		'action' => 'handleAddPlace',
		'plugin' => 'google_places'
	);

/**
 * Constructor. Set the current view and set callback urls
 *
 * @param View $view The current view
 * @param array $settings Optionnal settings
 */
	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->_settings = Hash::merge($this->_settings, $settings);
		$this->view = $view;
		$this->_cityAutocompleteCallback = $this->url($this->_cityAutocompleteCallback);
		$this->_establishmentAutocompleteCallback = $this->url($this->_establishmentAutocompleteCallback);
		$this->_geocodeAutocompleteCallback = $this->url($this->_geocodeAutocompleteCallback);
		$this->_addPlaceCallback = $this->url($this->_addPlaceCallback);
		
	}

/**
 * This function handles the establishment autocomplete. The list of countries is displayed with default country selected. User can search for specific city in specified country. Helper manage automatically the Google Place component restrictions to restrict search to the selected country. If the user selects another country, javascript snippet will change automatically this component restrictions. As soos as the user selects city in displayed list, an another input appears to find some places (establishment) in this city. By keeping this input blank, current entity will be located only with city. If user fills this input, current entity will be located both by establishment and city. If place doesn't exist, a place report request will be sent.
 *
 * ### Example of use
 *
 * You can use this function by using $countries and $defaultCountry variable which are retrieved by the PlaceHandler component
 *
 * {{{
 * $this->Places->autocompleteEstablishmentsInCity($countries, $defaultCountry);	
 * }}}
 *
 * @param array $countries List of countries (directly available in view thanks to PlaceHandler component)
 * @param string $iso2 The alpha-2 ISO 3166-1 country code
 * @param array $autocompleteInputOptions Same array options than FormHelper::input() array options
 * @param array $defaultValues Default values used to prefill form
 * @see PlacesController::handleCityAutocomplete()
 * @see PlacesController::handleEstablishmentAutocomplete()
 * @see PlacesController::handleGeocodeAutocomplete()
 * @see PlacesController::handleAddPlace()
 */
	public function autocompleteEstablishmentsInCity($countries, $iso2, $autocompleteInputOptions = array(), $defaultValues = array()) {
		$this->defaultCountry = strtoupper($iso2);
		$countriesInput = 'countries_autocomplete';
		$establishmentAutocomplete = 'establishment_autocomplete';
		$establishmentID = 'Localization.establishment_id';
		$establishmentReference = 'Localization.establishment_reference';
		$classEstablishmentID = 'establishmentID';
		$classEstablishmentReference = 'establishmentReference';

		$countriesInputDefault = (!empty($defaultValues['Place']['Country']['iso'])) ? $defaultValues['Place']['Country']['iso'] : $this->defaultCountry;
		$establishmentIDdefault = (!empty($defaultValues['Place']['Place']['id'])) ? $defaultValues['Place']['Place']['id'] : '';
		$establishmentReferenceDefault = (!empty($defaultValues['Place']['Place']['reference'])) ? $defaultValues['Place']['Place']['reference'] : '';

		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries, 'default' => $countriesInputDefault));
		$this->_setAutocomplete(self::CITIES_SEARCH, $countriesInput, array('placeholder' => __('Establishment\'s city')), $countriesInputDefault, false, $defaultValues);

		echo $this->Form->hidden($establishmentID, array('id' => $establishmentID, 'class' => $classEstablishmentID, 'value' => $establishmentIDdefault));
		echo $this->Form->hidden($establishmentReference, array('id' => $establishmentReference, 'class' => $classEstablishmentReference, 'value' => $establishmentReferenceDefault));
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

	/*public function autocomplete($countries, $type = self::CITIES_SEARCH, $iso2 = "AD", $autocompleteInputOptions = array()) {
		$this->defaultCountry = $iso2;
		$countriesInput = 'countries_autocomplete';
		
		echo $this->Form->input($countriesInput, array('id' => $countriesInput, 'options' => $countries, 'default' => $iso2));
		$this->_setAutocomplete($type, $countriesInput, $autocompleteInputOptions);
	}*/

/**
 * Handles the city autocomplete part
 *
 * @param string $type The autocomplete type
 * @param array $countriesInput The list of countries
 * @param array $autocompleteInputOptions Same array options than FormHelper::input() array options
 * @param string $defaultCountry The default country (alpha-2 ISO 3166-1 country code)
 * @param boolean $printJS If set to true `inline` key of HtmlHelper::scriptStart() will be set to true
 * @param array $defaultValues Default values used to prefill form
 */
	private function _setAutocomplete($type, $countriesInput, $autocompleteInputOptions, $defaultCountry = null, $printJS = false, $defaultValues = array()) {
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

		//determines if the place is just a geocode/city/establishment or if the place was store with city
		$wichPlace = isset($defaultValues['Place']['PlaceIn']) ? 'PlaceIn' : 'Place';
		$placeIDdefault = !empty($defaultValues['Place'][$wichPlace]['id']) ? $defaultValues['Place'][$wichPlace]['id'] : '';
		$countryIDdefault = $defaultCountry;
		$placeReferenceDefault = !empty($defaultValues['Place'][$wichPlace]['reference']) ? $defaultValues['Place'][$wichPlace]['reference'] : '';


		echo $this->Form->hidden($countryID, array('id' => $countryID, 'class' => $classCountryID, 'value' => $countryIDdefault));
		echo $this->Form->hidden($placeID, array('id' => $placeID, 'class' => $classPlaceID, 'value' => $placeIDdefault));
		echo $this->Form->hidden($placeReference, array('id' => $placeReference, 'class' => $classPlaceReference, 'value' => $placeReferenceDefault));

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
		$autocompleteInputOptions = Hash::merge($autocompleteInputOptions, array('id' => $autocompleteInput));

		echo $this->Form->input($autocompleteInput, $autocompleteInputOptions);
		$this->Html->scriptStart(array('inline' => $printJS));
		?>
			var gpInput = new GooglePlacesAutocompleteInput(
				'<?php echo $autocompleteInput;?>', {
					types: ['<?php echo $type;?>'],
					componentRestrictions: {country: '<?php echo strtolower($countryIDdefault);?>'}
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

/**
 * Handles the place report by displaying input and do some javascript stuff
 *
 * @param array $countriesInput The list of countries
 * @param string $country The alpha-2 ISO 3166-1 country code
 * @param string $cityName The name of the city
 * @param array $types The list of types. See GooglePlacesAPI::addSupportedPlaceTypes
 */
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

/**
 * Display one line localization in a Google Maps way by default. You can adjust the template by using :place, :city and :country to display place's name, city's name and country's name
 *
 * @param array $localizationData The localization's data
 * @param string $template The message's template. Use :place, :city and :country to display respective names
 * @return string The one line localization data
 */	
	public function oneLineLocalization($localizationData, $template = ':place, :city, :country') {
		$placeName = $localizationData['Place']['Place']['name'];
		$placeCity = !empty($localizationData['Place']['PlaceIn']) ? $localizationData['Place']['PlaceIn']['name'] : false;
		$country = $localizationData['Place']['Country']['name'];

		$template = ($placeCity === false) ? str_replace(':city ', '', $template) : $template;
		return String::insert($template, array(
			'place' => $placeName,
			'city' => $placeCity,
			'country' => $country
		));
	}

}

?>