<?php

namespace almagest\gong\controllers;

use yii\web\Controller;
use almagest\gong\widgets\WidgetList;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use almagest\gong\components\DynamicRecord;
use yii\base\InvalidParamException;
use yii\helpers\FileHelper;
use almagest\gong\widgets\SirGong;
use devgroup\jsoneditor\JsoneditorAsset;
use almagest\gong\widgets\PostCard;
use yii\base\ErrorException;
use yii\helpers\Html;

/**
 * dynamic views
 *
 * @author James Vos
 *        
 */
class DynamicController extends Controller {
	function render($view, $params = []) {
		$viewFile = \Yii::getAlias ( $this->getViewPath () . '/' . $view );
		if(!file_exists($viewFile) && file_exists($viewFile.'.'.$this->getView()->defaultExtension)) return parent::render($view, $params);
		try {
			$contents = file_get_contents ( $viewFile );
		} catch ( InvalidParamException $e ) {
			$data = '{}';
			$viewFile = \Yii::getAlias ( $this->getViewPath () . '/' . $view );
			file_put_contents ( $viewFile, $data );
			return parent::render ( $view, $params );
		} catch ( ErrorException $e ) {
			$data = '{}';
			$viewFile = \Yii::getAlias ( $this->getViewPath () . '/' . $view );
			file_put_contents ( $viewFile, $data );
			return parent::render ( $view, $params );
		}
		
		$widget = '<form>' . SirGong::widget ( [ 
				'name' => 'view',
				'value' => $contents 
		] ) . Html::input ( 'submit', 'submit', 'submit', [ 
				'onclick' => '$(".js-container").each(function() {$(this).prev().val( $(this).data("editor").getText());});' 
		] ) . '</form>';
		
		if (isset ( $_GET ['view'] )) {
			file_put_contents ( $viewFile, $_GET ['view'] );
			$this->redirect ( \Yii::$app->urlManager->baseUrl . '/' . $this->getRoute () );
		}
		if ($contents == '{}' || isset ( $_GET ['edit_view'] )) {
			JsoneditorAsset::register ( $this->view );
			return parent::renderContent ( '<div class="card" style="	display: block;
			position: relative;
			background-color: white;
			padding: 20px;
			width: 100%;
			font-size: 1.2rem;
			font-weight: 300;
			margin-bottom:10px">' . $widget . "</div>" );
		}
		return parent::render ( $view, $params );
	}
}

?>