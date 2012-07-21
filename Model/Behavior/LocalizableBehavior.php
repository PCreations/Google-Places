<?php

class LocalizableBehavior extends ModelBehavior {
	
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

	public function getCountriesList(Model $model) {
		return $model->Localization->Place->Country->find('list', array(
			'order' => 'name'
		));
	}

	public function beforeSave(Model $model) {

	}

	public function beforeValidate(Model $model) {
		//Many inputs
		/*debug($model->data['Localization']);
		foreach($model->data['Localization'] as $alias => $place) {
			debug($place);
			debug(empty($place['place_id']));
			if(empty($place['place_id'])) {
				$model->invalidate('city_autocomplete_' . $alias, 'Place id not valid');
			}
		}*/
		if(isset($model->data['Localization'])) {
			$model->Localization->set(array(
				'Localization' => $model->data['Localization']
			));
			if(isset($model->data['Localization']['establishment'])) {
				$model->Localization->validate['establishment'] = array(
					'notempty' => array(
						'rule' => array('notempty'),
						'message' => 'Establishment not valid, dont forget to select a place within list',
						'allowEmpty' => false,
						'required' => true,
					),
				);
			}
			return $model->Localization->validates();
		}
		else
			return true;
	}

	public function afterSave(Model $model, $created) {
		if($created || !isset($model->data['Localization']['foreign_key'])) {
			/* Check for saving place if not already exists in db or updating place id */
			$model->Localization->Place->placeRoutine($model->data['Localization']['place_id'], $model->data['Localization']['place_reference']);
			unset($model->data['Localization']['place_reference']);

			/* Save localized association */
			$model->data['Localization']['foreign_key'] = $model->id;
			$model->data['Localization']['model'] = $model->alias;
			$model->Localization->create();
			$model->Localization->save(array(
				'Localization' => $model->data['Localization']
			));
		}
		else {
			
		}
	}
}

?>