<?php
class GSiteViewMap extends GActiveRecord {
	public $gridColumns = array (
			array (
					'name' => 'module',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'controller',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'name',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'parentModule',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'parentController',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'parentName',
					'class' => 'GEditableColumn' 
			),
			array (
					'header' => 'actions',
					'class' => 'GButtonColumn',
					'template' => '{delete}' 
			) 
	);
	public function getParent() {
		if (! $this->parentName || $this->parentName == '*')
			$this->parentName = $this->name;
		if (! $this->parentController || $this->parentController == '*')
			$this->parentController = $this->controller;
		if (! $this->parentModule || $this->parentModule == '*')
			$this->parentModule = $this->module;
		return GSiteView::model ()->find ( "name = :name AND controller = :controller AND module = :module", array (
				':name' => $this->parentName,
				':controller' => $this->parentController,
				':module' => $this->parentModule 
		) );
	}
	public function tableName() {
		return '{{site_view_map}}';
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
}
?>
