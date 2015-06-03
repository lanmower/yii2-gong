<?php

namespace almagest\gong\widgets;

use almagest\gong\modules\view\models\Item;
use almagest\gong\modules\view\models\View;
use yii\helpers\VarDumper;
use almagest\gong\components\DynamicRecord;
use kato\sirtrevorjs\SirTrevor;
use almagest\gong\assets\SirGongAsset;

class SirGong extends SirTrevor {

	public function registerAsset() {
        $this->blockTypes = ["Widget", "Heading", "Text", "List", "Quote", "Image", "Video", "Textimage"];
		$view = $this->getView();
		parent::registerAsset();
		$asset = SirGongAsset::register($view);
	}
}
