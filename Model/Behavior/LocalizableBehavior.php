<?php
/**
 * GooglePlaces Plugin
 * 
 * Licensed under Creative Commons BY-SA
 * Redistribution of files must retain the above copyright notice.
 *
 * @link	
 * @license CC BY-SA
 * @author Pierre Criulanscy
 */

/**
 * LocalizableBehavior makes any models localizable (captain obvious) by city, or by establishment in city via the Google Places API
 *
 * @package		GooglePlaces
 * @subpackage	GooglePlaces.Model.Behavior	
 */
class LocalizableBehavior extends ModelBehavior {

/**
 * Setup function. A hasOne association with Localization model is binded to the current model. By the way a belongsTo association with current model is binded to Localization model. Both are persistent.
 *
 * @param Model $model current model
 * @param array $options
 * @see Localization::__construct()
 */
	public function setup($model, $options = array()) {
		$model->bindModel(
			array(
				'hasOne' => array(
					'Localization' => array(
						'className' => 'GooglePlaces.Localized',
						'foreignKey' => 'foreign_key',
						'conditions' => array(
							'Localization.model' => $model->alias
						),
						'dependent' => true,
						'contain' => array(
							'Place'
						)
					)
				)
			),
			false
		);

		$model->Localization->bindModel(
			array(
				'belongsTo' => array(
					"{$model->alias}" => array(
						'foreignKey' => 'foreign_key'
					)
				)
			),
			false
		);
	}

/**
 * Retrieves countries list through Place model associated with Localization model
 *
 * @param Model $model current model
 * @return array $countries The countries list
 */
	public function getCountriesList(Model $model) {
		return $model->Localization->Place->Country->find('list', array(
			'order' => 'name'
		));
	}

	public function beforeSave(Model $model) {
		//return false;
	}

/**
 * Overriding model's beforeValidate method in order to validates localization data
 *
 * @param Model $model Model using this behavior
 * @return mixed False or null will abort the operation. Any other result will continue.
 */
	public function beforeValidate(Model $model) {
		//Many inputs
		
		/* Place report request */
		if(isset($model->data['Localization']['action']) && $model->data['Localization']['action'] == 'place_report') {
			/*$newPlace = array(
				'id' => $model->data['Localization']['establishment_id'],
				'reference' => 'CkQxAAAAJg9BZYZ2dxCfitgpJkSVKax4c3IVlsha_cyEoVEqBRyxojwESM3alo10OzHV-OUaVwa0KFL7WGa2Ec9C1rrmShIQvq3RFmpu2TSDvhXvGUQqbxoU9EIiSEPSArErcRCv_fpKU_P-41U',
				'status' => 'OK'
			);
			if($newPlace['status'] != 'OK') {
				die('Unable to add place. Server responded with ' . $newPlace['status'] . ' status'); 
			}*/

			/* Set up localization information et clean up unused data */
			$model->data['Localization']['establishment_id'] = $newPlace['id'];
			$model->data['Localization']['establishment_reference'] = $newPlace['reference'];
			unset($model->data['Localization']['action']);
			unset($model->data['Establishment']);
			unset($model->data['Geocode']);
		}

		if(isset($model->data['Localization'])) {
			if(isset($model->data['Localization']['establishment_id'])) {
				/* If establisment_id is empty, only city is saved */
				if(empty($model->data['Localization']['establishment_id'])) {
					unset($model->data['Localization']['establishment_id']);
					unset($model->data['Localization']['establishment_reference']);
				}
			}
			$model->Localization->set(array(
				'Localization' => $model->data['Localization']
			));
			/*if(isset($model->data['Localization']['establishment_id'])) {
				$model->Localization->validate['establishment_id'] = array(
					'notempty' => array(
						'rule' => array('notempty'),
						'message' => 'Establishment not valid, dont forget to select a place within list',
						'allowEmpty' => false,
						'required' => true,
					),
				);
			}*/
			return $model->Localization->validates();
		}
		else
			return true;
	}

/**
 * Automatically append the localization data to the model's data
 *
 * @param Model $model Model using this behavior
 * @param mixed $results The results of the find operation
 * @param boolean $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed An array value will replace the value of $results - any other value will be ignored.
 */
	public function afterFind(Model $model, $results, $primary) {
		
		foreach($results as &$result) {
			if(isset($result['Localization'])) {
				$result['Localization']['Place'] = $model->Localization->Place->find('first', array(
					'conditions' => array(
						'Place.id' => $result['Localization']['place_id'],
					),
					'fields' => array(
						'Place.id',
						'Place.country_id',
						'Place.reference',
						'Place.name',
						'Place.place_id'
					),
					'contain' => array(
						'Country' => array(
							'fields' => array(
								'Country.iso',
								'Country.name'
							)
						),
						'PlaceIn' => array(
							'fields' => array(
								'PlaceIn.name',
								'PlaceIn.reference',
							)
						)
					)
				));
			}
		}
		return $results;
	}

/**
 * Save localization data and localized association
 *
 * @param Model $model Model using this behavior
 * @param boolean $created True if this save created a new record
 * @return boolean
 */
	public function afterSave(Model $model, $created) {
		$update = false;
		$establishmentInCity = isset($model->data['Localization']['establishment_id']);
		if(!$created) {
			$localization = $model->Localization->find('first', array(
				'conditions' => array(
					'Localization.model' => $model->alias,
					'Localization.foreign_key' => $model->id,
				),
				'contain' => array()
			));
			$update = ($localization['Localization']['place_id'] != ($establishmentInCity ? $model->data['Localization']['establishment_id'] : $model->data['Localization']['place_id']));
			debug($update);
		}
		if($created || $update) {
			/* Check for saving place if not already exists in db or for place id update*/
			debug($model->data['Localization']);
			$model->Localization->Place->placeRoutine(
				$model->data['Localization']['place_id'], 
				$model->data['Localization']['place_reference'], 
				$model->data['Localization']['country_id']
			);
			
			if(isset($model->data['Localization']['establishment_id'])) {
				$model->Localization->Place->establishmentRoutine(
					$model->data['Localization']['establishment_id'], 
					$model->data['Localization']['establishment_reference'], 
					$model->data['Localization']['place_id'], 
					$model->data['Localization']['country_id']
				);
				$model->data['Localization']['place_id'] = $model->data['Localization']['establishment_id'];
				unset($model->data['Localization']['establishment_id']);
				unset($model->data['Localization']['establishment_reference']);
			}

			unset($model->data['Localization']['place_reference']);
			unset($model->data['Localization']['country_id']);

			/* Delete localized association before saving new one */
			if($update) {
				$model->Localization->delete($localization['Localization']['id']);
			}

			/* Save localized association */
			$model->data['Localization']['foreign_key'] = $model->id;
			$model->data['Localization']['model'] = $model->alias;
			$model->Localization->create();
			debug($model->data['Localization']);
			if(!$model->Localization->save(
				array(
					'Localization' => $model->data['Localization']
				),
				false
			)) {
				debug($model->Localization->validationErrors);
				die("Unable to save Localization association");
			}
		}
		else {
			$model->data['Localization']['foreign_key'] = $model->id;
			$model->data['Localization']['model'] = $model->alias;
		}
	}
}

?>