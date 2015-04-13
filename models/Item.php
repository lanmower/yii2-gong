<?php
namespace almagest\gong\models;

use almagest\gong\models\behaviors\JSONField;

class Item extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%item}}';
    }
    public function behaviors() {
                return [
                        'JSONField' => [
                                'class' => 'almagest\gong\models\behaviors\JSONField',
                        		'field' => 'settings'
                        ],
                ];
    }
}
?>