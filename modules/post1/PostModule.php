<?php
Yii::setPathOfAlias ( 'post', dirname ( __FILE__ ) );
Yii::import ( 'post.models.GPost' );
class PostModule extends CWebModule {
	public $controllerMap = array (
			'file' => array (
					'class' => 'post.controllers.GPostFileController' 
			),
			'post' => array (
					'class' => 'post.controllers.GPostController' 
			) 
	); //
	public function init() {
		$this->setImport ( array (
				'post.controllers.*',
				'post.models.*' 
		) );
	}
}
