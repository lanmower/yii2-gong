<?php

namespace almagest\gong\components;

use yii\web\Controller;
use almagest\gong\widgets\WidgetList;
use yii\helpers\VarDumper;
use yii\web\HttpException;

/**
 * The gong Dynamic Controller can render dynamic views
 * @author James Vos
 *
 */
class DynamicController extends Controller {

	function render($view, $params = []) {
		extract ( $params, EXTR_OVERWRITE );
		if(!$this->id) $this->id = 'site';
		$contents = WidgetList::draw ( DynamicRecord::forModel ( 'gong/site/view' ),$this->id.'/'.$view );
		DynamicRecord::done();
		if (!$contents) {
			$contents = $this->getView ()->render ( $view, $params, $this );
		}
		return $this->renderLayout ( $contents );
	}

	private function findLayoutAlias() {
		$module = $this->module;
		if (is_string ( $this->layout )) {
			$layout = $this->layout;
		} elseif ($this->layout === null) {
			while ( $module !== null && $module->layout === null ) {
				$module = $module->module;
			}
			if ($module !== null && is_string ( $module->layout )) {
				$layout = $module->layout;
			}
		}
		
		if (! isset ( $layout )) {
			return false;
		}
		return $layout;
	}
	
	function renderLayout($contents) {
		$layoutFile = $this->findLayoutFile ( $this->getView () );
		$layoutAlias = $this->findLayoutAlias ( $this->getView () );
		if ($layoutFile !== false) {
			$layout = WidgetList::draw ( DynamicRecord::forModel ( 'gong/site/layout' ), $layoutAlias, $contents );
			DynamicRecord::done();
			if ($layout) {
				return $this->getView ()->renderFile ( '@app/views/layouts/dynamic.php', [ 
						'content' => $layout 
				], $this );
			}
			return $this->getView ()->renderFile ( $layoutFile, [ 
					'content' => $contents 
			], $this );
		} else
			return $contents;
	}
}

?>
