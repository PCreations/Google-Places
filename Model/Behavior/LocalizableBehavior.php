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
		return $model->Localization->Place->Country->find('list');
	}

	/*public function beforeSave(Model $model) {
		die(debug($model->data));
		return false;
	}*/

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
		$model->Localization->set(array(
			'Localization' => $model->data['Localization']
		));
		return $model->Localization->validates();
	}

	public function afterSave(Model $model, $created) {
		if($created) {
			$model->data['Localization']['foreign_key'] = $model->id;
			$model->data['Localization']['model'] = $model->alias;
			$model->Localization->create();
			$model->Localization->save(array(
				'Localization' => $model->data['Localization']
			));
		}
	}
}

?>