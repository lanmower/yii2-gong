<?php
Yii::import ( "gong.modules.site.models.GSiteTemplate" );
class GSitePageElement extends GElement {
	public $parentClass = 'GSitePage';
	public function tableName() {
		return '{{site_page_element}}';
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
?>
