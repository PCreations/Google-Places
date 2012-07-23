function GooglePlacesAutocompleteInput(inputField, autoCompleteOptions, countryField, placeChangedCallback) {
	this.inputField = document.getElementById(inputField),
	this.autoCompleteOptions = autoCompleteOptions;
	this.autocomplete = new google.maps.places.Autocomplete(this.inputField, this.autoCompleteOptions);
	this.place = null;
	this.countryField = countryField;
	this.placeChangedCallback = placeChangedCallback;

	this.addPlaceChangedListener = function(_this) {
		google.maps.event.addListener(_this.autocomplete, 'place_changed', function() {
			place = _this.autocomplete.getPlace();
			place.geometry.location.lat = place.geometry.location.lat();
			place.geometry.location.lng = place.geometry.location.lng();
			_this.place = place;
			if(_this.placeChangedCallback != null) {
				_this.placeChangedCallback();
			}
		});
	};

	this.addAutomaticRestrictions = function(_this) {
		$('#' + _this.countryField).change(function() {
			var countryISO = $('#' + _this.countryField + ' option:selected').val();
			_this.autocomplete.setComponentRestrictions({country: ''+countryISO+''});
		});
	};

	this.addPlaceChangedListener(this);
	this.addAutomaticRestrictions(this);
}