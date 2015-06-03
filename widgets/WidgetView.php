<?php

namespace almagest\gong\widgets;

use yii\helpers\VarDumper;
class WidgetView extends \yii\base\Widget {
	public $item;
	public $prefix = 'vi-';
	public $contents;
	public function addClass(&$string, $class) {
		if(!empty($string)) $string = $string.' '.$class;
		$string = $class;
	}
	
	public function run() {
		$className = $this->item['className'];
		
		if (!isset($this->item['mode']) || $this->item['mode'] != 'end') {

			if(isset($this->item['id'])) $this->id = $this->prefix.$this->item['id'];
			if(isset($this->item['prefix'])) echo $this->item['prefix'];
			$class = substr ( $this->item['className'], strrpos ( $this->item['className'], '\\' ) + 1 );
			if(property_exists($className, '_contents')) {
						$this->item['settings']['_contents']=$this->contents;
			}
			if(property_exists($className, 'htmlOptions')) {
				$this->addClass($this->item['settings']['htmlOptions']['class'], $class);
				$this->item['settings']['htmlOptions']['id'] = $this->id;
			}
			$className::begin ( $this->item['settings'] );
		}
		
		if (!isset($this->item['mode']) || $this->item['mode'] != 'begin') {
			if(isset($this->item['content'])) echo $this->item['content'];
			$className::end ();
			if(isset($this->item['suffix'])) echo $this->item['suffix'];
		}
	}
}
