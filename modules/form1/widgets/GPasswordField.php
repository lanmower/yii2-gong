<?php
class GPasswordField extends GField {
	public $fieldOptions = array ();
	public function run() {
		echo CHtml::activePasswordField ( $this->submission, "{$this->name}", $this->fieldOptions );
		parent::run ();
	}
}

?>
