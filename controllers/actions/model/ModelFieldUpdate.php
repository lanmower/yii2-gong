<?php
namespace almagest\gong\controllers\actions\model;

class ModelFieldUpdate extends CAction {
	public function run($id, $attribute, $value) {
		$model = $this->controller->loadModel ( $id );
		$model->setAttribute ( $attribute, $value );
		$model->save ();
		$this->controller->render ( 'fieldUpdateDone', array (
				'model' => $model 
		) );
	}
}
?>
