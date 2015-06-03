<?php

namespace almagest\gong\widgets;

use almagest\gong\modules\view\models\Item;
use almagest\gong\modules\view\models\View;
use yii\helpers\VarDumper;
use almagest\gong\components\DynamicRecord;
use kato\sirtrevorjs\SirTrevor;
use almagest\gong\assets\SirGongAsset;
use kato\sirtrevorjs\SirTrevorConverter;
use yii\helpers\Json;
use almagest\gong\models\behaviors\JSONField;

class SirGongConverter extends SirTrevorConverter {
	public $viewParams;
	/**
	 * Converts the widget to html
	 *
	 * @param string $className        	
	 * @param array $parmas        	
	 * @return string
	 */
	public function widgetToHtml($className, $mode, $settingsJson) {
		$params = Json::decode($settingsJson, true);
		if($params != null) JSONField::process($params, null, $this->viewParams);
		$item = [];
		$item['settings'] = $params;
		$item['className'] = $className;
		$item['mode'] = $mode;
		return WidgetView::widget ( [ 
				'item' => $item,
		] );
	}
}
