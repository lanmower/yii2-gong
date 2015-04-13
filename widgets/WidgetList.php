<?php

namespace almagest\gong\widgets;

use almagest\gong\models\Item;
use almagest\gong\models\View;
class WidgetList extends \yii\base\Widget {
	public $list;
	
	public function run() {
		foreach ( $this->list as $key => $child ) {
			echo WidgetView::widget(['item'=>$child]);
		}
	}
	
	public static function draw($type, $name) {
		$group = $type::findOne(['name'=>$name]);
		if(isset($group)) $list = $group->getItems()->all();
		if(empty($list)) return false;		
		return self::widget(['list'=>$list]);
	}
}
