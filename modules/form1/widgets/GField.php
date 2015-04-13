<?php
class GField extends GTag {
	public $_rules = array ();
	public $required = true;
	public $safe = true;
	public $inline = false;
	public $requiredMark = "&nbsp;<span class='required'>*</span>";
	public $formClass = "GSubmission";
	public $labelOptions = array ();
	public $label;
	public $depends = null;
	public $dependsValue = null;
	public $name;
	public $submission;
	public function beforeInit() {
		if (! isset ( $this->submission ))
			$this->submission = $this->controller->getVar ( 'model' );
		if (! isset ( $this->name ) && isset ( $this->model ) && isset ( $this->model->name ))
			$this->name = $this->model->name;
		if (! isset ( $this->label ) && isset ( $this->name ))
			$this->label = ucfirst ( G::splitCamelCase ( $this->name ) );
		$this->addClass ( $this->id );
		$this->addClass ( "{$this->formClass}_{$this->name}" );
		if ($this->inline)
			$this->addClass ( 'inline' );
		if (isset ( $this->depends ) && isset ( $this->dependsValue ))
			$this->script [] = "
                var changer = function(e) {
                    if($(this).val() != '$this->dependsValue') {
                        $('#$this->id').hide();
                    } else {
                        $('#$this->id').show();
                    }
                };
                $('#{$this->formClass}_$this->depends').each(changer).change(changer);
                ";
	}
	public function init() {
		$this->beforeInit ();
		parent::init ();
		$this->drawLabel ();
	}
	public function run() {
		if (! $this->inline && isset ( $this->submission )) {
			echo CHtml::error ( $this->submission, $this->name );
		}
		parent::run ();
	}
	public function drawLabel() {
		if (isset ( $this->label ) && ! empty ( $this->label )) {
			echo CHtml::label ( $this->label, $this->name, $this->labelOptions );
			if (isset ( $this->requiredMark ) && $this->required)
				echo $this->requiredMark;
		}
	}
	public function getRules() {
		$rules = $this->_rules;
		if ($this->required)
			$rules = array_merge ( $rules, array (
					'required' 
			) );
		$rules = array_merge ( $rules, array (
				'safe' 
		) );
		return $rules;
	}
	public function getCell($value) {
		return $value;
	}
	public function getValue($value) {
		return $value;
	}
	public function getSqlString() {
		return "`$this->name` varchar(255) COLLATE utf8_swedish_ci NOT NULL";
	}
	public function getGridColumns() {
		return array (
				array (
						'name' => $this->name,
						'class' => 'GFieldEditableColumn' 
				) 
		);
	}
}

?>
