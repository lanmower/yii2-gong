<?php
namespace almagest\gong\controllers\actions\model;

class ModelCreate extends Action {
	public function run() {
		$className = $this->controller->modelClassname;
		$model = new $className ();
		$model->attributes = $_GET;
		if (isset ( $_POST [$className] )) {
			
			$model->attributes = $_POST [$className];
			if ($model->save ()) {
				$this->controller->render ( 'createDone', array (
						'model' => $model 
				) );
				Yii::app ()->end ();
			}
		}
		$this->controller->render ( 'create', array (
				'model' => $model 
		) );
	}
}
?>
