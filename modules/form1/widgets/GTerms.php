<?php
class GTerms extends GField {
	public $htmlOptions = array ();
	public $tag = 'div';
	public $terms = 'Terms And Conditions';
	
	/*
	 * public function addClass($class, $target = null) {
	 * if($target == null) G::addClassToString($this->htmlOptions['class'], $class);
	 * G::addClassToString($target, $class);
	 * }
	 */
	public function getRules() {
		$terms_rule = array (
				'compare' => array (
						'compare',
						'compareValue' => true,
						'message' => 'You must agree to the terms and conditions' 
				) 
		);
		$this->_rules = array_merge ( $this->_rules, $terms_rule );
		return parent::getRules ();
	}
	public function init() {
		$this->htmlOptions ['style'] = "display:none";
		parent::init ();
	}
	public function run() {
		echo CHtml::tag ( $this->tag, array (), G::t ( $this->terms ) );
		parent::run ();
		echo CHtml::activeCheckBox ( $this->submission, $this->name );
		echo "I agree to the following";
		echo CHtml::link ( " (Click here to read) ", "javascript:;", array (
				"class" => "dialog",
				'data-target' => '.' . $this->id 
		) );
		echo " Terms and Conditions";
	}
}

?>
