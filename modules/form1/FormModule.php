<?php
Yii::setPathOfAlias ( 'form', dirname ( __FILE__ ) );
class FormModule extends CWebModule {
	public $controllerMap = array (
			'admin' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GForm' 
			),
			'element' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GFormElement' 
			),
			'submission' => array (
					'class' => 'gong.modules.form.controllers.GSubmissionController' 
			) 
	);
	public function init() {
		Yii::app ()->setImport ( array (
				'form.components.*',
				'form.controllers.*',
				'form.models.*',
				'form.widgets.*',
				'gong.modules.widget.controllers.*' 
		) );
	}
}
