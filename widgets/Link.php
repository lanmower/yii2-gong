<?php

namespace almagest\gong\widgets;

use yii\helpers\Html;
use yii\helpers\Url;

class Link extends \yii\base\Widget {
	public $text = '';
	public $url = '';
	public $htmlOptions = [];
	public function init() {
		$this->htmlOptions ['href'] = Url::to ( $this->url  );
		echo Html::beginTag ( 'a', $this->htmlOptions );
	}
	function run() {
		echo $this->text;
		
		echo Html::endTag ('a');
	}
}
