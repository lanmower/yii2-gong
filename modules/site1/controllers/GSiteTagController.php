<?php
class GSiteTagController extends GModelController {
	public function accessRules() {
		$rules = parent::accessRules ();
		self::addRule ( $rules, array (
				'allow',
				'actions' => array (
						'index' 
				),
				'users' => array (
						'*' 
				) 
		) );
		return $rules;
	}
	public function actionIndex($id) {
		$this->layout = 'application.views.layouts.main';
		$model = $this->loadModel ( $id );
		if ($model)
			$this->renderText ( $this->render ( 'index', array (
					'model' => $model 
			) ) );
		else
			throw new CHttpException ( 404, 'The specified tag was not found' );
	}
}

?>
