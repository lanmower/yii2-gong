<?php
class GDropDown extends GField {
	public $data = array ();
	public $other = false;
	public $otherDefault = null;
	public $otherLabel = "Please Specify";
	public function init() {
		Yii::app ()->clientScript->registerScript ( "GDropdown-$this->id-other", "
                //$('#$this->id-other').hide();
                other = $('#$this->id-other-field').val();
                console.log($('#{$this->formClass}_{$this->name} option[value=\''+other+'\']').length);
                if($('#{$this->formClass}_{$this->name} option[value=\''+other+'\']').length == 0) $('#$this->id-other').show();
                else  $('#$this->id-other').hide();
        " );
		parent::init ();
	}
	public function run() {
		echo CHtml::activeDropDownList ( $this->submission, $this->name, $this->data, array (
				'empty' => 'Please select',
				'onchange' => "$('#$this->id-other-field').val($(this).val()); if($(this).val() != 'other') { $('#$this->id-other').hide();} else { $('#$this->id-other').show(); if($('#{$this->formClass}_{$this->name} option[value=\''+$('#$this->id-other-field').val()+'\']').length > 0) $('#$this->id-other-field').val('$this->otherDefault');}" 
		) );
		echo CHtml::openTag ( 'div', array (
				'class' => $this->inline ? 'inline ' : '' . 'row dropDownother',
				'id' => $this->id . '-other' 
		) );
		if ($this->other) {
			if (isset ( $this->otherDefault ))
				$this->submission->setAttribute ( $this->name, $this->otherDefault );
			
			if (isset ( $this->otherLabel )) {
				echo CHtml::label ( $this->otherLabel, $this->name );
			}
			
			echo CHtml::activeTextField ( $this->submission, $this->name, array (
					'id' => $this->id . '-other-field' 
			) );
		}
		echo CHtml::closeTag ( 'div' );
		parent::run ();
	}
	public function getCell($value) {
		if (isset ( $this->submission )) {
			echo CHtml::form ( array (
					'submission/update',
					'id' => $_GET ['id'],
					'dataId' => PseudoCrypt::hash ( $this->submission->id ) 
			), 'post' );
			echo CHtml::activeDropDownList ( $this->submission, $this->name, $this->data, array_merge ( array (
					'empty' => 'Please select' 
			), array (
					'onchange' => '$(this.form).trigger("submit")' 
			) ) );
			echo CHtml::endForm ();
		} else
			throw new CHttpException ( 500, 'no submission set' );
	}
	
	public function getGridColumns() {
		return array (
				array (
						'name' => $this->name,
						'class' => 'GDataColumn' 
				) 
		);
	}
}

?>
