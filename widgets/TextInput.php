<?php

namespace almagest\gong\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class TextInput extends \yii\base\Widget {
	public $attribute;
	public $model;
	public $htmlOptions = [];
	public $label = null;
	function run() {
		if(isset($this->label)) echo $this->label.'&nbsp;';
		echo Html::activeTextInput($this->model, $this->attribute,$this->htmlOptions);
	}
}
