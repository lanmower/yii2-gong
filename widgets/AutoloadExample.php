<?php

namespace almagest\gong\widgets;

/**
 * This is just an example.
 */
class AutoloadExample extends \yii\base\Widget {
	public $test = 'change me';
	public function run() {
		return "Hello! " . $this->test;
	}
}
