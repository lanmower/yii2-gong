<?php
$list = $this->widget ( 'GPostFileList', array (
		'post' => $model,
		'type' => $type 
), true );
$output = CHtml::tag ( 'div', array (
		'class' => 'files well PostFileGroup-' . $model->hash 
), $list );
if (! empty ( $list )) {
	echo CHtml::tag ( 'div', array (
			'class' => 'liveDialog',
			'data-dialogClass' => $type . 'dialog-' . $model->hash 
	), $output );
}
?>
