<?php
class GHiddenField extends GField {
	public $fieldOptions = array ();
	public function run() {
		echo CHtml::activeHiddenField ( $this->submission, "{$this->name}", $this->fieldOptions );
		parent::run ();
	}
	public function drawLabel() {
		return;
	}
}

?>
