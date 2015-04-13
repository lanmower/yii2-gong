<?php
class GFieldEditableColumn extends CDataColumn {
	protected function renderDataCellContent($row, $data) {
		echo Yii::app ()->controller->widget ( 'GInlineEditable', array (
				'pk' => CHtml::value ( $data, 'id' ),
				'htmlOptions' => array (
						'id' => $this->id . '-' . $data ['id'] . '-editor',
						'class' => 'titleEditor' 
				),
				'url' => Yii::app ()->controller->createUrl ( $data->controllerId . '/inlineUpdate', array (
						'id' => $data->form->hash 
				) ),
				'name' => $this->name,
				'value' => $data [$this->name],
				'type' => 'text' 
		), true );
	}
}

?>
