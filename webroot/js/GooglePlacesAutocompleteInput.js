function GooglePlacesAutocompleteInput(inputField, autoCompleteOptions) {
	this.inputField = document.getElementById(inputField),
	this.autoCompleteOptions = autoCompleteOptions;
	this.autocomplete = new google.maps.places.Autocomplete(this.inputField, this.autoCompleteOptions);
	this.place = null;

	this.addPlaceChangedListener = function(gpInputRef) {
		google.maps.event.addListener(gpInputRef.autocomplete, 'place_changed', function() {
			place = gpInputRef.autocomplete.getPlace();
			place.geometry.location.lat = place.geometry.location.lat();
			place.geometry.location.lng = place.geometry.location.lng();
			gpInputRef.place = place;
		});
	}

	this.addPlaceChangedListener(this);
}