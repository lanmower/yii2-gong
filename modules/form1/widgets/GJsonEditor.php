<?php
class GJsonEditor extends GField {
	public $fieldOptions = array ();
	public function run() {
		$jsonEditorUrl = Yii::app ()->assetManager->publish ( 'protected/vendors/jsoneditor', false, - 1, YII_DEBUG );
		Yii::app ()->clientScript->registerScriptFile ( $jsonEditorUrl . '/jsoneditor-min.js' );
		Yii::app ()->clientScript->registerCssFile ( $jsonEditorUrl . '/jsoneditor-min.css' );
		echo CHtml::tag ( 'div', array (
				'class' => 'jsonEditor',
				'data-json' => $this->controller->getVar ( 'model' )->json 
		) );
		$name = $this->name;
		echo CHtml::hiddenField ( CHtml::resolveName ( $this->submission, $name ), '', $this->fieldOptions );
		parent::run ();
	}
	public function drawLabel() {
		return;
	}
}

?>
