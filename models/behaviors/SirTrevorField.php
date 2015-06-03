<?php

namespace almagest\gong\models\behaviors;

use yii\base\Behavior;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\db\ActiveRecord;
use yii\base\InvalidParamException;
use yii\web\HttpException;

class SirTrevorField extends Behavior {
	public $field;
	public $output;

	public function events() {
		return [
				ActiveRecord::EVENT_AFTER_FIND => 'convert'
		];
	}
	
	private static function getVar($var) {
		return \Yii::$app->controller->$var;
	}
	public static function startswith($haystack, $needle) {
		return substr ( $haystack, 0, strlen ( $needle ) ) === $needle;
	}
	public function convert() {
		$field = $this->field;
		$output = $this->output;
		
		//try {
			$convertor = new \kato\sirtrevorjs\SirTrevorConverter();
			$this->owner->$output = $convertor->toHtml($this->owner->$field);
		//} catch (\ErrorException $e) {
			
		//}
		return $this->owner->$output;
	}
}