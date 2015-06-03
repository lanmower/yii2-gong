<?php
namespace almagest\gong\components;

use yii\base\ViewRenderer;
use kato\sirtrevorjs\SirTrevorConverter;
use almagest\gong\models\behaviors\JSONField;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use almagest\gong\widgets\SirGongConverter;
class SirGongRenderer extends ViewRenderer {
    public function render($view, $file, $params) {
    	$data = file_get_contents($file);
    	$conv = new SirGongConverter();
    	$conv->viewParams = $params;
    	$json = Json::decode($data, true);
    	JSONField::process($json);
    	$html = $conv->toHtml($json);
    	return $html;
    }
}
