<?php
class GFormElementController extends GModelController {
	public function accessRules() {
		$rules = parent::accessRules ();
		self::addRule ( $rules, array (
				'allow',
				'actions' => array (
						'getData',
						'update' 
				),
				'expression' => array (
						__CLASS__,
						'canUpdate' 
				) 
		) );
		return $rules;
	}
}

?>
