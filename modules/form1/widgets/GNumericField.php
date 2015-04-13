<?php
class GNumericField extends GTextField {
	public $min = null;
	public $max = null;
	public $integer = true;
	public function getRules() {
		$rule = array (
				'numerical' 
		);
		if ($this->integer)
			$rule ['integerOnly'] = $this->integer;
		if (isset ( $this->min ))
			$rule ['min'] = $this->min;
		if (isset ( $this->max ))
			$rule ['max'] = $this->max;
		$this->_rules [] = $rule;
		return parent::getRules ();
	}
}

?>
