<?php

namespace almagest\gong\widgets;

class WidgetView extends \yii\base\Widget {
	public $item;
	public function run() {
		$settings = array ();
		$className = $this->item->className;
		
		if ($this->item->mode != 'end') {
			$this->id = "Item-{$this->item->id}";
			echo $this->item->prefix;
			$class = substr ( $this->item->className, strrpos ( $this->item->className, '\\' ) + 1 );
			echo "<div id='$this->id' class='{$class}'>";
			$className::begin ( $this->item->settings );
		}
		
		if ($this->item->mode != 'begin') {
			echo $this->item->content;
			$className::end ();
			echo '</div>';
			echo $this->item->suffix;
		}
	}
}
