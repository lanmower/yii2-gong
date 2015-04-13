<?php

namespace almagest\gong\modules\form\models;

use yii\db\ActiveRecord;

/**
 * form
 * 
 * @property integer $id
 * @property string $tableName
 */
class Form extends ActiveRecord {
	public static function tableName() {
		return "{{%form}}";
	}
	public function getFormAttributes($groupName) {
		$output = array ();
		foreach ( $this->children as $child ) {
			if (isset ( $child->field ))
				if (method_exists ( $child->field, $groupName )) {
					$addition = $child->field->$groupName;
					if (is_array ( $addition ))
						foreach ( $addition as $key => $value ) {
							$output [$key] = $value;
						}
					else
						$output = array (
								$child->name,
								$addition 
						);
				}
		}
		return $output;
	}
}
