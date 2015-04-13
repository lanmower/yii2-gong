<?php
class GSubmitButton extends GField {
	public $buttonLabel = 'submit';
	public $buttonOptions = array ();
	public function init() {
		$this->requiredMark = false;
		$this->required = false;
		$this->name = false;
		parent::init ();
	}
	public function run() {
		echo CHtml::submitButton ( $this->buttonLabel, $this->buttonOptions );
		parent::run ();
	}
}

?>
