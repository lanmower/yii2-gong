<?php
Yii::import ( "gong.modules.site.models.GElement" );
Yii::import ( "gong.modules.site.models.GElementCollection" );
class GSiteView extends GElementCollection {
	public function getGridColumns() {
		return array_merge ( array (
				array (
						'name' => 'module',
						'class' => 'GEditableColumn' 
				),
				array (
						'name' => 'controller',
						'class' => 'GEditableColumn' 
				) 
		), parent::getGridColumns () );
	}
	public $childClass = 'GSiteViewElement';
	public function tableName() {
		return '{{site_view}}';
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function rules() {
		$rules = parent::rules ();
		$rules [] = array (
				'module, controller',
				'safe' 
		);
		return $rules;
	}
	public static function select($module, $controller, $name) {
		$model = GSiteView::model ()->find ( "name = :name AND controller = :controller AND module = :module", array (
				':name' => $name,
				':controller' => $controller,
				':module' => $module 
		) );
		if ($model)
			return $model;
			// if view not found look for map
		$model = GSiteViewMap::model ()->find ( "(name = :name OR name = '*' OR name = '') AND (controller = :controller OR controller = '*' OR name = '') AND (module = :module OR module = '*' OR name = '') ORDER BY priority ASC", array (
				':name' => $name,
				':controller' => $controller,
				':module' => $module 
		) );
		if ($model) {
			if (! $model->module || $model->module == '*')
				$model->module = $module;
			if (! $model->controller || $model->controller == '*')
				$model->controller = $controller;
			if (! $model->name || $model->name == '*')
				$model->name = $name;
			return $model->parent;
		}
	}
}

?>
