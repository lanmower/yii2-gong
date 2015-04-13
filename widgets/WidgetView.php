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
		$className = $this->item->className;
		
		if ($this->item->mode != 'end') {
			$this->id = $this->prefix.$this->item->id;
			echo $this->item->prefix;
			$class = substr ( $this->item->className, strrpos ( $this->item->className, '\\' ) + 1 );
			//echo "<div id='$this->id' class='{$class}'>";
			if(property_exists($className, '_contents')) {
				$this->item->settings['_contents']=$this->contents;
			}
			if(property_exists($className, 'htmlOptions')) {
				$this->addClass($this->item->settings['htmlOptions']['class'], $class);
				$this->addClass($this->item->settings['htmlOptions']['id'], $this->id);
			}
			$className::begin ( $this->item->settings );
		}
		
		if ($this->item->mode != 'begin') {
			echo $this->item->content;
			$className::end ();
			//echo '</div>';
			echo $this->item->suffix;
		}
	}
}
