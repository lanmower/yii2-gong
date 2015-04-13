<?php
class GButton extends GField {
	public $buttonLabel = '';
	public $buttonOptions = array ();
	public function init() {
		$this->label = '';
		$this->requiredMark = false;
		$this->required = false;
		parent::init ();
		$this->buttonOptions ['name'] = get_class ( $this->submission ) . '[' . $this->name . ']';
		$this->buttonOptions ['value'] = CHtml::value ( $this->submission, $this->name );
		if ($this->buttonOptions ['value'] == null)
			$this->buttonOptions ['value'] = true;
	}
	public function run() {
		echo BsHtml::button ( $this->buttonLabel, $this->buttonOptions );
		parent::run ();
	}
}

?>
