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
use devgroup\jsoneditor\Jsoneditor;
use yii\helpers\Html;
use yii\base\Behavior;
use yii\helpers\Json;

class ParamsController extends Behavior {
	function actionUpdate() {
		return $this->owner->renderContent(Html::beginForm().Jsoneditor::widget(['name'=>'params', 'value'=>Json::encode(\Yii::$app->params)]).Html::endForm());
	}
}

?>
