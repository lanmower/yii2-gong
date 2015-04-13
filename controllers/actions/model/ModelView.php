<?php
namespace almagest\gong\controllers\actions\model;

class ModelView extends Action {
	public function run($id) {
		$model = $this->controller->loadModel ( $id );
		$this->controller->render ( 'view', array (
				'model' => $model,
		) );
	}
}
?>
