<?php

namespace almagest\gong\modules\form\models;

use yii\db\ActiveRecord;

/**
 * Field
 *
 * @property integer $id
 */
class Field extends ActiveRecord {
	public static function tableName() {
		return "{{%field}}";
	}
}
