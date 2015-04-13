<?php

namespace almagest\gong\components;

use yii\base\Controller;
use almagest\gong\widgets\WidgetList;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use almagest\gong\modules\form\components\DynamicBehavior;

/**
 * The Gong dynamic router can render posing as dynamic, db driven 'controllers' with their own actions via behavior sets
 * @author thinkpad
 *
 */
class DynamicRouter extends DynamicController {
	public $_conf;
	public $viewPath;
	
	public function getViewPath() {
		if(isset($this->viewPath)) return  $this->viewPath.DIRECTORY_SEPARATOR . $this->id;
		return parent::getViewPath();	
	}
	public function actionIndex() {
		return $this->render ( 'index' );
	}
	
	public function actionRoute() {
		$route = $_GET ['url'];
		$action = basename ( $route );
		$path = substr ( $route, 0, - strlen ( $action ) - 1 );
		if(substr($path, 0, strlen('gong')) === 'gong') $this->viewPath = '@vendor/almagestfraternite/yii-gong/views';
		
		$controller = DynamicRecord::forTable ( 'controller', DynamicRecord::$JSON_SETTINGS )->findOne ( [
				'path' => $path
		] );
		
		
		if ($controller) {
			\Yii::configure ( $this, $controller->settings );
			$this->attachBehaviors ( $this->_conf ['behaviors'] );
			$action = 'action'.ucfirst($action);
			$this->id = $path;
			DynamicRecord::done();
			if($action == 'action') {
				return $this->actionIndex();
			}
			return $this->$action();
		} else {
			throw new HttpException ( 404, "The controller you have requested $path can not be found." );
		}
		$this->viewPath = null;
	}
	
}

?>
