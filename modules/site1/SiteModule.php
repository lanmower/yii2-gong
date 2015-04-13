<?php
Yii::setPathOfAlias ( 'site', dirname ( __FILE__ ) );
class SiteModule extends CWebModule {
	public $controllerMap = array (
			'page' => array (
					'class' => 'site.controllers.GSitePageController' 
			),
			'dom' => array (
					'class' => 'site.controllers.GSiteDomController' 
			),
			'template' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GSiteTemplate' 
			),
			'view' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GSiteView' 
			),
			'viewMap' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GSiteViewMap' 
			),
			'pageElement' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GSitePageElement' 
			),
			'viewElement' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GSiteViewElement' 
			),
			'templateElement' => array (
					'class' => 'gong.components.GModelController',
					'modelClassname' => 'GSiteTemplateElement' 
			),
			'tag' => array (
					'class' => 'site.controllers.GSiteTagController',
					'modelClassname' => 'GSiteTemplateElement' 
			) 
	);
	public $viewControllerMap = array (
			'view' => 'elementCollection',
			'page' => 'elementCollection',
			'template' => 'elementCollection',
			'viewElement' => 'element',
			'pageElement' => 'element',
			'templateElement' => 'element' 
	);
	public function init() {
		Yii::app ()->setImport ( array (
				'site.components.*',
				'site.controllers.*',
				'site.models.*',
				'site.widgets.*',
				'site.modules.widget.controllers.*' 
		) );
	}
}
