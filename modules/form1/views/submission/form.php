<?php
Yii::app ()->clientScript->registerScript ( "formScript-$form->id", isset ( $_GET ['scroll'] ) ? '$("html, body").animate({scrollTop: $("#' . $_GET ['scroll'] . '").offset().top}, 250);' : '$("html, body").animate({scrollTop: "0px"}, 250);' );
$formWidget = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'FormPage-' . $form->name 
) );
echo $formWidget->errorSummary ( $model, "", "", $htmlOptions = array (
		'class' => 'errorSummary alert alert-danger' 
) );
Yii::app ()->controller->setVar ( 'model', $model );
foreach ( $form->children as $field ) {
	$field->submission = $model;
	echo GElementRenderer::renderElement ( $field );
}
echo CHtml::openTag ( 'div', array (
		'class' => 'form-actions' 
) );
echo CHtml::button ( 'Save', array (
		'type' => 'submit',
		'class' => 'btn btn-large btn-primary' 
) );
echo CHtml::resetButton ( 'Restore', array (
		'class' => 'btn btn-large btn-primary' 
) );
echo CHtml::ajaxButton ( 'Clear', '#', array (), array (
		'class' => 'btn btn-large btn-primary clear',
		'onclick' => '$(".GForm form").clearForm();' 
) );
echo CHtml::closeTag ( 'div' );
$this->endWidget ();
?>