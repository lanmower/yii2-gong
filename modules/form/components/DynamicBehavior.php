<?php

namespace almagest\gong\modules\form\components;

use yii\base\Behavior;

class DynamicBehavior extends Behavior {
	private $_vars;
	private $_methods;
	public function __call($name, $params) {
		if (substr ( $name, 0, strlen ( 'get' ) ) === 'get') {
			$varName = substr ( $str, 3 );
			if (isset ( $this->vars [$varName] ))
				return $this->vars [$varName];
		}
		if (substr ( $name, 0, strlen ( 'set' ) ) === 'set') {
			$varName = substr ( $str, 3 );
			if (isset ( $this->vars [$varName] ) && isset ( $params [0] ))
				return $this->vars [$varName] = $params [0];
		}
		if (array_key_exists ( $name, $_methods )) {
			$code = $_methods [$name];
			$exception_error_handler = function ($errno, $errstr, $errfile, $errline) {
				if (error_reporting () === 0) {
					return;
				}
				throw new ErrorException ( $errstr, 0, $errno, $errfile, $errline );
			};
			
			set_error_handler ( $exception_error_handler );
			
			if (@eval ( 'return true;' . $code ))
				return @eval ( $code ); // evaluate code parsing and then call code
			set_error_handler ( NULL );
		}
	}
}