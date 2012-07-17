<?php
App::uses('GooglePlacesAppModel', 'GooglePlaces.Model');
/**
 * PlaceTypesPlace Model
 *
 * @property PlaceType $PlaceType
 * @property Place $Place
 */
class PlaceTypesPlace extends GooglePlacesAppModel {

	public $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PlaceType' => array(
			'className' => 'GooglePlaces.PlaceType',
			'foreignKey' => 'place_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true
		),
		'Place' => array(
			'className' => 'GooglePlaces.Place',
			'foreignKey' => 'place_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true
		)
	);

	public function savePlaceAndTypes($place) {
		$listType = $this->PlaceType->find('list');
		$list = (count($listType) >= count($place->types)) ? array_diff($listType, $place->types) : array_diff($place->types, $listType);
		debug($list);
		debug($place);
		$this->Place->create();
		if($this->Place->save(
			array(
				'Place' => array(
					'id' => $place->id,
					'country_id' => 'FR',
					'reference' => $place->reference,
					'name' => $place->name,
					'formatted_address' => $place->formatted_address,
					'formatted_phone_number' => (property_exists($place, 'formatted_phone_number')) ? $place->formatted_phone_number : null,
					'latitude' => $place->geometry->location->lat,
					'longitude' => $place->geometry->location->lng,
					'rating' => (property_exists($place, 'rating')) ? $place->rating : null,
				),
		))) {
			if(!empty($list)) {
				foreach($list as $placeType) {
					$this->PlaceType->create();
					if(!$this->PlaceType->save(array(
						'PlaceType' => array(
							'name' => $placeType
						)
					))) {
						throw new CakeException('Unable to save place type');
					}
				}
			}
			foreach($place->types as $type) {
				$placeType = $this->PlaceType->find('first', array(
					'contain' => array(),
					'conditions' => array(
						'PlaceType.name' => $type
					)
				));
				$this->create();
				if(!$this->save(array(
					'PlaceTypesPlace' => array(
						'place_type_id' => $placeType['PlaceType']['id'],
						'place_id' => $place->id
					)
				))) {
					throw new CakeException('Unable to save association place_types_place');
				}
			}	
		}
		else
			throw new CakeException('Unable to save place');
	}
}
