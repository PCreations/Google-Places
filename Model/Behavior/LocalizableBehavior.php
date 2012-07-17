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

		if(!$model->Behaviors->attached('Containable')) {
			$model->Behaviors->attach('Containable', array('autoFields' => false));
		}
		$model->contain(array(
			'Localization' => array(
				'Place' => array(
					'PlaceType',
					'Country'
				)
			)
		));
	}

	public function getCountriesList($model) {
		return $model->Localization->Place->Country->find('list');
	}
}

?>