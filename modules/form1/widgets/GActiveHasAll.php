<?php
class GActiveHasAll extends GField {
	public $formName;
	public function getRelations() {
		if (!isset ( $this->formName )) return array();
		$ret = array(
				$this->name => array('formName'=>$this->formName, 'type'=>"HasAllRelation")
		);
		return $ret;
	}
	public function getCell($value) {
		return "";
	}
	public function getSqlString() {
		return "";
	}
	public function getRules() {
		return array();
	}
	
	public function getGridColumns() {
		return array (
		);
	}
		
}

?>