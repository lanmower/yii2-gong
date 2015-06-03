<?php

namespace almagest\gong\models\behaviors;

use yii\base\Behavior;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\db\ActiveRecord;
use yii\base\InvalidParamException;
use yii\web\HttpException;

class JSONField extends Behavior {
	public $field;
	public $output;

	public function events() {
		return [
				ActiveRecord::EVENT_AFTER_FIND => 'json'
		];
	}
	
	private static function getVar($var, $params = null) {
		if(isset($params)) return $params[$var];
		return \Yii::$app->controller->$var;
	}
	public static function startswith($haystack, $needle) {
		return substr ( $haystack, 0, strlen ( $needle ) ) === $needle;
	}
	
	public static function process(&$options, $model = null, $params = null) {
		array_walk_recursive ( $options, function (&$value, $key) use($options, $model, $params) {
			if (is_string ( $value )) {
				if (self::startswith ( $value, 'var:' )) {
					$exp = explode ( 'var:', $value );
					$value = self::getVar ( $exp [1] , $params);
					return $value;
				} else if (self::startswith ( $value, 'url:' )) {
					$exp = explode ( 'url:', $value );
					$value = Yii::$app->controller->createUrl ( CHtml::normalizeUrl ( $exp [1] ) );
					return $value;
				}
				$value = preg_replace_callback ( '/{var:([\w,.]+)}/', function ($matches) use($options, $model, $params) {
					$var = self::getVar ( $matches [1], $params );
					if (isset ( $var ) || is_null ( $var ))
						return $var;
					else {
						return [
								'Variable:' . $matches [1] . ' not found ' . isset($model)?' in '.$model->name:0,
								CVarDumper::dump ( Yii::app ()->controller->vars, 3, true )
						];
					}
				}, $value );
				$value = preg_replace_callback ( '/{url:([\w,.\/]+)}/', function ($matches) {
					return Yii::$app->controller->createUrl ( CHtml::normalizeUrl ( $matches [1] ) );
				}, $value );
			}
		} );
		
	}
	
	public function json() {
		$field = $this->field;
		$options = $this->owner->$field;
		
		try {
			$options = Json::decode ( $options, true );
		} catch ( InvalidParamException $e ) {
			$options = [];
			throw new HttpException(500, 'Invalid JSON string: '.$this->owner->$field."\nModel name:".VarDumper::dumpAsString($this->owner->_conf['table'], 3, false));
		}
		if(!isset($options))$options = [];
		$model = $this->owner;
		self::process($options, $model);
		$output = $this->output;
		$this->owner->$output = $options;
		return $options;
	}
}