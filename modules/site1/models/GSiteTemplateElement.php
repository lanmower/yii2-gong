<?php
Yii::import ( "gong.modules.site.models.GSiteTemplate" );
class GSiteTemplateElement extends GElement {
	public $parentClass = 'GSiteTemplate';
	public function tableName() {
		return '{{site_template_element}}';
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
?>
