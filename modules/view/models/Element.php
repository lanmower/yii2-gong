<?php

namespace almagest\gong\modules\view\models;

use yii\db\ActiveRecord;

/**
 * form
 * @property integer $id
 * @property string $tableName 
 */
class Element extends ActiveRecord {
	public static function tableName() {
		return "{{%element}}";
	}
	
}
