<?php
Yii::import ( "gong.modules.site.models.GElement" );
Yii::import ( "gong.modules.site.models.GElementCollection" );
class GSiteTemplate extends GElementCollection {
	public $childClass = 'GSiteTemplateElement';
	public function tableName() {
		return '{{site_template}}';
	}
	public static function select($name) {
		$model = self::model ()->find ( "name = '$name'" );
		if ($model)
			return $model;
		else
			return false;
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}