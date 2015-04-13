<?php
class GFileField extends GField {
	public $fieldOptions = array ();
	public $appendLabel;
	public $prependLabel;
	public function beforeInit() {
		$this->required = false;
		parent::beforeInit ();
	}
	public function getRules() {
		$rules = $this->_rules;
		// if ($this->required)
		// $rules = array_merge($rules, array('required'));
		$rules = array_merge ( $rules, array (
				'safe' 
		) );
		return $rules;
	}
	public function run() {
		if (isset ( $this->prependLabel )) {
			$this->addClass ( 'input-prepend' );
			echo CHtml::tag ( 'span', array (
					"class" => "input-group-addon add-on" 
			), $this->prependLabel, true );
		}
		
		echo CHtml::activeFileField ( $this->submission, "{$this->name}", $this->fieldOptions );
		if (isset ( $this->appendLabel )) {
			$this->addClass ( 'input-append' );
			echo CHtml::tag ( 'span', array (
					"class" => "input-group-addon add-on" 
			), $this->appendLabel, true );
		}
		parent::run ();
	}
	public function getBehaviors() {
		return array (
				'attachment' => array (
						'class' => 'AttachmentBehavior',
						'attribute' => $this->model->name,
						'path' => "protected/data/form_uploads/:model/:id.:ext",
						'styles' => array (
								
								// name => size
								// use ! if you would like 'keepratio' => false
								'thumb' => '!100x60' 
						) 
				) 
		);
	}
}

?>
