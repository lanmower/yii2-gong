<?php

namespace almagest\gong\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class SubmitButton extends \yii\base\Widget {
	public $htmlOptions = [];
	public $content = 'Submit';
	function run() {
		echo Html::submitButton($this->content, $this->htmlOptions);
	}
}
