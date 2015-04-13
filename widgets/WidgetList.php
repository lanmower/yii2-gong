<?php

namespace almagest\gong\widgets;

use almagest\gong\modules\view\models\Item;
use almagest\gong\modules\view\models\View;
use yii\helpers\VarDumper;
use almagest\gong\components\DynamicRecord;

class WidgetList extends \yii\base\Widget {
	public $list;
	public $contents;
	public function run() {
		foreach ( $this->list as $key => $child ) {
			echo WidgetView::widget ( [ 
					'item' => $child,
					'contents'=>$this->contents 
			] );
		}
	}
	public static function draw($type, $name, $contents='') {
		if($type == null) return false;
		$group = $type::findOne ( [ 
				'name' => $name 
		] );
		if($group == false) return false;
		if (isset ( $group ))
			$list = $group->getChildren()->all ();
		if (empty ( $list ))
			return '';
		DynamicRecord::done();//group
		DynamicRecord::done();//children
		return self::widget ( [ 
				'list' => $list,
				'contents'=>$contents
		] );
	}
}
