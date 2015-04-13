<?php
class GTextField extends GField {
	public $fieldOptions = array ();
	public $appendLabel;
	public $prependLabel;
	public $area = false;
	public function run() {
		if (isset ( $this->prependLabel )) {
			$this->addClass ( 'input-prepend' );
			echo CHtml::tag ( 'span', array (
					"class" => "input-group-addon add-on" 
			), $this->prependLabel, true );
		}
		if (! $this->area)
			echo CHtml::activeTextField ( $this->submission, "{$this->name}", $this->fieldOptions );
		else
			echo CHtml::activeTextArea ( $this->submission, "{$this->name}", $this->fieldOptions );
		if (isset ( $this->appendLabel )) {
			$this->addClass ( 'input-append' );
			echo CHtml::tag ( 'span', array (
					"class" => "input-group-addon add-on" 
			), $this->appendLabel, true );
		}
		parent::run ();
	}
}

?>
