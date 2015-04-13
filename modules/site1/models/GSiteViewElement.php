<?php
Yii::import ( "gong.modules.site.models.GSiteTemplate" );
class GSiteViewElement extends GElement {
	public $parentClass = 'GSiteView';
	public function tableName() {
		return '{{site_view_element}}';
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
?>
