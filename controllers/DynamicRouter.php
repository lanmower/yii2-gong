<?php

namespace almagest\gong\controllers;

use yii\base\Controller;
use almagest\gong\widgets\WidgetList;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use almagest\gong\modules\form\components\DynamicBehavior;
use almagest\gong\components\DynamicRecord;
use yii\helpers\Url;
use m2m\controllers\SiteController;

/**
 * The dynamic router can render posing as dynamic, db driven 'controllers' with their own actions via behavior sets
 * 
 * @author James Vos
 *        
 */
class DynamicRouter extends DynamicController {
	public $_conf;
	public $viewPath;
	public function getViewPath() {
		if (isset ( $_GET ['url'] ))
			$route = $_GET ['url'];
		else
			$route = '';
		
		$action = basename ( $route );
		$path = substr ( $route, 0, - strlen ( $action ) - 1 );
		
		if (isset ( $this->viewPath ))
			return $this->viewPath . DIRECTORY_SEPARATOR . $path;
		return parent::getViewPath ();
	}
	public function actionIndex() {
		return $this->render ( 'index.json' );
	}
	public function actionBackendroute() {
		$this->layout = 'backend';
		$this->prefix = 'backend_';
		\Yii::$app->urlManager->baseUrl = \Yii::$app->urlManager->baseUrl . '/backend';
		return $this->owner->actionRoute ();
	}
	public function getRoute() {
		if (isset ( $_GET ['url'] ))
			$route = $_GET ['url'];
		else
			$route = '';
		$action = basename ( $route );
		$path = substr ( $route, 0, - strlen ( $action ) - 1 );
		return $path . '/' . $action;
	}
	public function getUniqueId() {
		if (isset ( $_GET ['url'] ))
			$route = $_GET ['url'];
		else
			$route = '';
		
		$action = basename ( $route );
		$path = substr ( $route, 0, - strlen ( $action ) - 1 );
		
		$uniqueid = basename ( $path );
		// $path = substr ( $path, 0, - strlen ( $uniqueid ) - 1 );
		return $path;
	}
	public function actionRoute() {
		if (isset ( $_GET ['url'] ))
			$route = $_GET ['url'];
		else
			$route = '';
		$action = basename ( $route );
		$path = substr ( $route, 0, - strlen ( $action ) - 1 );
		if (substr ( $path, 0, strlen ( 'gong' ) ) === 'gong')
			$this->viewPath = '@vendor/almagestfraternite/yii-gong/views';
		$controller = \Yii::$app->params[$this->prefix . 'controller'][$path];
		if ($controller) {
			\Yii::configure ( $this, $controller['settings']);
			$this->attachBehaviors ( $this->_conf ['behaviors'] );
			$action = 'action' . ucfirst ( $action );
			// $this->id = $path;
			DynamicRecord::done ();
			if ($action == 'action') {
				return $this->actionIndex ();
			}
			return $this->$action ();
		} else {
			throw new HttpException ( 404, "The controller you have requested $path can not be found." );
		}
		$this->viewPath = null;
	}
}

?>