<?php
class GSitePageController extends GModelController {
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
	public function actionIndex($name) {
		$this->layout = 'application.views.layouts.main';
		$model = GSitePage::select ( $name );
		if ($model)
			$this->renderText ( GElementRenderer::render ( $model ) );
		else
			throw new CHttpException ( 404, 'The specified page was not found' );
	}
}

?>
