<?php
namespace almagest\gong\controllers\actions\model;

class ModelList extends CAction {
	public function run() {
		$className = $this->controller->modelClassname;
		
		$this->controller->render ( 'list', array (
				'model' => $className::model () 
		) );
	}
}

?>
