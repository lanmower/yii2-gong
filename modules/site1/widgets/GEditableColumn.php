<?php
class GEditableColumn extends CDataColumn {
	protected function renderDataCellContent($row, $data) {
		echo Yii::app ()->controller->widget ( 'GInlineEditable', array (
				'pk' => CHtml::value ( $data, 'id' ),
				'htmlOptions' => array (
						'id' => $this->id . '-' . $data ['id'] . '-editor',
						'class' => 'titleEditor' 
				),
				'url' => Yii::app ()->controller->createUrl ( $data->controllerId . "/inlineUpdate" ),
				'name' => $this->name,
				'value' => $data [$this->name],
				'type' => 'text' 
		), true );
	}
}

?>
