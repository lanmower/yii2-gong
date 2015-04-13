<?php

namespace almagest\gong\controllers;

class ModelController extends Controller {
	private $_modelClassname;
	public function setModelClassname($classname) {
		$this->_modelClassname = $classname;
	}
	public function getModelClassname() {
		if (isset ( $this->_modelClassname ))
			return $this->_modelClassname;
		return str_replace ( 'Controller', '', get_class ( $this ) );
	}

	public function actions() {
		$actions = parent::actions ();
		$actions ['create'] = array (
				'class' => 'gong.components.actions.model.ModelCreate' 
		);
		$actions ['update'] = array (
				'class' => 'gong.components.actions.model.ModelUpdate' 
		);
		$actions ['delete'] = array (
				'class' => 'gong.components.actions.model.ModelDelete' 
		);
		$actions ['list'] = array (
				'class' => 'gong.components.actions.model.ModelList' 
		);
		$actions ['inlineUpdate'] = array (
				'class' => 'gong.components.actions.model.ModelInlineUpdate' 
		);
		$actions ['view'] = array (
				'class' => 'gong.components.actions.model.ModelView' 
		);
		$actions ['reorder'] = array (
				'class' => 'gong.components.actions.model.ModelReorder' 
		);
		return $actions;
	}

	public function loadModel($id) {
		$className = $this->modelClassname;
		$model = $className::model ()->findByPk ( $id );
		$this->setVar ( 'model', $model );
		if ($model == null)
			throw new CHttpException ( 404, 'The requested item was not found.' );
		return $model;
	}
}

?>
