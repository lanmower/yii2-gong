<?php

namespace almagest\gong\components;

use yii\base\Controller;
use almagest\gong\widgets\WidgetList;
class DynamicController extends Controller {
	function render($view, $params = []) {
        extract($params, EXTR_OVERWRITE);
		$contents = WidgetList::draw('almagest\gong\models\View',$this->route);
		if($contents) {
			return $this->renderLayout($view, $contents);
		}
		return $this->renderLayout($view, $contents);
	}
	
	function renderLayout($view, $contents) {
		$layoutFile = $this->findLayoutFile($this->getView());
		if ($layoutFile !== false) {
			$layout = WidgetList::draw('almagest\gong\models\View',$layoutFile, $contents);
			if($layout) return $layout;
			return $this->getView()->renderFile($layoutFile, ['content' => $contents], $this);
		} else return $contents;
	}
	
}

?>
