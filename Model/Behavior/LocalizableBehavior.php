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
		debug($model->data);
		$data = array(
			'Localization' => array(
				'place_id' => $model->data[$model->alias]['Localization_place_id_0']
			)
		);
		debug($data);
		$model->Localization->set($data);
		return $model->Localization->validates();
	}

	public function beforeSave(Model $model) {
		return false;
	}

	public function afterSave(Model $model, $created) {

		if($created) {
			foreach($model->data['Localization'] as &$localization) {
				$localization['foreign_key'] = $model->id;
				$localization['model'] = $model->alias;
			}
			$model->Localization->create();
			$model->Localization->save($model->data['Localization']);
		}
	}
}

?>