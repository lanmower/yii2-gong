<?php
namespace almagest\gong\models;

use almagest\gong\models\behaviors\JSONField;

class View extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%view}}';
    }

    public function getItems() {
    	return $this->hasMany(Item::className(), ['id' => 'item_id'])
    	->viaTable('view_item', ['view_id' => 'id']);
    }
}
?>